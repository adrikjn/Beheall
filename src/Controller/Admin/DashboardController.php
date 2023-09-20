<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Company;
use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\Services;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;



class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        $url = $this->adminUrlGenerator->setController(UserCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Beheall');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard("BACKOFFICE", 'fa fa-home'),
            MenuItem::section('Comptes'),
            MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class),
            MenuItem::section('Entités'),
            MenuItem::linkToCrud('Entreprises', 'fas fa-building', Company::class),
            MenuItem::linkToCrud('Clients', 'fas fa-share', Customer::class),
            MenuItem::section('Facturations'),
            MenuItem::linkToCrud('Produits/Services', 'fab fa-product-hunt', Services::class),
            MenuItem::linkToCrud('Factures', 'fas fa-file-invoice', Invoice::class),
            MenuItem::section('Retour au site'),
            MenuItem::linkToUrl('Beheall', 'fas fa-external-link-alt', 'https://www.example.com')
        ];
    }
}