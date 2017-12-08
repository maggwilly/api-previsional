<?php

namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Produit;
use AppBundle\Entity\PointVente;
use AppBundle\Entity\Situation;
use AppBundle\Entity\Visite;
use AppBundle\Entity\Etape;
use AppBundle\Entity\Synchro;
class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
       
        
     

        $manager->flush();
    }


}