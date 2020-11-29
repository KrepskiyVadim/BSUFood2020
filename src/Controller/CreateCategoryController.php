<?php

namespace App\Controller;


use App\Entity\Category;
use App\Form\CreateCategoryFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateCategoryController extends AbstractController
{
    /**
     * @Route("/admin/create/category", name="create_category")
     */
    public function index(Request $request): Response
    {
        $category=new Category();
        $form=$this->createForm(CreateCategoryFormType::class,$category);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $category->setName($form->get('name')->getData());
            $em=$this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->render('create_category/index.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
