<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;


class PlayerController extends AbstractController
{
    /**
     * @Route("/player", name="app_player")
     */
    public function index(): Response
    {
        return $this->render('common/home.html.twig', [
            'controller_name' => 'CommonController',
        ]);
    }

    /**
     * @Route("/chart/{id}", name="app_chart")
     */
    public function chart(ChartBuilderInterface $chartBuilder, Security $security, $id): Response
    {

        $testId = $id;
        $user = $security->getUser();

        $myResults = $user->getResults();
        

        //creer le tableau de resultDatas pour ce test
        $resultData = [];
        foreach ($myResults as $result) {
            if ($result->getTest()->getId() == $testId) {
                $resultData [] = $result->getResult();
            }
            
        }

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $resultData,
                ],
            ],
        ]);

        $chart->setOptions([/* ... */]);

        return $this->render('common/chart.html.twig', [
            'chart' => $chart,
            'user' => $user, 
        ]);
    }
}


