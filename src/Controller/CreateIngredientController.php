<?php


namespace App\Controller;


use App\Entity\Ingredient;
use App\Form\CreateIngredientFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateIngredientController extends AbstractController
{
    /**
     * @Route("/admin/create/ingredients", name="create_ingredients")
     */
    public function index(Request $request): Response
    {
        $ingredient=new Ingredient();
        $form=$this->createForm(CreateIngredientFormType::class,$ingredient);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $ingredient->setName($form->get('name')->getData());
            $em=$this->getDoctrine()->getManager();
            $em->persist($ingredient);
            $em->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('create_ingredients/index.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}