<?php

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
    private $em;
    /**
     * @var Security
     */
    private $security;

    /**
     * UserController constructor.
     * @param EntityManagerInterface $em
     * @param Security $security
     */
    public function __construct(
        EntityManagerInterface $em,
        Security $security
    )
    {
        $this->em = $em;
        $this->security = $security;
    }

    /**
     * @Route("/dashboard", name="user.dashboard")
     */
    public function create()
    {
        $user = $this->security->getUser();

        return $this->render('user/index.html.twig', [
        ]);
    }
}
