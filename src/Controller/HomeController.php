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
            $user->setSlug('test');
            $user->setPassword($encoder->hashPassword($user, $user->getPassword()));

            


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
     * Function editUser
     *
     * @Route("/{slug}/profil", name="profilpage", methods = {"GET", "POST"})
     */
    public function editUser(Request $request, EntityManagerInterface $entityManager, User $user, UserPasswordHasherInterface $encoder)
    {
        
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            /* if($form-> get('password')->getData()){
                $user->setPassword($encoder->hashPassword($user, $user->getPassword()));
            } */

            $entityManager->flush();
            /* $this->addFlash('info', 'Votre compte vient d\'être modifié avec succès.'); */

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        /*display the form*/
        return $this->renderForm('home/edit.html.twig', [
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
