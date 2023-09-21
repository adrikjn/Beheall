<?php

namespace App\Controller\Admin;

use App\Entity\RefreshToken;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class RefreshTokenCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RefreshToken::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('refresh_token', 'Tokens de rafraîchissement')->onlyOnIndex(),
            TextField::new('username', 'Email')->onlyOnIndex(),
            DateTimeField::new('valid', "Connexions")->setFormat('d/M/Y à H:m:s')->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::NEW);
        $actions->disable(Action::EDIT);
        return $actions;
    }
}
