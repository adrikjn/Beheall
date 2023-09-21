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

class InvoiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Invoice::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('company')->setLabel('ID company')->onlyOnIndex(),
            AssociationField::new('customer')->setLabel('ID customer')->onlyOnIndex(),
            AssociationField::new('services', 'Services')
                ->onlyOnIndex()
                ->formatValue(function ($value, $entity) {
                    $serviceIds = [];
                    foreach ($entity->getServices() as $service) {
                        $serviceIds[] = $service->getId();
                    }
                    return implode(', ', $serviceIds);
                }),
                TextField::new('bllNumber', 'Numéro de facture')->onlyOnIndex(),
                TextField::new('fromDate', 'Début')->onlyOnIndex(),
                TextField::new('deliveryDate', 'Fin/Le')->onlyOnIndex(),
                NumberField::new('totalPrice', 'Prix TTC')->onlyOnIndex(),
                TextField::new('status', 'Etat')->onlyOnIndex(),
                TextField::new('paymentMethod', 'Méthode de paiement')->onlyOnIndex(),
                TextField::new('billValidityDuration', 'Durée de paiment limite')->onlyOnIndex(),
                DateTimeField::new('createdAt', "Créer le")->setFormat('d/M/Y à H:m:s')->onlyOnIndex(),
        ];
    }
    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::NEW);
        $actions->disable(Action::EDIT);
        return $actions;
    }
}
