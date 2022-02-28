<?php

namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\Tag;
use App\Entity\Team;
use App\Entity\Test;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Result;
use App\Entity\TagTest;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {   
        $listTeam = [];
        $Teams = ['Manchester.Utd','Liverpool','Arsenal','OL','Manchester City','Real Madrid','F.C Barcelone'];
        foreach($Teams as $value){
            $team = new Team();
            $team->setName($value);
            $team->setAgeCategory('U'.random_int(5,20));
            $team->setStatus(1);
            $listTeam [] = $team;
            $manager->persist($team);
        }
        $listTest = [];
        for($x = 1; $x <20; $x++){
            $test = new Test();
            $test->setName('Test'.$x);
            $test->setDescription('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.');
            $test->setUnit('mètres');
            $test->setSlug($x);
            $listTest [] = $test;
            $manager->persist($test);
        }
        $Users = ['joueur@joueur.com','coach@coach.com','admin@admin.com'];
        $listUsersObject = [];
        foreach($Users as $value){
            $user = new User();
            $explode = explode('@',$value);
            $user->setFirstname($explode[0]);
            $user->setLastname($explode[1]);
            $user->setEmail($value);
            $user->setBirthdate(new DateTime('now'));
            $user->setStatus(1);
            $activity = new Activity();
            $activity->setUser($user);
            $activity->setTeam($listTeam[random_int(0,6)]);
            $activity->setRole(random_int(0,1));
            $manager->persist($activity);
            $user->addActivity($activity);
            $user->setPassword(password_hash($explode[0],PASSWORD_DEFAULT));
            $user->setRoles([$explode[0]]);
            $user->setSlug($value);
            $listUsersObject [] = $user;
            $manager->persist($user);
        }
        
        

        $Tags = ['Vitesse','Force','Endurance','Technique','Physique','Dribbles','Passes','Jongles'];
        foreach($Tags as $value){
            $tag = new Tag();
            $tag->setName($value);
            $tagTest = new TagTest();
            $tagTest->setIsPrimary(random_int(0,1));
            $tagTest->setTest($listTest[random_int(0,18)]);
            $manager->persist($tagTest);
            $tag->addTagTest($tagTest);
            $manager->persist($tag);

        }
        for($y = 1; $y<15;$y++){
            $result = new Result();
            $result->setResult(random_int(1,124));
            $result->setStatus(random_int(0,1));
            $result->setDoneAt(new DateTime('now'));
            $result->setUser($listUsersObject[random_int(0,1)]);
            $result->setTest($listTest[random_int(0,18)]);
            $manager->persist($result);
        }


        $manager->flush();
    }
}
