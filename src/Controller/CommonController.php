<?php

namespace App\Controller;

use App\Entity\Activity;
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
use Doctrine\ORM\Repository\RepositoryFactory;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
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
      
        //dd($userInterface->getRoles());
        if (in_array("ROLE_COACH", $userInterface->getRoles())) {
            $form = $this->createForm(ResultType::class, $result);
            $form->handleRequest($request);
        }


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
        ]);
    }

    
    /**
     * @Route("/ajax/{id}", name="ajax")
     *
     * @return Response
     */
    public function ajax(UserRepository $userRepository, ActivityRepository $activityRepository, Request $request, $id) : Response
    {

       // $patchole = "bidabidoubidouba";
        //requete récupere tous les users de cette équipe par id
        $playersTeam = $activityRepository->findBy(['team' => $id]);
        //$playersListTeam = $userRepository->findAll();

        $playerList = [];
        foreach ($playersTeam as $player) {
            if ($player->getRole() == 0) { 
                $playerList [] = $player->getUser();
            }
            
        }

        //dd($playerList);

    try {
        return $this->json(
                // les données à transformer en JSON
                $playerList,
                // HTTP STATUS CODE
                200,
                // HTTP headers supplémentaires, dans notre cas : aucune
                [],
                // Contexte de serialisation, les groups de propriété que l'on veux serialise
                ['groups' => ['show_users']]
        );

     } catch (Exception $e){ // si une erreur est LANCE, je l'attrape
        // je gère l'erreur
        // par exemple si tu me file un genre ['3000'] qui n existe pas...
         return new JsonResponse("Hoouuu !! Ce qui vient d'arriver est de votre faute : JSON invalide", Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    }



}
