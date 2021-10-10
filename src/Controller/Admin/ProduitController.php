<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Entity\Categories;
use App\Entity\Entree;
use App\Form\CategoriesType;
use App\Form\EntreeType;
use App\Form\FilterType;
use App\Form\ProduitType;
use App\Model\Filter;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryBuilderInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isEmpty;

/**
 * @Route("admin/produit")
 * @package App\Controller\Admin
 */
class ProduitController extends AbstractController
{

    /**
     * @Route("/",  name="produit_index")
     */
    public function index(Request $request, FormFactoryInterface $formFactory, PaginatorInterface $paginator, SessionInterface $session, ProduitRepository $produitRepository)
    {

         $em = $this->getDoctrine()->getManager();

         $query = $em->getRepository(Produit::class)->findAll();

       $produits = $paginator->paginate($query, $request->query->get('page', 1), 5);
       $categories = $em->getRepository(Categories::class)->findAll();

        return $this->render('produit/index.html.twig', array(
            'produits' => $produits,
            'categories' => $categories,
        ));
    }



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

    /**
     *  $quantite = $session->get('quatite', []);
    $panierwithDate = [];
    foreach ($quantite as $id=> $quatite ){
    $panierwithDate[] = [
    'produit'=> $produitRepository->find($id),
    'quantite'=> $produitRepository->findBy($quatite)
    ];
    }
    dd($panierwithDate);
     */


    /**
     * @param Request $request
     * @Route("/serch/critere", name="search_product")
     */

    public function searchProduct(Request $request, PaginatorInterface $paginator, ProduitRepository
    $produitRepository) {

        $des = $request->get('desic');
        $cat = $request->get('category');
        if (!$des && $cat) {
            $query =   $produitRepository->serachProductBydCategory((int)$cat);
            $produits = $paginator->paginate($query, $request->query->get('page', 1), 10);
        }elseif ($des && !$cat) {
            $query =   $produitRepository->serachProductBydesignation($des);
            $produits = $paginator->paginate($query, $request->query->get('page', 1), 10);
        }elseif ($des && $cat){
            $query =   $produitRepository->serachProductBydesignationAndCategory($des , (int)$cat);
            $produits = $paginator->paginate($query, $request->query->get('page', 1), 10);
        }
        $result = $this->render('produit/searchProduct.html.twig', array('produits' => $produits->getItems()))->getcontent();


        return  $this->json(array('result'=> $result ));







    }
}