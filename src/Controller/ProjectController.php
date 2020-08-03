<?php

namespace App\Controller;

use App\Entity\Checklist;
use App\Entity\Project;
use App\Form\ProjectFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class ProjectController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;
    /**
     * @var RouterInterface
     */
    private RouterInterface $router;

    /**
     * ProjectController constructor.
     * @param EntityManagerInterface $em
     * @param RouterInterface $router
     */
    public function __construct(
        EntityManagerInterface $em,
        RouterInterface $router
    )
    {
        $this->em = $em;
        $this->router = $router;
    }

    /**
     * @Route("/", name="project.new")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        $project = new Project();
        $projectForm = $this->createForm(ProjectFormType::class, $project);
        $projectForm->handleRequest($request);
        if ($projectForm->isSubmitted() && $projectForm->isValid()) {

            $checklist = new Checklist();
            $checklist->setProject($project);
            $project->addChecklist($checklist);

            $this->em->persist($checklist);
            $this->em->persist($project);
            $this->em->flush();

            return new RedirectResponse($this->router->generate('project.show', ['id' => $project->getId()]));
        }

        return $this->render('project/create.html.twig', [
            'projectForm' => $projectForm->createView()
        ]);
    }


    /**
     * @Route("/project/{id}", name="project.show")
     * @param Project $project
     * @return Response
     */
    public function show(Project $project)
    {
        $checkboxes = $this->em->getRepository("App:Checkbox")->findByFramework($project->getCurrentFramework());

        return $this->render('project/show.html.twig', [
            'project' => $project,
            'checkboxes'=>$checkboxes
        ]);
    }

}



