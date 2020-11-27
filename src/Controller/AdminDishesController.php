<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDishesController extends AbstractController
{
    /**
     * @Route("/admin/dishes", name="admin_dishes")
     */
    public function index(): Response
    {
        return $this->render('admin_dishes/index.html.twig', [
            'controller_name' => 'AdminDishesController',
        ]);
    }
}
