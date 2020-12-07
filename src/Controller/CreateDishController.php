<?php

namespace App\Controller;


use App\Entity\Dish;
use App\Form\CreateDishFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\Package;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateDishController extends AbstractController
{
    /**
     * @Route("/admin/create/dish", name="create_dish")
     */
    public function index(Request $request): Response
    {
        $dish=new Dish();
        $em=$this->getDoctrine()->getManager();
        $form=$this->createForm(CreateDishFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $dish->setName($form->get('name')->getData());
            $dish->setWeight($form->get('weight')->getData());
            $dish->setPrice($form->get('price')->getData());
            $dish->setCategory($form->get('category')->getData());
            $dish->setImage($form->get('image')->getData());
            $em->persist($dish);
            $em->flush();
            return $this->redirectToRoute('admin/create/dish');
        }
        return $this->render('create_dish/index.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
