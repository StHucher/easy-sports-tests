<?php

namespace App\Form;

use App\Entity\Result;
use App\Entity\User;
use App\Repository\ActivityRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ResultType extends AbstractType
{   
    private $security;

    public function __construct(Security $security)
    {
            return $this->security = $security;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
            $builder
            ->add('result')
            // ->add('doneAt')
            // ->add('status')
            // ->add('test')
            // ->add('user', EntityType::class,[
            //     'class'=>User::class,
            // ])
        ;
            $user = $this->security->getUser();
            if (!$user) {
                throw new \LogicException(
                    'Il faut s\'identifier'
                );
            }
            $builder->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($user) {
                $form = $event->getForm();

                $formOptions = [
                'class' => User::class,
                'choice_label' => 'firstname',
                'query_builder' => function (UserRepository $userRepository) use ($user) {
                    // call a method on your repository that returns the query builder
                    return $userRepository->createPlayerFromMyTeamsQueryBuilder($user);
                },
            ];
            
            
                $form->add('User', EntityType::class, $formOptions);
            }
            );
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Result::class,
        ]);
    }
}
