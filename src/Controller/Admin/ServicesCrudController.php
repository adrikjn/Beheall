<?php

namespace App\Controller\Admin;

use App\Entity\Services;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ServicesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Services::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('invoice')->setLabel('ID Facture')->onlyOnIndex(),
            TextField::new('title', 'Désignation')->onlyOnIndex(),
            TextareaField::new('description', 'Description')->onlyOnIndex(),
            NumberField::new('quantity', 'Quantité/Durée journalier')->onlyOnIndex(),
            NumberField::new('unitCost', 'PU/PJ')->onlyOnIndex(),
            NumberField::new('totalPrice', 'Prix HT')->onlyOnIndex(),
            NumberField::new('vat', 'TVA')->onlyOnIndex(),
            DateTimeField::new('createdAt', "Créer le")->setFormat('d/M/Y à H:m:s')->onlyOnIndex(),

        ];
    }
    
}
