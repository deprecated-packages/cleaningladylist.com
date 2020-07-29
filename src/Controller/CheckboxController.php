<?php

namespace App\Controller;

use App\Entity\Checkbox;
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
            $id = $request->get("id");
            $isDone = $request->get("isDone") ? true : false;

            /**
             * @var Checkbox $checkbox
             */
            $checkbox = $this->em->getRepository('App:Checkbox')->find($id);
            $checkbox->setIsDone($isDone);
            $this->em->persist($checkbox);
            $this->em->flush();

            return new Response($checkbox->getProject()->getProgress($checkbox->getProject()));

        }
        return new Response();
    }
}
