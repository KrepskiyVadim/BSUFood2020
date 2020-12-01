<?php


namespace App\Controller;

use App\Entity\DishComposition;
use App\Form\CreateDishCompositionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateDishCompositionController extends AbstractController
{
    /**
     * @Route("/admin/create/dish_composition", name="create_dish_composition")
     */
    public function index(Request $request): Response
    {
        $dish_composition=new DishComposition();
        $em=$this->getDoctrine()->getManager();
        $form=$this->createForm(CreateDishCompositionFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $dish_composition->setDish($form->get('dish')->getData());
            $dish_composition->setIngredient($form->get('ingredient')->getData());
            $em->persist($dish_composition);
            $em->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('create_dish_composition/index.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}