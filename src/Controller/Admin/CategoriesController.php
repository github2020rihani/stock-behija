<?php

namespace App\Controller\Admin;

use App\Entity\Categories ;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Asserts ;
/**
 * @Route ("/admin/categories", name="admin_categories_")
 * @package App\Controller\Admin
 */
class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoriesRepository $repository, Request $request, EntityManagerInterface $em):Response
    {
        $categories = new Categories;
        $form = $this->createForm(CategoriesType::class,$categories);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($categories);
            $em->flush();

            return  $this->redirectToRoute('admin_categories_home');
        }
        return $this->render('admin/categories/index.html.twig', [
            'categories'=> $repository->findAll(),
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/ajout", name="ajout")
     */
   public function ajout( Request $request , EntityManagerInterface $em): Response
    {
        $categories = new Categories;
        $form = $this->createForm(CategoriesType::class,$categories);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($categories);
           $em->flush();

           return $this->redirectToRoute('admin_categories_home');
        }

        return $this->render('admin/categories/ajout.html.twig',[
            'form'=> $form->createView(),

        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
     */
    public function modifCategories(Categories $categorie, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoriesType::class,$categorie);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($categorie);
            $em->flush();

            return  $this->redirectToRoute('admin_categories_home');
        }
        return $this->render('admin/categories/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categorie/{id<\d+>}/delete", name="delete", methods={"GET"})
     */
    public function delete(Categories $categories, EntityManagerInterface $em): Response
    {
        $em->remove($categories);
        $em->flush();

        //$this->addFlash('info','Pin Successfully deleted');
        return $this->redirectToRoute('admin_categories_home');


    }
    /**
     * Render the search form
     */
    public function searchForm(Request $request)
    {
        $form = $this->createForm(CategoriesType::class);
        $form->handleRequest($request);

        return $this->render('admin/categories/index.html.twig', array(
            'search_form' => $form->createView(),
        ));
    }

    /**
     * Search entities
     *
     * @Route("/search", name="app_category_search")

     */
    public function search(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $request->query->all();
        $form = $this->createForm(CategoriesType::class);
        $form->handleRequest($request);
        $qb = $em->getRepository('App:Categories')->searchBack($data);
        $entities = $paginator->paginate($qb, $request->query->get('page', 1), 20);
        return $this->render('admin/categories/search_form.html.twig', array(
            'entities' => $entities,
            'search_form'=>$form->createView()
        ));
    }
}
