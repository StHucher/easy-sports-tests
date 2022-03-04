<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\User;
use App\Repository\ActivityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class PlayerByTeamType extends AbstractType
{   
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        $builder
            ->add('name')
            //query team where id user = get user id
        ;
        $formModifier = function (FormInterface $form, Team $team, Security $security, ActivityRepository $activityRepository) {

            $user = $security->getUser();
            $activities = $user->getActivities();
            $listTeamId = [];
            foreach($activities as $oneActivity){
                $teamId = $oneActivity->getTeam()->getId();
                $listTeamId [] = $teamId;

            }
            $PlayerByTeam = [];
            foreach($listTeamId as $oneTeamId){
                $players = $activityRepository->findBy(['team'=>$oneTeamId]);
                $PlayerByTeam [] = $players;
            }
            $form->add('User', EntityType::class, [
                'class' => User::class,
                'choices' => $PlayerByTeam,
            ]);

        };
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Team::class,
        ]);
    }
}
