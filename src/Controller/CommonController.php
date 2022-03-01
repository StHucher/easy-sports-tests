<?php

namespace App\Controller;

use App\Entity\TagTest;
use App\Entity\Test;
use App\Entity\User;
use App\Repository\TagTestRepository;
use App\Repository\TestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


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
    public function testPhysique() : Response
    {
        
        return $this->render('common/technical_tests.html.twig');
    }

    /**
     * @Route("/tests/technique", name="test_technique")
     *
     * @return Response
     */
    public function testTechnique() : Response
    {   
        
        return $this->render('common/technical_tests.html.twig');
    }
}
