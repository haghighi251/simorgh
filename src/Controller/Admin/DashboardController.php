<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Comments;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Contents;
use App\Entity\Categories;
use App\Entity\Products;
use App\Entity\Settings;
use App\Entity\Sliders;

class DashboardController extends AbstractDashboardController
{

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(CategoriesCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony Shop');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'admin');
        yield MenuItem::linkToCrud('Products', 'fa fa-solid fa-store', Products::class);
        yield MenuItem::linkToCrud('Contents', 'fas fa-globe', Contents::class);
        yield MenuItem::linkToCrud('Categories', 'fa fa-solid fa-layer-group', Categories::class);
        yield MenuItem::linkToCrud('Comments', 'fas fa-comments', Comments::class);
        yield MenuItem::linkToCrud('Settings', 'fa fa-solid fa-gears', Settings::class);
        yield MenuItem::linkToCrud('Sliders', 'fa fa-solid fa-images', Sliders::class);
    }

}
