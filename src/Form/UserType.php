<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'label' => 'Etes-vous ?',
                'choices' => [
                    'Joueur' => 'ROLE_PLAYER',
                    'Entraineur' => 'ROLE_COACH'
                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('password')
            ->add('firstname')
            ->add('lastname')
            ->add('birthdate')
            ->add('status')
            ->add('slug')
            ->add('picture')
            ->add('city')
            ->add('club', EntityType::class,[
                'class' => Club::class,
                'choice_label'=> 'name',

                'multiple' => false,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
