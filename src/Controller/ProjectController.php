<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;

class ProjectController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var Security
     */
    private $security;

    public function __construct(
        EntityManagerInterface $entityManager,
        RouterInterface $router,
        Security $security
    ) {
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->security = $security;
    }

    /**
     * @Route("/project/create", name="project.new")
     * @return Response
     */
    public function create(Request $request)
    {
        $user = $this->security->getUser();
        $project = new Project();
        $project->setUser($user);

        $projectForm = $this->createForm(ProjectFormType::class, $project);
        $projectForm->handleRequest($request);

        if ($projectForm->isSubmitted() && $projectForm->isValid()) {
            $project->setStatus(1);
            $this->entityManager->persist($project);
            $this->entityManager->flush();

            $this->addFlash('success', 'Project created');
            return new RedirectResponse($this->router->generate('user.dashboard'));
        }

        return $this->render('project/create.html.twig', [
            'projectForm' => $projectForm->createView(),
        ]);
    }

    /**
     * @Route("/project/{id}", name="project.show")
     * @return Response
     */
    public function show(Project $project, Request $request)
    {
        $checkboxes = $this->entityManager->getRepository('App:Checkbox')->findByFramework(
            $project->getDesiredFramework()
        );

        $projectForm = $this->createForm(ProjectFormType::class, $project);
        $projectForm->handleRequest($request);

        if ($projectForm->isSubmitted() && $projectForm->isValid()) {
            $this->entityManager->persist($project);
            $this->entityManager->flush();

            $this->addFlash('success', 'Project updated');
            return new RedirectResponse($this->router->generate('project.show', ['id' => $project->getId()]));
        }

        return $this->render('project/show.html.twig', [
            'projectEditForm' => $projectForm->createView(),
            'project' => $project,
            'checkboxes' => $checkboxes,
        ]);
    }

    /**
     * @Route("/project/{id}/remove", name="project.remove")
     * @return Response
     */
    public function remove(Project $project, Request $request)
    {
        $project->setStatus(2);
        $this->entityManager->persist($project);
        $this->entityManager->flush();

        $this->addFlash('success', 'Project removed');
        return new RedirectResponse($this->router->generate('user.dashboard'));
    }
}
