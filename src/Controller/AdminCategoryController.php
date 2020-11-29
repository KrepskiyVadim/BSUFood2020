<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function index(CategoryRepository $categoryRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $categories = $categoryRepository->findAll();
        $result = $paginator->paginate(
            $categories,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 100000)
        );
        return $this->render('admin_categories/index.html.twig', [
            'categories' => $result,
        ]);
    }
    /**
     * @Route("/admin/categories/delete_category/{id}", name="delete_category")
     * @param $id
     */
    public function deleteCategory(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $ctgr = $em->getRepository(Category::class)->find($id);
        $em->remove($ctgr);
        $em->flush();


        return $this->redirectToRoute('admin_categories');
    }
}
