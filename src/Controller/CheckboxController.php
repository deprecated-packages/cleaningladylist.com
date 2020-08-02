<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Checkbox;
use App\Entity\ProjectCheckbox;
use App\Repository\CheckListRepository;
use App\Repository\ProjectCheckListRepository;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CheckboxController extends AbstractController
{
    /**
     * @var CheckListRepository
     */
    private $checkListRepository;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var ProjectCheckListRepository
     */
    private $projectCheckListRepository;

    public function __construct(
        CheckListRepository $checkListRepository,
        ProjectRepository $projectRepository,
        ProjectCheckListRepository $projectCheckListRepository
    ) {
        $this->checkListRepository = $checkListRepository;
        $this->projectRepository = $projectRepository;
        $this->projectCheckListRepository = $projectCheckListRepository;
    }

    /**
     * @Route("/checkbox/complete", name="checkbox.complete")
     */
    public function index(Request $request): Response
    {
        if ($request->isXmlHttpRequest()) {
            $checkbox_id = $request->get('id');
            $project_id = $request->get('project_id');
            $isDone = (bool) $request->get('isDone');

            $projectCheckbox = $this->projectCheckListRepository->findOneBy([
                'project' => $project_id,
                'checkbox' => $checkbox_id,
            ]);

            $project = $this->projectRepository->find($project_id);

            $checkbox = $this->checkListRepository->find($checkbox_id);

            if ($projectCheckbox === null) {
                $projectCheckbox = new ProjectCheckbox();
                $projectCheckbox->setProject($project);
                $projectCheckbox->setCheckbox($checkbox);
                $projectCheckbox->setIsDone(true);
            } else {
                $projectCheckbox->setIsDone($isDone);
            }

            $checkboxCount = $this->checkListRepository->findByFramework(
                // @todo fix, can be null
                (string) $project->getDesiredFramework()
            );
            $project->setCheckboxCount(count($checkboxCount));

            $this->projectRepository->save($project);

            return new Response($project->getProgress($project));
        }

        // I guess?
        return new JsonResponse([]);
    }
}
