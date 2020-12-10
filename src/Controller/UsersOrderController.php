<?php


namespace App\Controller;


use App\Entity\Dish;
use App\Entity\OrderFromMenu;
use App\Entity\OrderList;
use App\Form\UserOrderFormType;
use App\Repository\OrderFromMenuRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersOrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function index(OrderFromMenuRepository $orderFromMenuRepository, PaginatorInterface $paginator, Request $request): Response
    {
        if($orderFromMenuRepository->findByUser($this->getUser()) != null)
        {
            $orders = $orderFromMenuRepository->findAll();
            $result = $paginator->paginate(
                $orders,
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 100000));
            $orderList = new OrderList();
            $em = $this->getDoctrine()->getManager();
            $form = $this->createForm(UserOrderFormType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $order = $orderFromMenuRepository->findAll();
                $orderList->setAddress($form->get('address')->getData());
                $orderList->setUser($this->getUser());
                $sum = 0;
                foreach ($order as $ord) {
                    if ($ord->getUser() == $this->getUser())
                        $sum += $ord->getSum();
                }
                $orderList->setSum($sum);
                $date = new \DateTime();
                $orderList->setDate($date);
                $em->persist($orderList);
                $em->flush();
                return $this->redirectToRoute('thanks');
            }
            $user = $this->getUser();
            if($user->getStatus()==true)
                return $this->render('wait/index.html.twig');
            else
            {
                return $this->render('userorder/index.html.twig', [
                'orders' => $result, 'user' => $user, 'form' => $form->createView()
            ]);
            }
        }
        else {
            return $this->redirectToRoute('menu');
        }
    }
    /**
     * @Route("/order/delete_order", name="delete_order")
     */
    public function deleteOrder()
    {
        $em = $this->getDoctrine()->getManager();
        $ord = $em->getRepository(OrderFromMenu::class)->findByUser($this->getUser());
        while($ord)
        {
            $em->remove($ord);
            $em->flush();
            $ord = $em->getRepository(OrderFromMenu::class)->findByUser($this->getUser());
        }
        return $this->redirectToRoute('admin_orders');
    }
    /**
     * @Route("/order/add_dish/{id}", name="order_add_dish")
     * @param $id
     */
    public function addDish(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dsh = $em->getRepository(Dish::class)->find($id);
        $ord = null;
        $orders = $em->getRepository(OrderFromMenu::class)->findAll();
        foreach ($orders as $order)
        {
            if($order->getUser()==$this->getUser()&&$order->getDish()==$dsh)
            {
                $ord = $order;
                break;
            }
        }
        $ord->setCount($ord->getCount()+1);
        $ord->setSum($ord->getSum()+$dsh->getPrice());
        $em->persist($ord);
        $em->flush();
        return $this->redirectToRoute('order');
    }
    /**
     * @Route("/order/delete_dish/{id}", name="order_delete_dish")
     * @param $id
     */
    public function deleteDishFromOrder(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dsh = $em->getRepository(Dish::class)->find($id);
        $orders = $em->getRepository(OrderFromMenu::class)->findAll();
        $ord = null;
        foreach ($orders as $order)
        {
            if($order->getUser()==$this->getUser()&&$order->getDish()==$dsh)
            {
                $ord = $order;
                break;
            }
        }
        if($ord)
        {
            if($ord->getCount() == 1)
            {
                $em->remove($ord);
            }
            else {
                $ord->setCount($ord->getCount()-1);
                $ord->setSum($ord->getSum()-$dsh->getPrice());
                $em->persist($ord);
            }
        }
        $em->flush();
        return $this->redirectToRoute('order');
    }
    /**
     * @Route("/order/cancel", name="cancel_order")
     * @param $id
     */
    public function cancelOrder()
    {
        $em = $this->getDoctrine()->getManager();
        $orders = $em->getRepository(OrderFromMenu::class)->findAll();
        foreach ($orders as $order)
        {
            if($order->getUser() == $this->getUser())
            {
                $em->remove($order);
            }
        }
        $em->flush();
        return $this->redirectToRoute('order');
    }

}