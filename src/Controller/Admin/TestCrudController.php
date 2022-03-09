<?php

namespace App\Controller\Admin;

use App\Entity\Test;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Test::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            ImageField::new('media')->hideOnIndex()->setUploadDir('public/uploads/images/tests'),
            TextField::new('unit'),
            TextField::new('slug')->hideOnIndex()->hideOnForm(),
        ];

        
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud 
          ->setDefaultSort(['name' => 'ASC']);
    } 
   
}
