<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

// Contrôleur CRUD pour l'entité Company.
class CompanyCrudController extends AbstractCrudController
{
    //  Récupère le nom qualifié de la classe de l'entité gérée par ce contrôleur.
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }


    // Configure les champs à afficher dans la vue de liste (index).
    public function configureFields(string $pageName): iterable
    {
        return [
            // Configuration des champs à afficher dans la vue de liste
            // Type de champ / Apparition / Nom du champ / Label..
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('user')->setLabel('ID Utilisateur')->onlyOnIndex(),
            AssociationField::new('customers')
                ->setLabel('IDs Clients')
                ->onlyOnIndex()
                ->formatValue(function ($value, $entity) {
                    // Formatage personnalisé des valeurs des clients pour l'affichage
                    $customerIds = [];
                    foreach ($entity->getCustomers() as $customer) {
                        $customerIds[] = $customer->getId();
                    }
                    return implode(', ', $customerIds);
                }),
            AssociationField::new('invoices')
                ->setLabel('IDs Factures')
                ->onlyOnIndex()
                ->formatValue(function ($value, $entity) {
                    $invoiceIds = [];
                    foreach ($entity->getInvoices() as $invoice) {
                        $invoiceIds[] = $invoice->getId();
                    }
                    return implode(', ', $invoiceIds);
                }),
            TextField::new('name', 'Nom d\'entreprise')->onlyOnIndex(),
            EmailField::new('email', 'Email')->onlyOnIndex(),
            TextField::new('phoneNumber', 'Numéro de téléphone')->onlyOnIndex(),
            TextField::new('address', 'Adresse')->onlyOnIndex(),
            TextField::new('city', 'Ville')->onlyOnIndex(),
            TextField::new('postalCode', 'Code postal')->onlyOnIndex(),
            TextField::new('sirenSiret', 'SIREN/SIRET/RCS/RM')->onlyOnIndex(),
            TextField::new('vatId', 'TVA Intracommunautaire')->onlyOnIndex()->formatValue(function ($value, $entity) {
                return $value ?? ''; // Si $value est null, renvoie une chaîne vide
            }),
            TextField::new('website', 'Site web')
                ->onlyOnIndex()
                ->formatValue(function ($value, $entity) {
                    return $value ?? ''; // Si $value est null, renvoie une chaîne vide
                }),
            DateTimeField::new('createdAt', "Date de création")->setFormat('d/M/Y à H:m:s')->onlyOnIndex(),

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
