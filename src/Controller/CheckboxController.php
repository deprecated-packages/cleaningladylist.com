<?php

declare(strict_types=1);

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
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/checkbox/complete", name="checkbox.complete")
     */
    public function index(Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $checkbox_id = $request->get('id');
            $project_id = $request->get('project_id');
            $isDone = $request->get('isDone') ? true : false;

            /** @var ProjectCheckbox $projectCheckbox */
            $projectCheckbox = $this->entityManager->getRepository('App:ProjectCheckbox')->findOneBy([
                'project' => $project_id,
                'checkbox' => $checkbox_id,
            ]);
            /** @var Project $project */
            $project = $this->entityManager->getRepository('App:Project')->find($project_id);

            /** @var Checkbox $checkbox */
            $checkbox = $this->entityManager->getRepository('App:Checkbox')->find($checkbox_id);

            if ($projectCheckbox === null) {
                $projectCheckbox = new ProjectCheckbox();
                $projectCheckbox->setProject($project);
                $projectCheckbox->setCheckbox($checkbox);
                $projectCheckbox->setIsDone(true);
            } else {
                $projectCheckbox->setIsDone($isDone);
            }

            $checkboxCount = $this->entityManager->getRepository('App:Checkbox')->findByFramework(
                $project->getDesiredFramework()
            );
            $project->setCheckboxCount(count($checkboxCount));

            $this->entityManager->persist($project);
            $this->entityManager->persist($projectCheckbox);
            $this->entityManager->flush();

            return new Response($project->getProgress($project));
        }
    }
}
