<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/page", name="page_vierge")
     */
    public function index(): Response
    {
        return $this->render('page/page_vierge.html.twig');
    }
}
