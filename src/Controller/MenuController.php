<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Entity\OrderFromMenu;
use App\Repository\CategoryRepository;
use App\Repository\DishCompositionRepository;
use App\Repository\DishRepository;
use App\Repository\IngredientRepository;
use App\Repository\OrderFromMenuRepository;
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
    public function index(DishRepository $dishRepository, CategoryRepository $categoryRepository, DishCompositionRepository $dishCompositionRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $dishes = $dishRepository->findAll();
        $categories = $categoryRepository->findAll();
        $dishCompositions = $dishCompositionRepository->findAll();
        $result_dish = $paginator->paginate(
            $dishes,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100000)
        );
        $result_category = $paginator->paginate(
            $categories,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100000)
        );
        $result_dishComposition = $paginator->paginate(
            $dishCompositions,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100000)
        );
        if(in_array("ROLE_ADMIN",$this->getUser()->getRoles()))
            $parent_template = 'adminBase.html.twig';
        else if(in_array("ROLE_USER",$this->getUser()->getRoles()))
           $parent_template = 'homeBase.html.twig';
        else $parent_template = 'base.html.twig';
        return $this->render('menu/index.html.twig', [
            'dishes' => $result_dish, 'categories'=>$result_category, 'dishCompositions' => $result_dishComposition,
            'parent_template'=>$parent_template
        ]);
    }
    /**
     * @Route("/menu/add_dish/{id}", name="add_dish")
     * @param $id
     */
    public function addDish(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dsh = $em->getRepository(Dish::class)->find($id);
        if($em->getRepository(OrderFromMenu::class)->findByUser($this->getUser()) == null ||
            $em->getRepository(OrderFromMenu::class)->findByDish($dsh)==null) {
            $ord = new OrderFromMenu();
            $ord->setDish($dsh);
            $ord->setCount(1);
            $ord->setSum($dsh->getPrice());
            $ord->setUser($this->getUser());
        }
        else {
            $ord = $em->getRepository(OrderFromMenu::class)->findByDish($dsh);
            $ord->setCount($ord->getCount()+1);
        }
        $em->persist($ord);
        $em->flush();
        return $this->redirectToRoute('menu');
    }
}