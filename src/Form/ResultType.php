<?php

namespace App\Form;

use App\Entity\Result;
use App\Entity\Team;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('team', EntityType::class, [
            'class'=>Team::class,
            'choice_label' => 'name',
            'mapped' => false,
            'placeholder' => 'Choisissez une équipe',
            # querybuilder pour ne sélectionner que les équipes dont l'utilisateur est coach
        ])
        ->add('user', EntityType::class, [
            'class'=>User::class,
            'choice_label' => 'firstname',
            'label_attr' => array('class' => 'd-none'), # grâce à BS
            'attr' => array('class'=>'d-none')
        ])
        ->add('result', TextType::class, [
            'label' => 'Résultat',
            'label_attr' => array('class' => 'd-none'),
            'attr' => array('class'=>'d-none')
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Result::class,
        ]);
    }
}
