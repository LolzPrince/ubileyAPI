<?php

namespace App\Controller\Admin;

use App\Entity\GuestList;
use App\Entity\Tables;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect(
            $adminUrlGenerator->setController(TablesCrudController::class)->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Административная панель');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Столы', 'fas fa-chair', Tables::class);
        yield MenuItem::linkToCrud('Гости', 'fas fa-users', GuestList::class);
    }
}
