<?php

namespace App\Controller;

use App\Entity\Dish;
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
     * @Route("/admin/dishes/delete_categories/{id}", name="delete_dish")
     * @param $id
     */
    public function deleteCategory(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dsh = $em->getRepository(Dish::class)->find($id);
        $em->remove($dsh);
        $em->flush();


        return $this->redirectToRoute('admin_dishes');
    }
}
