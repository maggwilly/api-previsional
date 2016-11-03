<?php

namespace AppBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Produit;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
    	 $produits = array(
    	 new Produit("Margarine jadida 900 g",1150),
    	  new Produit("Margarine jadida 1Kg",1605),
    	 new Produit("Margarine jadida 4Kg",4100),
    	   new Produit("Margarine jadida 1Kg",1605),
    	    new Produit("Margarine jadida 4Kg",4100),
    	      new Produit("Mayonaise jadida 1litre",1050),
    	      new Produit("Mayonaise jadida 35 cl",625),
    	        new Produit("Mayonaise jadida 5litres", 7900),
    	         new Produit("Huile de soja jadida 1 litre",1300),
    	         new Produit("Huile de friture jadida 1Kg",1100),
    	          new Produit("Margarine laZiza 10Kg",13000),
    	            new Produit("Margarine laZiza 5Kg",6700));
    	 foreach ($produits as  $value) {
    	  $manager->persist($value);
    	 }
       
        $manager->flush();
    }
}