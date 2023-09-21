<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

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
            AssociationField::new('user')->onlyOnIndex(),
            AssociationField::new('customers')
            ->setLabel('IDs des Clients')
            ->onlyOnIndex()
            ->formatValue(function ($value, $entity) {
                $customerIds = [];
                foreach ($entity->getCustomers() as $customer) {
                    $customerIds[] = $customer->getId();
                }
                return implode(', ', $customerIds);
            }),
        AssociationField::new('invoices')
            ->setLabel('IDs des Factures')
            ->onlyOnIndex()
            ->formatValue(function ($value, $entity) {
                $invoiceIds = [];
                foreach ($entity->getInvoices() as $invoice) {
                    $invoiceIds[] = $invoice->getId();
                }
                return implode(', ', $invoiceIds);
            }),
            // CollectionField::new('user', 'Utilisateur associé')
            //     ->formatValue(function ($value, $entity) {
            //         return $value ? $value->getId() : ''; // Affiche l'ID de l'utilisateur ou une chaîne vide si le champ est vide
            //     }),
            TextField::new('name', 'Nom d\'entreprise')->onlyOnIndex(),
            TextField::new('address', 'Adresse')->onlyOnIndex(),
            EmailField::new('email', 'Email')->onlyOnIndex(),
            TextField::new('phoneNumber', 'Numéro de téléphone')->onlyOnIndex(),
            TextField::new('city', 'Ville')->onlyOnIndex(),
            TextField::new('postalCode', 'Code postal')->onlyOnIndex(),
            TextField::new('sirenSiret', 'SIREN/SIRET/RCS/RM')->onlyOnIndex(),
            TextField::new('vatId', 'TVA Intracommunautaire')->onlyOnIndex(),
            TextField::new('website', 'Site web')
    ->onlyOnIndex()
    ->formatValue(function ($value, $entity) {
        return $value ?? ''; // Si $value est null, renvoie une chaîne vide
    }),
            DateTimeField::new('createdAt', "Créer le")->setFormat('d/M/Y à H:m:s')->onlyOnIndex(),
            
        ];
    }
}
