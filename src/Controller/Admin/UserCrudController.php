<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(public UserPasswordHasherInterface $hasher)
    {
    }


    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email')->onlyOnIndex(),
            EmailField::new('email')->onlyWhenCreating(),
            TextField::new('password', 'Mot de passe')->setFormType(PasswordType::class)->onlyWhenCreating(),

            TextField::new('lastName', 'Nom')->onlyOnIndex(),
            TextField::new('lastName', 'Nom')->onlyWhenCreating(),
            TextField::new('firstName', 'Prénom')->onlyOnIndex(),
            TextField::new('firstName', 'Prénom')->onlyWhenCreating(),
            TextField::new('phoneNumber', 'Numéro de téléphone')->onlyOnIndex(),
            TextField::new('phoneNumber', 'Numéro de téléphone')->onlyWhenCreating(),
            DateTimeField::new('createdAt', "Créer le")->setFormat('d/M/Y à H:m:s')->hideOnForm(),
            CollectionField::new('roles')->setTemplatePath('admin/field/roles.html.twig'),
            CollectionField::new('companies', 'Entreprises')
                ->onlyOnIndex()
                ->formatValue(function ($value, $entity) {
                    // Créez un tableau pour stocker les IDs des entreprises
                    $companyIds = [];

                    // Parcourez les entreprises associées à l'utilisateur
                    foreach ($entity->getCompanies() as $company) {
                        $companyIds[] = $company->getId();
                    }

                    // Retournez les IDs sous forme de chaîne de caractères séparée par des virgules
                    return implode(', ', $companyIds);
                }),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance->getId()) {
            $entityInstance->setPassword(
                $this->hasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPassword()
                )
            );
        }
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
