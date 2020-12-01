<?php


namespace App\Controller;


use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminIngredientController extends AbstractController
{
    /**
     * @Route("/admin/ingredients", name="admin_ingredients")
     */
    public function index(IngredientRepository $ingredientRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $ingredients = $ingredientRepository->findAll();
        $result = $paginator->paginate(
            $ingredients,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100000)
        );
        return $this->render('admin_ingredients/index.html.twig', [
            'ingredients' => $result,
        ]);
    }
    /**
     * @Route("/admin/ingredients/delete_ingredient/{id}", name="delete_ingredient")
     * @param $id
     */
    public function deleteIngredient(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $ingrdnt = $em->getRepository(Ingredient::class)->find($id);
        $em->remove($ingrdnt);
        $em->flush();


        return $this->redirectToRoute('admin_ingredients');
    }
}