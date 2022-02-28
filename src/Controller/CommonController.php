<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommonController extends AbstractController
{
    /**
     * @Route("/common", name="app_common")
     */
    public function index(): Response
    {
        return $this->render('common/test-history.html.twig', [
            'controller_name' => 'CommonController',
        ]);
    }
}
