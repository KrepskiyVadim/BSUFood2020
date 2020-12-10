<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\EditDishFormType;
use App\Repository\DishRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDishesController extends AbstractController
{
    /**
     * @Route("/admin/dishes", name="admin_dishes")
     */
    public function index(DishRepository $dishRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $dishes = $dishRepository->findAll();
        $result = $paginator->paginate(
            $dishes,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100000)
        );
        return $this->render('admin_dishes/index.html.twig', [
            'dishes' => $result,
        ]);
    }

    /**
     * @Route("/admin/dishes/delete_dish/{id}", name="delete_dish")
     * @param $id
     */
    public function deleteDishByTable(int $id):Response
    {
        $em = $this->getDoctrine()->getManager();
        $dsh = $em->getRepository(Dish::class)->find($id);
        $em->remove($dsh);
        $em->flush();
        return $this->redirectToRoute('admin_dishes');
    }

    /**
     * @Route("/admin/dishes/edit_dish/{id}", name="edit_dish")
     * @param $id
     */
    public function editDish(int $id, Request $request):Response
    {
        $em=$this->getDoctrine()->getManager();
        $dish=$em->getRepository(Dish::class)->find($id);
        $name = $dish->getName();
        $category = $dish->getCategory();
        $weight = $dish->getWeight();
        $price = $dish->getPrice();
        $form=$this->createForm(EditDishFormType::class,$dish, [//'name'=>$name,
            'category'=>$category,
            'weight'=>$weight,
            'price'=>$price]);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $dish->setName($form->get('name')->getData());
            $dish->setWeight($form->get('weight')->getData());
            $dish->setPrice($form->get('price')->getData());
            $dish->setCategory($form->get('category')->getData());
            $dish->setImage($form->get('image')->getData());
            $em->persist($dish);
            $em->flush();
            return $this->redirectToRoute('admin_dishes');
        }
        return $this->render('edit_dish/index.html.twig', [
            'form'=>$form->createView(),
            //'name'=>$name,
            'category'=>$category,
            'weight'=>$weight,
            'price'=>$price
        ]);
    }
}
