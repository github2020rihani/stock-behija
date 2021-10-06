<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\Entree;
use App\Entity\Produit;
use App\Form\CategoriesType;
use App\Form\EntreeType;
use App\Form\ProduitType;
use App\Repository\CategoriesRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/produit")
 * @package App\Controller\Admin
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produit_index")
     */
    public function index(Request $request, ProduitRepository $produitRepository, CategoriesRepository $catRepo): Response
    {
        //$produits = $produitRepository->findBy([], ['createdAt'=>'DESC']);
        // recherche selon  le nom de produit (designation)
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        $produits = $this->getDoctrine()->getRepository(Produit::class)->findAll();


        if ($form->isSubmitted() && $form->isValid()) {
            $em =  $this->getDoctrine()->getManagers();
            $em->persist($produit);
            $em->flush();

        }
        return $this->render('produit/index.html.twig', [
            'form' => $form->createView(),
            'produits' => $produits]);
    }
        /** recherche selon categorie
        $categorie = new Categories();
        $form = $this->createForm(CategoriesType::class,$categorie);
        $form->handleRequest($request);

        $produits= [];

        if($form->isSubmitted() && $form->isValid()) {
            $categorie = $produitRepository->getCategirie();

            if ($categorie!="")
            {

                $produits= $this->getDoctrine()->getRepository(Produit::class)->findBy(['$categorie' => $categorie] );
            }
            else
                $produits= $this->getDoctrine()->getRepository(Produit::class)->findAll();
        }

        return $this->render('produit/index.html.twig',[
            'form' => $form->createView(),
            'Produits' => $Produit
        ]);

        // recherche selon la date d'entree

        $dateEntree = new Entree();
        $form = $this->createForm(EntreeType::class,$dateEntree);
        $form->handleRequest($request);

        $produits= [];

        if($form->isSubmitted() && $form->isValid()) {
            $dateEntree = $Produit->getDateEntree();

            if ($dateEntree!="")
            {

                $produits= $this->getDoctrine()->getRepository(Produit::class)->findBy(['$categorie' => $categorie] );
            }
            else
                $produits= $this->getDoctrine()->getRepository(Produit::class)->findAll();
        }

        return $this->render('produit/index.html.twig',[
            'form' => $form->createView(),
            'Produits' => $Produit
        ]);

    }


}*/


    /**
     * @Route("/ajout", name="produit_ajout", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="produit_delete", methods={"GET"})
     */
    public function delete(Request $request, Produit $produit): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
    }
}