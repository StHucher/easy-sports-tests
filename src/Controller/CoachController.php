<?php

namespace App\Controller;

use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachController extends AbstractController
{
    /**
     * @Route("/coach/slug/teams", name="app_coach")
     */
    public function myTeams(): Response
    {
        return $this->render('common/team.html.twig', [
            'controller_name' => 'CoachController',
        ]);
    }






}
