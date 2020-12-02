<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\DishRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("/menu", name="menu")
     */
    public function index(DishRepository $dishRepository, CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $dishes = $dishRepository->findAll();
        $categories = $categoryRepository->findAll();
        $result1 = $paginator->paginate(
            $dishes,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100000)
        );
        $result2 = $paginator->paginate(
            $categories,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100000)
        );
        return $this->render('menu/index.html.twig', [
            'dishes' => $result1, 'categories'=>$result2,
        ]);
    }

}
