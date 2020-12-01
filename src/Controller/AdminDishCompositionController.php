<?php


namespace App\Controller;


use App\Entity\DishComposition;
use App\Repository\DishCompositionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDishCompositionController extends AbstractController
{
    /**
     * @Route("/admin/dish_composition", name="admin_dish_composition")
     */
    public function index(DishCompositionRepository $dishCompositionRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $dish_composition = $dishCompositionRepository->findAll();
        $result = $paginator->paginate(
            $dish_composition,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100000)
        );
        return $this->render('admin_dish_composition/index.html.twig', [
            'dish_compositions' => $result,
        ]);
    }
    /**
     * @Route("/admin/dish_composition/delete_dish_composition/{id}", name="delete_dish_composition")
     * @param $id
     */
    public function deleteDishComposition(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $dsh = $em->getRepository(DishComposition::class)->find($id);
        $em->remove($dsh);
        $em->flush();


        return $this->redirectToRoute('admin_dish_composition');
    }
}
