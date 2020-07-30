<?php

namespace App\Controller;

use App\Entity\Checkbox;
use App\Entity\Project;
use App\Entity\ProjectCheckbox;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckboxController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CheckboxController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }

    /**
     * @Route("/checkbox/complete", name="checkbox.complete")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $checkbox_id = $request->get("id");
            $project_id = $request->get("project_id");
            $isDone = $request->get("isDone") ? true : false;

            /**
             * @var ProjectCheckbox $projectCheckbox
             */
            $projectCheckbox = $this->em->getRepository("App:ProjectCheckbox")->findOneBy([
                'project' => $project_id,
                'checkbox' => $checkbox_id
            ]);
            /**
             * @var Project $project
             */
            $project = $this->em->getRepository("App:Project")->find($project_id);

            /**
             * @var Checkbox $checkbox
             */
            $checkbox = $this->em->getRepository("App:Checkbox")->find($checkbox_id);

            if ($projectCheckbox === null) {
                $projectCheckbox = new ProjectCheckbox();
                $projectCheckbox->setProject($project);
                $projectCheckbox->setCheckbox($checkbox);
                $projectCheckbox->setIsDone(true);
            } else {
                $projectCheckbox->setIsDone($isDone);
            }

            $this->em->persist($projectCheckbox);
            $this->em->flush();

            return new Response($project->getProgress($project));
        }
    }
}
