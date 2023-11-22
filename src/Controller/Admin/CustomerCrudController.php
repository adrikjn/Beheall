<?php

namespace App\Controller\Admin;

use App\Entity\Customer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

// Contrôleur CRUD pour l'entité Customer.
class CustomerCrudController extends AbstractCrudController
{
    // Récupère le nom qualifié de la classe de l'entité gérée par ce contrôleur.
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

    // Configure les champs à afficher dans la vue de liste (index).
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('company')->setLabel('ID Entreprise')->onlyOnIndex(),
            AssociationField::new('invoices', 'Factures')
                ->setLabel('IDs Factures')
                ->onlyOnIndex()
                ->formatValue(function ($value, $entity) {
                    // Formatage personnalisé des valeurs des factures pour l'affichage
                    $invoiceIds = [];
                    foreach ($entity->getInvoices() as $invoice) {
                        $invoiceIds[] = $invoice->getId();
                    }
                    return implode(', ', $invoiceIds);
                }),
            TextField::new('lastName', 'Nom')->onlyOnIndex(),
            TextField::new('firstName', 'Prénom')->onlyOnIndex(),
            TextField::new('companyName', 'Nom d\'entreprise')->onlyOnIndex(),
            EmailField::new('email', 'Email')->onlyOnIndex(),
            TextField::new('address', 'Adresse')->onlyOnIndex(),
            TextField::new('city', 'Ville')->onlyOnIndex(),
            TextField::new('postalCode', 'Code postal')->onlyOnIndex(),
            TextField::new('sirenSiret', 'SIREN/SIRET/RCS/RM')->onlyOnIndex()->formatValue(function ($value, $entity) {
                return $value ?? ''; // Si $value est null, renvoie une chaîne vide
            }),
            TextField::new('website', 'Site web')->formatValue(function ($value, $entity) {
                return $value ?? ''; // Si $value est null, renvoie une chaîne vide
            }),
            DateTimeField::new('createdAt', "Date de création")->setFormat('d/M/Y à H:m:s')->hideOnForm(),
        ];
    }

    // Configurer les actions disponibles pour l'entité.
    public function configureActions(Actions $actions): Actions
    {
        // Désactivation des actions NEW et EDIT
        $actions->disable(Action::NEW);
        $actions->disable(Action::EDIT);
        return $actions;
    }
}
