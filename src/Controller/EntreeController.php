<?php

namespace App\Controller;
use App\Entity\Entree;
use App\Form\EntreeType;
use App\Repository\EntreeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Asserts ;
/**
 * @Route ("/entree", name="admin_entree_")
 * @package App\Controller
 */
class EntreeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(EntreeRepository $entreeRepository, Request $request, EntityManagerInterface $em):Response
    {


        return $this->render('entree/index.html.twig', [
            'entrees'=> $entreeRepository->findAll(),
        ]);

    }

    /**
     * @Route("/new", name="ajout", methods={"GET","POST"})
     */
    public function ajout(Request $request, EntityManagerInterface $em):Response
    {
        $entree = new Entree();
        $form = $this->createForm(EntreeType::class,$entree);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($entree);
            $em->flush();

            return  $this->redirectToRoute('admin_entree_home');
        }
        return $this->render('entree/new.html.twig', [
            'form' => $form->createView()

        ]);



    }
    /**
     * @Route("/edit/{id}", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request,Entree $entrees):Response
    {

        $form = $this->createForm(EntreeType::class,$entrees);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();

            return  $this->redirectToRoute('admin_entree_home');
        }
        return $this->renderForm('entree/edit.html.twig', [
            'entrees'=>$entrees,
            'form' => $form


        ]);
        }
    /**
     * @Route("/{id<\d+>}/delete" , name="delete", methods={"GET"})
     */
    public function delete( Entree $entrees)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($entrees);
        $em->flush();

        $this->addFlash('info','commande Successfully deleted');
        // redirige la page
        return $this->redirectToRoute('admin_entree_home');
    }
}
