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

class CustomerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Customer::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('company')->setLabel('ID entreprise')->onlyOnIndex(),
            AssociationField::new('invoices', 'Factures')
                ->setLabel('IDs Factures')
                ->onlyOnIndex()
                ->formatValue(function ($value, $entity) {
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
            TextField::new('sirenSiret', 'SIREN/SIRET/RCS/RM')->onlyOnIndex(),
            TextField::new('website', 'Site web'),
            DateTimeField::new('createdAt', "Créer le")->setFormat('d/M/Y à H:m:s')->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::NEW);
        $actions->disable(Action::EDIT);
        return $actions;
    }
}
