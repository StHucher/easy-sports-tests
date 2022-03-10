<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\TagTest;
use App\Repository\TagRepository;
use App\Repository\TestRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TagTestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TagTest::class;
    }



    public function configureFields(string $pageName): iterable
    {
                  


      




        return [

                //$tags->->setFormTypeOptions(["choices" => $tags->toArray()]);
                
             //AssociationField::new('tag')->onlyOnForms()->setFormTypeOptions(["choices" => $tag->getName()->__toString()]), 
            yield AssociationField::new('test')->setFormTypeOption('disabled','disabled'),              
            yield AssociationField::new('tag'),     
   

               // AssociationField::new('test')->setCrudController(TestCrudController::class),
                //AssociationField::new('tag')->setCrudController(TagCrudController::class),
                //AssociationField::new('isPrimary')->setCrudController(TestCrudController::class),
            
        ];
    }

}