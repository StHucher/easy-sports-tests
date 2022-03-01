<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('home/homepage.html.twig');
    }

    /**
     * @Route("/contact", name="contactpage")
     *
     *
     */
    public function contact()
    {
        return $this->render('home/contact.html.twig');
    }

    /**
     * @Route("/mentions-legales", name="legalnotice")
     *
     * @return void
     */
    public function legalNotice()
    {
        return $this->render('home/legal_notice.html.twig');
    }
}
