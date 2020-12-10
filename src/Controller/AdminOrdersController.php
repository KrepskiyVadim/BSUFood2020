<?php


namespace App\Controller;


use App\Entity\Dish;
use App\Entity\OrderFromMenu;
use App\Entity\OrderList;
use App\Repository\DishRepository;
use App\Repository\OrderListRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminOrdersController extends AbstractController
{
    /**
     * @Route("/admin/orders", name="admin_orders")
     */
    public function index(OrderListRepository $orderListRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $orderLists = $orderListRepository->findAll();
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository(OrderFromMenu::class)->findAll();
        $result = $paginator->paginate(
            $orderLists,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100000)
        );
        return $this->render('admin_orders/index.html.twig', [
            'ordersLists' => $result, 'orders'=>$orders
        ]);
    }
    /**
     * @Route("/admin/orders/delete_order/{id}", name="delete_dish")
     * @param $id
     */
    public function deleteOrder(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $ord = $em->getRepository(OrderList::class)->find($id);
        $em->remove($ord);
        $em->flush();
        return $this->redirectToRoute('admin_orders');
    }
}