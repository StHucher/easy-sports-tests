<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\TagTest;
use App\Repository\TagRepository;
use App\Repository\TestRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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

        

                //$tags->->setFormTypeOptions(["choices" => $tags->toArray()]);
                
             //AssociationField::new('tag')->onlyOnForms()->setFormTypeOptions(["choices" => $tag->getName()->__toString()]), 
            // yield AssociationField::new('test')->setFormTypeOption('disabled','disabled'),      
            
            
            if ($pageName === Crud::PAGE_EDIT) {
                $fields [] = yield AssociationField::new('test')->setFormTypeOption('disabled','disabled');
            }
            else {
                $fields [] = yield AssociationField::new('test');
            }

            $fields = [ 
                
                yield AssociationField::new('tag'),     
                yield ChoiceField::new('isPrimary')->setChoices([
                    'non-primary' => 0,
                    'primary' => 1 
                ])->hideOnForm(), 
            ];
    

               // AssociationField::new('test')->setCrudController(TestCrudController::class),
                //AssociationField::new('tag')->setCrudController(TagCrudController::class),
                //AssociationField::new('isPrimary')->setCrudController(TestCrudController::class),
            
    


        return $fields;


    }

}
