<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThanksController extends AbstractController
{
    /**
     * @Route("/thanks", name="thanks")
     */
    public function index():Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user->setStatus(true);
        $em->persist($user);
        $em->flush();
        return $this->render('thanks/index.html.twig');
    }
}