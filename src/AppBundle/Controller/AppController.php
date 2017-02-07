<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Etape;
use AppBundle\Entity\Produit;
use AppBundle\Entity\PointVente;
use AppBundle\Entity\Synchro;
use AppBundle\Entity\Visite;
use AppBundle\Entity\Situation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 * Etape controller.
 *
 */
class AppController extends Controller
{
    /**
     * Lists all etape entities.
     *
     */
    public function indexAction()
    {
        


        return $this->render('layout.html.twig');
    }

    /**
     * Lists all etape entities.
     *
     */
    public function AccueilAction()
    {
        $em = $this->getDoctrine()->getManager();

        $session = $this->getRequest()->getSession();

    $nombrePointVente = $em->getRepository('AppBundle:PointVente')->nombrePointVente($session->get('region'),$session->get('startDate'),$session->get('endDate'));
    $nombrePointVenteVisite = $em->getRepository('AppBundle:PointVente')->nombrePointVenteVisite($session->get('region'),$session->get('startDate'),$session->get('endDate'));
    $nombreVisite = $em->getRepository('AppBundle:Visite')->nombreVisite($session->get('region'),$session->get('startDate'),$session->get('endDate'));
        $excApp = $em->getRepository('AppBundle:Visite')->excApp($session->get('region'),$session->get('startDate'),$session->get('endDate'));
      

        $situations = $em->getRepository('AppBundle:Produit')->stockParProduit($session->get('region'),$session->get('startDate'),$session->get('endDate'));

        $visibilites = $em->getRepository('AppBundle:Produit')->visibilitekParProduit($session->get('region'),$session->get('startDate'),$session->get('endDate'));

        $respectPrixs = $em->getRepository('AppBundle:Produit')->respectPrixParProduit($session->get('region'),$session->get('startDate'),$session->get('endDate'));

        $visitesParSemaine = $em->getRepository('AppBundle:PointVente')->visitesParSemaine($session->get('region'),$session->get('startDate'),$session->get('endDate'));

        return $this->render('AppBundle::layout.html.twig',
            array(
                'nombrePointVente'=>$nombrePointVente ,
                'nombrePointVenteVisite'=>$nombrePointVenteVisite,
                'nombreVisite'=>$nombreVisite,
                'tauxExc'=>$nombrePointVenteVisite>0?$excApp[0]['exc']*100/$nombrePointVenteVisite:'--',
                 'exc'=>$excApp[0]['exc'],
                'tauxApp'=>$nombrePointVenteVisite>0?$excApp[0]['sapp']*100/$nombrePointVenteVisite:'--',
                 'nApp'=>$nombrePointVenteVisite>0?$nombrePointVenteVisite-$excApp[0]['sapp']:'--',
                'tauxAff'=>$nombrePointVenteVisite>0?$excApp[0]['aff']*100/$nombrePointVenteVisite:'--',
                  'nAff'=>$nombrePointVenteVisite>0?$nombrePointVenteVisite-$excApp[0]['aff']:'--',
                'situations'=>$situations,
                'visibilites'=>$visibilites,
                'respectPrixs'=>$respectPrixs,
                'visitesParSemaine'=>$visitesParSemaine,
                ));
    }
    /**
     * Finds and displays a etape entity.
     *
     */
    public function setPeriodeAction(Request $request)
    {
  
        $region=$request->request->get('region');

        $periode= $request->request->get('periode');
        $dates = explode(" - ", $periode);
        $startDate=$dates[0];
        $endDate=$dates[1];
        $format = 'd/m/Y';
        $startDate= \DateTime::createFromFormat($format, $dates[0]);
        $endDate= \DateTime::createFromFormat($format, $dates[1]);
        $session = $this->getRequest()->getSession();
        $session->set('region',$region);
        $session->set('startDate',$startDate->format('Y-m-d'));
        $session->set('endDate',$endDate->format('Y-m-d'));

        $session->set('end_date_formated',$endDate->format('d/m/Y'));
        $session->set('start_date_formated',$startDate->format('d/m/Y'));

       $referer = $this->getRequest()->headers->get('referer');   
         return new RedirectResponse($referer);
    }

     public function loadDefaultAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $user= $this->getUser();

         $produits = array(
         new Produit("Jadida 4kg g","produit"),
         new Produit("Jadida 1Kg","produit"),
         new Produit("Jadida 900g","produit"),
         new Produit("Rosa 900g","concurrence"),
         new Produit("Rosa 4Kg","concurrence"),
         new Produit("Rosa 1Kg","concurence"),);
        
       $pointVentes = array(
         new PointVente(
          $user,
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
          $user,          
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
           $user,         
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
           $user,         
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
          $user,          
          "Chez Mama Tannefô",
          uniqid(),
          "Boutique détaillant",
          352.25641,
          352.28154,
          "Collé à lq station CRL, fâce un cyber-café Dior-Tech",
          new \DateTime('2017-01-30'),
          'Tannefô Marie Louse',
          'Pointe Noir'
          ),
          );

      $etapes = array(
    new Etape( $user,uniqid(),'debut', new \DateTime('2017-02-03'),new \DateTime('2017-02-03 07:30'),328.25641,302.25641,
    new Etape( $user,uniqid(),'fin', new \DateTime('2017-02-03'),new \DateTime('2017-02-03 16:30'),352.25641,345.25641)),
    new Etape( $user,uniqid(),'debut', new \DateTime('2017-02-04'),new \DateTime('2017-02-03 07:30'),352.25641,350.25641,
    new Etape( $user,uniqid(),'fin', new \DateTime('2017-02-04'),new \DateTime('2017-02-03 16:30'),322.25641,325.25641)),
    new Etape( $user,uniqid(),'debut', new \DateTime('2017-02-06'),new \DateTime('2017-02-06 07:54'),352.25641,325.25641, 
    new Etape( $user,uniqid(),'fin', new \DateTime('2017-02-06'),new \DateTime('2017-02-06 18:21'),352.25641,314.25641)),
    new Etape( $user,uniqid(),'debut', new \DateTime('2017-02-05'),new \DateTime('2017-02-03 07:30'),322.25641,325.25641),
    new Etape( $user,uniqid(),'debut', new \DateTime('2017-02-07'),new \DateTime('2017-02-07 08:11'),333.25641,336.25641),
         );  
   
   $synchros = array(
         new Synchro( $user,new \DateTime('2017-01-04 07:30')),
         new Synchro( $user,new \DateTime('2017-01-30 10:05')),
         new Synchro( $user,new \DateTime('2017-02-03 16:38')),
         new Synchro( $user,new \DateTime('2017-02-06 20:40')),
         new Synchro( $user,new \DateTime('2017-02-05 12:36')));

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
            $visite=new Visite( $user,uniqid(),new \DateTime('2017-01-'.rand(10,31)), $pointVente, $a[$random_keys[0]],$a[$random_keys[1]],$a[$random_keys[2]]); //a completer dans la bd
            foreach ($produits as  $produit) {
               $random_keys=array_rand($a,5);
 $visite->addSituation(
  new Situation(
    uniqid(),
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

    return $this->redirectToRoute('user_homepage');
    }

}
