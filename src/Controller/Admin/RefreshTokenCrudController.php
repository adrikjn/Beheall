<?php

namespace App\Controller\Admin;

use App\Entity\RefreshToken;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

// Contrôleur CRUD pour l'entité RefreshToken dans l'interface d'administration EasyAdmin.
class RefreshTokenCrudController extends AbstractCrudController
{
    // Retourne le FQCN (Fully Qualified Class Name) de l'entité gérée par ce contrôleur.
    public static function getEntityFqcn(): string
    {
        return RefreshToken::class;
    }

    // Configure les champs à afficher dans la vue de liste (index)
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('username', 'Email')->onlyOnIndex(),
            DateTimeField::new('valid', "Date du refresh")->setFormat('d/M/Y à H:m:s')->hideOnForm(),
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
