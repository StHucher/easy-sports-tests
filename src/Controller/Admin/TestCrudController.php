<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\Test;
use App\Form\TagType;
use App\Repository\TagRepository;
use App\Repository\TagTestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\Form\ChoiceList\ChoiceList;

class TestCrudController extends AbstractCrudController
{


    private $entityManager;
    private $tagRepository;


    public function __construct(EntityManagerInterface $entityManager, TagRepository $tagRepository)
    {
        $this->entityManager = $entityManager;
        $this->tagRepository= $tagRepository;
    }

    public static function getEntityFqcn(): string
    {
        return Test::class;
    }


    
    public function configureFields(string $pageName): iterable
    {


              
           $association = ArrayField::new('tagTests')->setFormTypeOption('choice_label', 'tag')->setFormTypeOption(
                   'query_builder', function (TagTestRepository  $tagTestRepository){
                       return $tagTestRepository->findAll();   } 
                
           );
           $tags = $this->tagRepository->findAll();
           //dd($tags);

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            ImageField::new('media')->hideOnIndex()->setUploadDir('public/uploads/images/tests'),
            TextField::new('unit'),
            TextField::new('slug')->hideOnIndex()->hideOnForm(),
            AssociationField::new('tagTests')->setFormTypeOption('choice_label', 'tag')->setFormTypeOption('by_reference', false),

        ];        
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud 
          ->setDefaultSort(['name' => 'ASC']);
    } 
   
}
