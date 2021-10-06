<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
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
}
