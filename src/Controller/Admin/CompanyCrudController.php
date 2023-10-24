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

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('user')->setLabel('ID Utilisateur')->onlyOnIndex(),
            AssociationField::new('customers')
                ->setLabel('IDs Clients')
                ->onlyOnIndex()
                ->formatValue(function ($value, $entity) {
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
    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::NEW);
        $actions->disable(Action::EDIT);
        return $actions;
    }
}
