<?php

namespace App\Form;

use App\Entity\Club;
use App\Entity\User;
use Doctrine\DBAL\Types\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'required' => true
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Etes-vous ?',
                'choices' => [
                    'Joueur' => 'ROLE_PLAYER',
                    'Entraineur' => 'ROLE_COACH'
                ],
                'multiple' => true,
                'expanded' => true
            ])
            ->add('password', PasswordType::class)
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ] )
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('birthdate', TypeDateType::class,[
                'label' => 'Date de naissance',
                'years' => range(1950,2050)
            ])
            /* ->add('status')
            ->add('slug')
            ->add('picture')
            ->add('city')
            ->add('club', EntityType::class,[
                'class' => Club::class,
                'choice_label'=> 'name',

                'multiple' => false,
                'expanded' => true,
            ]) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
