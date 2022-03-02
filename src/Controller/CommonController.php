<?php

namespace App\Controller;

use App\Entity\Result;
use App\Entity\Tag;
use App\Entity\TagTest;
use App\Entity\Test;
use App\Entity\User;
use App\Form\ResultType;
use App\Repository\ActivityRepository;
use App\Repository\ResultRepository;
use App\Repository\TagRepository;
use App\Repository\TagTestRepository;
use App\Repository\TeamRepository;
use App\Repository\TestRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class CommonController extends AbstractController
{
    /**
     * @Route("/home/{slug}", name="user_home")
     * 
     * @return Response
     */
    public function home(User $user): Response
    {
        return $this->render('common/home.html.twig',['user'=> $user]);
    }

    /**
     * @Route("/history/{slug}", name="history")
     *
     * @return Response
     */
    public function history(User $user) : Response
    {   

        return $this->render('common/test-history.html.twig',['user'=> $user]);
    }

    /**
     * @Route("/tests", name="tests")
     *
     * @return Response
     */
    public function tests() : Response
    {
        return $this->render('common/all_tests.html.twig');
    }

    /**
     * @Route("/tests/physique", name="test_physique")
     *
     * @return Response
     */
    public function testPhysique(TagTestRepository $tagTestRepo) : Response
    {
        return $this->render('common/physical_tests.html.twig',['tagTests'=> $tagTestRepo->findAll()]);
    }

    /**
     * @Route("/tests/technique", name="test_technique")
     *
     * @return Response
     */
    public function testTechnique(TagTestRepository $tagTestRepo) : Response
    {   
        
        return $this->render('common/technical_tests.html.twig',['tagTests'=> $tagTestRepo->findAll()]);
    }

    

    /**
     * @Route("/tests/{id}", name="one_test",  requirements={"page"="\d+"}, methods={"GET", "POST"})
     *
     * @return Response
     */
    public function registerTest(UserRepository $user ,SessionInterface $session,TeamRepository $team,Request $request, Test $test, UserInterface $userInterface, ActivityRepository $activityRepository,EntityManagerInterface $manager) : Response
    {   
        $result = new Result();
        $teamsId = [];
        $activities = $userInterface->getActivities();
        foreach($activities as $activity){
            $teamsId [] = $activity->getTeam()->getId();
        }
        $listPlayersByTeam = [];
        foreach($teamsId as $teamId){
            $player = $activityRepository->findBy(['team'=>$teamId]);
            $listPlayersByTeam[$teamId] = $player;
        }
        

        $form = $this->createForm(ResultType::class, $result);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $result->setTest($test);
            $result->setDoneAt( new DateTime('now'));
            $u = $user->findBy(['id'=>$session->get('player')]);
            $result->setUser($u[0]);
            if(in_array("ROLE_COACH",$userInterface->getRoles())){
                $result->setStatus(1);
            }else{
                $result->setStatus(0);
            }
            
            $manager->persist($result);
            $manager->flush();

            return $this->redirectToRoute('user_home',['slug'=>$userInterface->getSlug()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('common/one_test.html.twig', [
            'test' => $test,
            'form' => $form,
            'activities'=>$activities,
            'listPlayersByTeam'=>$listPlayersByTeam
        ]);
    }

    
}
