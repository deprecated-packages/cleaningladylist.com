<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Project;
use App\Entity\ProjectCheckbox;
use App\Form\ProjectFormType;
use App\Repository\CheckboxRepository;
use App\Repository\ProjectCheckboxRepository;
use App\Repository\ProjectRepository;
use DateTime;
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


    private ProjectCheckboxRepository $projectCheckboxRepository;

    /**
     * ProjectController constructor.
     */
    public function __construct(
        CheckboxRepository $checkboxRepository,
        ProjectRepository $projectRepository,
        ProjectCheckboxRepository $projectCheckboxRepository
    )
    {
        $this->checkboxRepository = $checkboxRepository;
        $this->projectRepository = $projectRepository;
        $this->projectCheckboxRepository = $projectCheckboxRepository;
    }

    /**
     * @Route("/", name="project.new")
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

    /**
     * @Route("/project/checkbox/check", name="project.checkbox.check")
     * @param Request $request
     * @return JsonResponse
     */
    public function checkProjectCheckbox(Request $request): JsonResponse
    {
        $getContent = $request->getContent();
        $content = json_decode($getContent . "");
        $submittedToken = $content->token;
        $projectCheckboxId = $content->projectCheckboxId;

        if ($this->isCsrfTokenValid('check-blank-token', $submittedToken)) {
            $projectCheckbox = $this->projectCheckboxRepository->find($projectCheckboxId);
            $dateTime = new DateTime();

            $projectCheckbox->getIsComplete() ? $projectCheckbox->setIsComplete(NULL) : $projectCheckbox->setIsComplete($dateTime);
            $this->projectCheckboxRepository->save($projectCheckbox);

            return new JsonResponse([
                'success' => true,
                'result' => $projectCheckbox->getIsComplete() !== null ? $projectCheckbox->getIsComplete()->format('d.m.y') : NULL,
            ]);
        }

        return new JsonResponse([
            'success' => false,
        ]);
    }

    private function processFormRequest(Project $project): RedirectResponse
    {
        $desiredFramework = $project->getDesiredFramework();
        $checkboxes = $this->checkboxRepository->findByFramework($desiredFramework);

        foreach ($checkboxes as $checkbox) {
            $projectCheckbox = new ProjectCheckbox();
            $projectCheckbox->setProject($project);
            $projectCheckbox->addCheckbox($checkbox);
            $projectCheckbox->setIsComplete(null);
            $this->projectCheckboxRepository->persist($projectCheckbox);
        }

        $project->setTimezone('Prague');
        $this->projectRepository->save($project);

        return $this->redirectToRoute('project.show', ['id' => $project->getId()]);
    }
}
