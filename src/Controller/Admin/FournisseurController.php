<?php

namespace App\Controller\Admin;

use App\Entity\Fournisseur;
use App\Form\FournisseurType;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/admin/fournisseur", name="admin_fournisseur_")
 * @package App\Controller\Admin
 */
class FournisseurController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(FournisseurRepository $fournisseurRepository): Response
    {
        return $this->render('fournisseur/index.html.twig', [
            'fournisseurs' => $fournisseurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fournisseur);
            $entityManager->flush();

            return $this->redirectToRoute('admin_fournisseur_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fournisseur/new.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Fournisseur $fournisseur): Response
    {
        return $this->render('fournisseur/show.html.twig', [
            'fournisseur' => $fournisseur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fournisseur $fournisseur): Response
    {
        $form = $this->createForm(Fournisseur1Type::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_fournisseur_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('fournisseur/edit.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Fournisseur $fournisseur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fournisseur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fournisseur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_fournisseur_home', [], Response::HTTP_SEE_OTHER);
    }
}
