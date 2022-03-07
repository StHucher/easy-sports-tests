<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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

    /*Function to create a new user*/
    /**
     * @Route("/subscribe", name="homesubscription", methods={"GET", "POST"})
     */
     public function newUser(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($encoder->hashPassword($user, $user->getPassword()));
            /*When you create a new user I fix the status to 1 (active) and define the slug*/
            $user->setStatus(1);
            $user->setSlug('slug'.random_int(1,9999999999));

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
                        $this->getParameter('uploads_directory'),
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

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        /*display the form*/
        return $this->renderForm('home/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
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
