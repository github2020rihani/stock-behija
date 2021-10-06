<?php

namespace App\Controller;
use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Asserts ;
/**
 * @Route ("/sortie", name="admin_sortie_")
 * @package App\Controller
 */
class SortieController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(SortieRepository $sortieRepository):Response
    {


        return $this->render('sortie/index.html.twig', [
            'sorties'=> $sortieRepository->findAll(),
        ]);

    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $em):Response
    {
        $sorties = new Sortie();
        $form = $this->createForm(SortieType::class,$sorties);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($sorties);
            $em->flush();

            return  $this->redirectToRoute('admin_sortie_home');
        }
        return $this->renderForm('sortie/new.html.twig', [
            'sorties' => $sorties,
            'form' => $form
        ]);

    }
    /**
     * @Route("/edit/{id}", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request,Sortie $sorties):Response
    {

        $form = $this->createForm(EntreeType::class,$sorties);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();

            return  $this->redirectToRoute('admin_sortie_home');
        }
        return $this->renderForm('sortie/edit.html.twig', [
            'sorties'=>$sorties,
            'form' => $form


        ]);
    }
    /**
     * @Route("/{id<\d+>}/delete" , name="delete", methods={"GET"})
     */
    public function delete( Sortie $sorties)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($sorties);
        $em->flush();

        $this->addFlash('info','sortie Successfully deleted');
        // redirige la page
        return $this->redirectToRoute('admin_sortie_home');
    }
}
