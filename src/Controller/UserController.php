<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

final class UserController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(Security $security, ProjectRepository $projectRepository)
    {
        $this->security = $security;
        $this->projectRepository = $projectRepository;
    }

    /**
     * @Route("/dashboard", name="user.dashboard")
     */
    public function create(): Response
    {
        $projects = $this->projectRepository->findBy([
            'user' => $this->security->getUser(),
            'status' => 1,
        ]);

        return $this->render('user/index.html.twig', [
            'projects' => $projects,
        ]);
    }
}
