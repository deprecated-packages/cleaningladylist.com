<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectFormType;
use App\Repository\CheckboxRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProjectController extends AbstractController
{
    private CheckboxRepository $checkboxRepository;

    private ProjectRepository $projectRepository;

    public function __construct(CheckboxRepository $checkboxRepository, ProjectRepository $projectRepository)
    {
        $this->checkboxRepository = $checkboxRepository;
        $this->projectRepository = $projectRepository;
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
        $currentFramework = (string) $project->getCurrentFramework();
        $checkboxes = $this->checkboxRepository->findByFramework($currentFramework);

        return $this->render('project/show.html.twig', [
            'project' => $project,
            'checkboxes' => $checkboxes,
        ]);
    }

    private function processFormRequest(Project $project): RedirectResponse
    {
        $this->projectRepository->save($project);

        return $this->redirectToRoute('project.show', ['id' => $project->getId()]);
    }
}
