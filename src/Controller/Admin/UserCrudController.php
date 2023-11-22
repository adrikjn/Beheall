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
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

// Contrôleur CRUD pour l'entité User dans l'interface d'administration EasyAdmin.
class UserCrudController extends AbstractCrudController
{
    // Constructeur du contrôleur.
    // Le service de hachage de mot de passe.
    public function __construct(public UserPasswordHasherInterface $hasher)
    {
    }

    // Retourne le FQCN (Fully Qualified Class Name) de l'entité gérée par ce contrôleur.
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    // Configure les champs de l'entité pour chaque page de l'interface d'administration.
    // Type de champ / Apparition / Nom du champ / Label..
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email')->onlyOnIndex(),
            EmailField::new('email')->onlyWhenCreating(),
            TextField::new('plainPassword', 'Mot de passe*')
                ->setFormType(PasswordType::class)
                ->onlyWhenCreating(),
            TextField::new('lastName', 'Nom')->onlyOnIndex(),
            TextField::new('lastName', 'Nom')->onlyWhenCreating(),
            TextField::new('firstName', 'Prénom')->onlyOnIndex(),
            TextField::new('firstName', 'Prénom')->onlyWhenCreating(),
            TextField::new('phoneNumber', 'Numéro de téléphone')->onlyOnIndex(),
            TextField::new('phoneNumber', 'Numéro de téléphone')->onlyWhenCreating(),
            DateTimeField::new('createdAt', "Date de création")->setFormat('d/M/Y à H:m:s')->hideOnForm(),
            CollectionField::new('roles', 'Rôles')->setTemplatePath('admin/field/roles.html.twig'),
            AssociationField::new('companies', 'Entreprises')
                ->onlyOnIndex()
                ->formatValue(function ($value, $entity) {
                    $companies = $entity->getCompanies();
        
                    if ($companies->isEmpty()) {
                        return ''; 
                    }
        
                    $companyIds = [];
                    foreach ($companies as $company) {
                        $companyIds[] = $company->getId();
                    }
        
                    return implode(', ', $companyIds);
                }),
        ];
    }

    // Persiste une entité dans la base de données.
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance->getId()) {
            $entityInstance->setPassword(
                $this->hasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPlainPassword() // Utilisez getPlainPassword()
                )
            );
        }
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}
