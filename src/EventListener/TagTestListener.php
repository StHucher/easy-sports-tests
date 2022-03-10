<?php

namespace App\EventListener;

use App\Entity\Tag;
use App\Entity\TagTest;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class TagTestListener
{


    public function updateTag(TagTest $tagTest)
    {
      

        $tagName = $tagTest->getTag()->getName();
       //dd($tagName === "Technique");

        if (($tagName === "Technique") or ($tagName === "Physique"))  {
            $tagTest->setIsPrimary(1);
        }
        else {
            $tagTest->setIsPrimary(0);
        }
       // dd($tagTest->getIsPrimary());
    }

}