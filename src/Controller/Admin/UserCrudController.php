<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('email')->hideOnIndex(),
            TextField::new('password')->hideOnIndex(),
            TextField::new('Firstname'),
            TextField::new('Lastname'),
            DateField::new('birthdate')->hideOnIndex(),
            ImageField::new('picture')->hideOnIndex()->setUploadDir('public/uploads/images/users'),


            ChoiceField::new('roles')->setChoices([
                // $value => $badgeStyleName
                'Admin'  => 'ROLE_ADMIN',
                'Coach' => 'ROLE_COACH',
                'User' => 'ROLE_USER',
            ])->renderExpanded()->allowMultipleChoices(),


            ChoiceField::new('status')->setChoices([
                // $value => $badgeStyleName
                'Valide' => '1',
                'Compte suspendus' => '0',
            ]),

            TextField::new('slug')->hideOnIndex()->hideOnForm(),

        ];
    }
}
