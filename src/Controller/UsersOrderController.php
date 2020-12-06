<?php


namespace App\Controller;


use App\Repository\DishRepository;
use App\Repository\OrderFromMenuRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersOrderController
{
    /**
     * @Route("/order/{id}", name="order")
     */
    public function index(OrderFromMenuRepository $orderFromMenuRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $orders = $orderFromMenuRepository->findAll();
        $result = $paginator->paginate(
            $orders,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100000)
        );
        return $this->render('userorder/index.html.twig', [
            'orders' => $result,
        ]);
    }
}