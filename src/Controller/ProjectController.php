<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Project;
use App\Entity\ProjectCheckbox;
use App\Form\ProjectFormType;
use App\Repository\CheckboxRepository;
use App\Repository\ProjectCheckboxRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProjectController extends AbstractController
{
    private CheckboxRepository $checkboxRepository;

    private ProjectRepository $projectRepository;

    /**
     * @var ProjectCheckboxRepository
     */
    private ProjectCheckboxRepository $projectCheckboxRepository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * ProjectController constructor.
     * @param CheckboxRepository $checkboxRepository
     * @param ProjectRepository $projectRepository
     * @param ProjectCheckboxRepository $projectCheckboxRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        CheckboxRepository $checkboxRepository,
        ProjectRepository $projectRepository,
        ProjectCheckboxRepository $projectCheckboxRepository,
        EntityManagerInterface $entityManager
    )
    {
        $this->checkboxRepository = $checkboxRepository;
        $this->projectRepository = $projectRepository;
        $this->projectCheckboxRepository = $projectCheckboxRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="project.new")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        $project = new Project();
        $projectForm = $this->createForm(ProjectFormType::class, $project);
        $projectForm->handleRequest($request);
        if ($projectForm->isSubmitted() && $projectForm->isValid()) {
            return $this->processFormRequest($project);
        }

        return $this->render('project/create.html.twig', [
            'projectForm' => $projectForm->createView(),
        ]);
    }

    /**
     * @Route("/project/{id}", name="project.show")
     * @param Project $project
     * @return Response
     */
    public function show(Project $project): Response
    {
        $currentFramework = (string)$project->getCurrentFramework();
        $checkboxes = $this->checkboxRepository->findByFramework($currentFramework);

        return $this->render('project/show.html.twig', [
            'project' => $project,
            'checkboxes' => $checkboxes,
        ]);
    }

    private function processFormRequest(Project $project): RedirectResponse
    {
        $targetFramework = $project->getDesiredFramework();
        $checkboxes = $this->checkboxRepository->findByFramework($targetFramework);

        foreach ($checkboxes as $checkbox) {
            $projectCheckbox = new ProjectCheckbox();
            $projectCheckbox->setProject($project);
            $projectCheckbox->addCheckbox($checkbox);
            $projectCheckbox->setIsComplete(NULL);
            $this->projectCheckboxRepository->persist($projectCheckbox);
        }

        $project->setTimezone();
        $this->projectRepository->save($project);

        return $this->redirectToRoute('project.show', ['id' => $project->getId()]);
    }


    /**
     * @Route("/project/checkbox/check", name="project.checkbox.check")
     * @param Request $request
     * @return JsonResponse
     */
    public function checkProjectCheckbox(Request $request): JsonResponse
    {
        $content = json_decode($request->getContent());
        $submittedToken = $content->token;
        $projectCheckboxId = $content->projectCheckboxId;

        if ($this->isCsrfTokenValid('check-blank-token', $submittedToken)) {

            /**
             * @var ProjectCheckbox $projectCheckbox
             */
            $projectCheckbox = $this->entityManager->getRepository(ProjectCheckbox::class)->find($projectCheckboxId);

            $date = new \DateTime();

            if ($projectCheckbox->getIsComplete()) {
                $projectCheckbox->setIsComplete(NULL);
            } else {
                $projectCheckbox->setIsComplete($date);
            }

            $this->projectCheckboxRepository->save($projectCheckbox);

            return new JsonResponse([
                "success" => true,
                "result" => $projectCheckbox->getIsComplete() ? $projectCheckbox->getIsComplete()->format('d.m.y') : null,
            ]);

        }

    }


}
