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
       $concur1=new Produit("Rosa 4Kg","concurrence");
       $concur2= new Produit("Rosa 1Kg","concurrence");
       $concur3= new Produit("Rosa 900g","concurrence");

    	 $produits = array(
        $concur1,
        $concur2,
        $concur3,
        new Produit("Jadida 2kg prestige","produit"),
    	 new Produit("Jadida 4kg g","produit",$concur1),
    	 new Produit("Jadida 1Kg","produit",   $concur2),
       new Produit("Jadida 900g","produit",  $concur3)
  );
        
       $pointVentes = array(
         new PointVente(
           null,
          "MaTiness SARL",
          uniqid(),
          "Super Marché",
          352.25641,
          352.28154,
          "A côté de la banaue UBC centrale, 300 metres avant le tresor",
          new \DateTime('2017-01-03'),
          'M. Noumssi Athanaz',
          'BRAZAVILLE'
          ),
          new PointVente(
            null, 
          "LART INC-TECH",
          uniqid(),
          "Boutique grossiste",
          353.25641,
          332.28454,
          "En fâce de la banaue AFBC, 100 metres en venant du marché",
          new \DateTime('2017-02-03 '),
          'M. Mikam Roméo Landry',
          'BRAZAVILLE'
          ),
         new PointVente(
           null,
          "Evil ",
          uniqid(),
          "Superette",
          352.25641,
          352.28154,
          "En fâce de la TSARL SA, 100 metres en venant du marché des pagnes",
          new \DateTime('2017-01-02 '),
          'Mlle Esso Ingrid Tatiana',
          'BRAZAVILLE'
          ),
          new PointVente(
            null,
          "Chez Aoudou",
          uniqid(),
          "Echope de quartier",
          352.25641,
          352.28154,
          "Carrefour ASSO 2ieme, 20 metres du grand hangard",
          new \DateTime('2017-02-05'),
          'Mouamadou Sliou Alassan',
          'Pointe Noir'
          ),
         new PointVente(
           null,
          "Chez Mama Tannefô",
          uniqid(),
          "Boutique détaillant",
          352.25641,
          352.28154,
          "Collé à lq station CRL, fâce un cyber-café Dior-Tech",
          new \DateTime('2017-01-30'),
          'Tannefô Marie Louse',
          'Pointe Noir'
          )
          );

      $etapes = array(
    new Etape( null,null,'debut', new \DateTime('2017-02-03'),new \DateTime('2017-02-03 07:30'),328.25641,302.25641,
     new Etape( null,null,'fin', new \DateTime('2017-02-03'),new \DateTime('2017-02-03 16:30'),352.25641,345.25641)),
    new Etape( null,null,'debut', new \DateTime('2017-02-04'),new \DateTime('2017-02-03 07:30'),352.25641,350.25641,
     new Etape( null,null,'fin', new \DateTime('2017-02-04'),new \DateTime('2017-02-03 16:30'),322.25641,325.25641)),
     new Etape( null,null,'debut', new \DateTime('2017-02-06'),new \DateTime('2017-02-06 07:54'),352.25641,325.25641, 
      new Etape( null,null,'fin', new \DateTime('2017-02-06'),new \DateTime('2017-02-06 18:21'),352.25641,314.25641)),
    new Etape( null,null,'debut', new \DateTime('2017-02-05'),new \DateTime('2017-02-03 07:30'),322.25641,325.25641),
    new Etape( null,null,'debut', new \DateTime('2017-02-07'),new \DateTime('2017-02-07 08:11'),333.25641,336.25641),
         );  
   
   $synchros = array(
         new Synchro( null,new \DateTime('2017-01-04 07:30')),
         new Synchro( null,new \DateTime('2017-01-30 10:05')),
         new Synchro( null,new \DateTime('2017-02-03 16:38')),
         new Synchro( null,new \DateTime('2017-02-06 20:40')),
         new Synchro( null,new \DateTime('2017-02-05 12:36')));

     foreach ($etapes as  $value) {
           $manager->persist($value);
       }

      foreach ($synchros as  $value) {
           $manager->persist($value);
       }

    	 foreach ($produits as  $value) {
    	     $manager->persist($value);
    	 }

       $a=array(true,null,true,null,null,true);
        foreach ($pointVentes as $key => $pointVente) {
           $random_keys=array_rand($a,3);
            $visite=new Visite( null,uniqid(),new \DateTime('2017-01-'.rand(10,31)), $pointVente, $a[$random_keys[0]],$a[$random_keys[1]],$a[$random_keys[2]]); //a completer dans la bd
            foreach ($produits as  $produit) {
               $random_keys=array_rand($a,5);
 $visite->addSituation(
  new Situation(
   null,
   $produit,
   $a[$random_keys[0]],
   $a[$random_keys[1]],
   $a[$random_keys[2]],
   rand(10,1000),
   rand(0,200),
   rand(7,21),
   rand(10,500),
   $a[$random_keys[3]],
   $a[$random_keys[4]]));
            }
          $pointVente->addVisite($visite);
          $manager->persist($pointVente);
         }

        $manager->flush();
    }


}