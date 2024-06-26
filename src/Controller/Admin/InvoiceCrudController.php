<?php

namespace App\Controller\Admin;

use App\Entity\Invoice;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

// Contrôleur CRUD pour l'entité Invoice dans l'interface d'administration EasyAdmin.
class InvoiceCrudController extends AbstractCrudController
{
    // Retourne le FQCN (Fully Qualified Class Name) de l'entité gérée par ce contrôleur.
    public static function getEntityFqcn(): string
    {
        return Invoice::class;
    }

    // Configure les champs à afficher dans la vue de liste (index).
    // Type de champ / Apparition / Nom du champ / Label..
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('company')->setLabel('ID Entreprise')->onlyOnIndex(),
            AssociationField::new('customer')->setLabel('ID Client')->onlyOnIndex(),
            AssociationField::new('services', 'ID Produits/Services')
                ->onlyOnIndex()
                ->formatValue(function ($value, $entity) {
                    $serviceIds = [];
                    foreach ($entity->getServices() as $service) {
                        $serviceIds[] = $service->getId();
                    }
                    return implode(', ', $serviceIds);
                }),
            TextField::new('billNumber', 'Numéro de facture')->onlyOnIndex(),
            TextField::new('fromDate', 'Début')->onlyOnIndex()->formatValue(function ($value, $entity) {
                return $value ?? ''; // Si $value est null, renvoie une chaîne vide
            }),
            TextField::new('deliveryDate', 'Fin/Le')->onlyOnIndex(),
            NumberField::new('totalPrice', 'Prix TTC')->onlyOnIndex(),
            TextField::new('status', 'Etat')->onlyOnIndex(),
            TextField::new('paymentMethod', 'Méthode de paiement')->onlyOnIndex(),
            TextField::new('billValidityDuration', 'Validité de la facture')->onlyOnIndex(),
            DateTimeField::new('createdAt', "Date de création")->setFormat('d/M/Y à H:m:s')->onlyOnIndex(),
        ];
    }
    
    // Configure les actions disponibles pour l'entité dans l'interface d'administration.
    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::NEW);
        $actions->disable(Action::EDIT);
        return $actions;
    }
}
