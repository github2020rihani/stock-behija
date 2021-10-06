<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Entity\Produit;
use App\Form\CommandeType;

use App\Repository\CommandeRepository;
use App\Repository\LcommandeRepository;
use App\Repository\ProduitRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Asserts ;

/**
 * @Route("admin/commande", name="admin_commande_")
 * @package App\Controller\Admin
 */
class CommandeController extends AbstractController
{


    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index(CommandeRepository $commandeRepository): Response
    {

        $commandes = $commandeRepository->findBy([],['createdAt'=>'DESC']);

        return $this->render('commande/index.html.twig', compact('commandes'),
        
        );


    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, LcommandeRepository $commandeRepository): Response
    {
        $commande = new Commande();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $lastCommande = $em->getRepository(Commande::class)->findOneBy([], ['id' => 'desc']);
            if ($lastCommande) {
                $commande->setNumCmd("SOFFALCMD0". ($lastCommande->getId()+1));
            }else{
                $commande->setNumCmd("SOFFALCMD01");
            }
            $em->persist($commande);
            $em->flush();
            return $this->redirectToRoute('admin_commande_home', array('id' => $commande->getId()));
        }
        return $this->render('commande/new.html.twig', [
            'commandes' => $commande,
            'form' => $form->createView(),


        ]);


    }

    /**
     * @Route( "/info_product/{id_prod}", name="info_product")
     * @return JsonResponse
     */
    public function getProd( ProduitRepository $produitRepository,Produit $id_prod)
    {
        $product = $produitRepository->find($id_prod);
        $prix = $product->getPrixHT();
        $tva = $product->getTva();
        $qte = $product->getQuantite();
        $data = ['prix'=> $prix,
            'tva' => $tva, 'qte' => $qte];

        //emchil hel localhost:8000
        return new JsonResponse(array("res" => $data,  JsonResponse::HTTP_OK)
        );
    }



    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commandes' => $commande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commande $commande): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_commande_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('commande/edit.html.twig', [
            'commandes' => $commande,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})

    public function delete(Request $request, Commande $commande): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_commande_home', [], Response::HTTP_SEE_OTHER);
    } */

    /**
     * @Route("/{id<\d+>}/delete" , name="delete", methods={"GET"})
     */
    public function delete(Request $request, Commande $commande)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($commande);
        $em->flush();


        $this->addFlash('info','commande Successfully deleted');
        // redirige la page
        return $this->redirectToRoute('admin_commande_home');
    }


}
