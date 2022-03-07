<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\Team;
use App\Entity\Test;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {



        return $this->render(('admin/dashboard.html.twig'));
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin Easy Sports Tests');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        yield MenuItem::linkToCrud('Tests', 'fas fa-solid fa-chart-line', Test::class);
        yield MenuItem::linkToCrud('Tags', 'fas fa-dsolid fa-tag', Tag::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-solid fa-users', User::class);
        
    }
}
