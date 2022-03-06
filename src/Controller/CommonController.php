<?php

namespace App\Controller;

use App\Entity\Result;
use App\Entity\Tag;
use App\Entity\TagTest;
use App\Entity\Test;
use App\Entity\User;
use App\Form\ResultType;
use App\Form\UserType;
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
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        $form = $this->createForm(ResultType::class, $result);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $result->setTest($test);
            $result->setDoneAt( new DateTime('now'));
            if(in_array("ROLE_COACH",$userInterface->getRoles())){
                $result->setStatus(1);
            }else{
                $result->setStatus(0);
            }
            
            $manager->persist($result);
            $manager->flush();

            return $this->redirectToRoute('user_home',['slug'=>$userInterface->getSlug()], Response::HTTP_SEE_OTHER);
        }
        
    }

    /**
     * Function editUser
     *
     * @Route("/{slug}/profil", name="profilpage", methods = {"GET", "POST"})
     */
    public function editUser(Request $request, EntityManagerInterface $entityManager, User $user, UserPasswordHasherInterface $encoder, SluggerInterface $slugger, UserInterface $userInterface)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            //Is there a new password ?
            if($form-> get('password')->getData()){
                // if yes, we hashe the new password
                $hashedPassword = $encoder->hashPassword($user, $form->get('password')->getData());
                // we set the new password
                $user->setPassword($hashedPassword);
            }

            $avatarFile = $form->get('picture')->getData();
            //If there is there some data in the field picture, we treat them
            if($avatarFile){
                $originalFilename = pathinfo($avatarFile->getClientOriginalName(), PATHINFO_FILENAME);

                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$avatarFile->guessExtension();

                // Move the file to the directory where avatars are stored
                try {
                    $avatarFile->move(
                        $this->getParameter('avatar_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... TO DO handle exception if something happens during file upload
                }

                // We update the user class
                $user->setPicture($newFilename);
            }
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('info', 'Votre compte vient d\'être modifié avec succès.');
            /* $UserRepository->add($user); */
            return $this->redirectToRoute('user_home', [/* 'slug'=>$userInterface->getSlug() */], Response::HTTP_SEE_OTHER);
        }

        /*display the form*/
        return $this->renderForm('home/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);

    }

    
}
