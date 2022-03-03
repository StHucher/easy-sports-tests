<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ActivityRepository;
use App\Repository\TeamRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/coach")
 */

class CoachController extends AbstractController
{
    /**
     * @Route("/", name="app_coach")
     */
    public function index(): Response
    {
        return $this->render('coach/home_coach.html.twig', [
            'controller_name' => 'CoachController',
        ]);
    }

     /**
     * @Route("/teams", name="coach_teams")
     */   
    public function teams(UserRepository $userRepository, ActivityRepository $activityRepository, UserInterface $currentUser): Response
    {
        $id = $currentUser->getId(); 
        //je récupère l'id du user
        $user = $userRepository->find($id);

       // je récupère toutes les équipes de l'utilisateur
        $myTeams = $user->getActivities();
       // dd($myTeams);
        /* J'exclus les équipes dont l'entraîneur n'est que joueur :
            - j'enregistre les id des équipes coach dans le tableau $teamsIdList 
            - si le role du coach dans cet équipe est 0 (joueur) 
              alors tu ne l'enregistres pas (car on a besoin que des équipes "entrainées") 
        */

        $teamsIdList = [];

        foreach ($myTeams as $team) {

            // si il est enraineur de l'équipe
            

                // enregistre l'id de l'équipe dans le tableau
                $teamsIdList [] = $team->getTeam()->getId();
            

        } 

        /* Grace au tableau contenant les id des équipes du coach 
           Je vais créer un autre tableau $teamPlayersListByTeam qui va prendre en :
               - key   = l'id de l'équipe
               - value = la liste des joueurs
        */

        $teamPlayersListByTeam = [];
        foreach ($teamsIdList as $teamId) {
            
            // récupère la liste des users de cette équipe
            $players = $activityRepository->findBy(['team' => $teamId]);
            // si le nombre de personne de cette équipe = 1 c'est qu'il n'y a que l'entraineur ...)
            $countUsersNumber = count($players);

                $teamPlayersListByTeam [] = $players;    
        }

        // récupère les équipes grace a la propriété de user 

        return $this->render('common/team.html.twig', [
            'myTeams' => $myTeams,
            'teamPlayersListByTeam' => $teamPlayersListByTeam,
            'user'=> $user
        ]);
    }





}
