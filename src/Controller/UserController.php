<?php

declare(strict_types=1);

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var Security
     */
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }

    /**
     * @Route("/dashboard", name="user.dashboard")
     */
    public function create()
    {
        $projects = $this->entityManager->getRepository('App:Project')->findBy([
            'user' => $this->security->getUser(),
            'status' => 1,
        ]);

        return $this->render('user/index.html.twig', [
            'projects' => $projects,
        ]);
    }
}
