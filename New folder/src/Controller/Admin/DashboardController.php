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

class DashboardController extends AbstractDashboardController {

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response {
//        return parent::index();
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);
        $url = $routeBuilder->setController(CategoriesCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard {
        return Dashboard::new()
                        ->setTitle('Symfony Shop');
    }

    public function configureMenuItems(): iterable {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linktoRoute('Back to the website', 'fas fa-home', 'admin');
        yield MenuItem::linkToCrud('Comments', 'fas fa-comments', Comments::class);  
        yield MenuItem::linkToCrud('Contents', 'fas fa-comments', Contents::class);  
        yield MenuItem::linkToCrud('Categories', 'fa fa-solid fa-layer-group', Categories::class);
//         yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

}
