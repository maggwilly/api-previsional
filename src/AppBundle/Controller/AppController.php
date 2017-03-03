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
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use AppBundle\Entity\Secteur;
use AppBundle\Entity\Quartier;
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


   /* * Lists all etape entities.
     *
     */
    public function dernierAction()
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getRequest()->getSession();
        $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31');
        $nombrePointVente = $em->getRepository('AppBundle:PointVente')->nombrePointVente($region);
        $nombrePointVenteVisite = $em->getRepository('AppBundle:PointVente')->nombrePointVenteVisite($region,$startDate, $endDate);
        $nombreVisite = $em->getRepository('AppBundle:Visite')->nombreVisite($region,$startDate, $endDate);
        $excApp = $em->getRepository('AppBundle:Visite')->excAppDerniere($region,$startDate, $endDate);
        $excAppParSemaine = $em->getRepository('AppBundle:Visite')->excAppParSemaine($region,$startDate, $endDate);
        $stockSiatParSemaine = $em->getRepository('AppBundle:Produit')->stockSemaine('produit',$region,$startDate, $endDate);
        $stockConParSemaine = $em->getRepository('AppBundle:Produit')->stockSemaine('concurrence',$region,$startDate, $endDate);
        $situations = $em->getRepository('AppBundle:Situation')->stockParProduitDernier($region,$startDate, $endDate);
       
     //$concurents=array_column($situationsComparee, 'nomcon', 'id');
   $colors=array("#FF6384","#36A2EB","#FFCE56","#F7464A","#FF5A5E","#46BFBD", "#5AD3D1","#FDB45C","#FFC870", "#5AE4D1","#FDB478","#FFD973");
        return $this->render('statistiques/derniere.html.twig',
            array(
                'nombrePointVente'=>$nombrePointVente ,
                'nombrePointVenteVisite'=>$nombrePointVenteVisite,
                'nombreVisite'=>$nombreVisite,
                'tauxExc'=>$nombrePointVenteVisite>0?$excApp[0]['exc']*100/$nombrePointVenteVisite:'--',
                'exc'=>$excApp[0]['exc'],
                'tauxMap'=>$nombrePointVenteVisite>0?$excApp[0]['map']*100/$nombrePointVenteVisite:'--',
                'nMap'=>$nombrePointVenteVisite>0?$nombrePointVenteVisite-$excApp[0]['map']:'--',
                'tauxRpd'=>$nombrePointVenteVisite>0?$excApp[0]['rpd']*100/$nombrePointVenteVisite:'--',
                'nRpd'=>$nombrePointVenteVisite>0?$nombrePointVenteVisite-$excApp[0]['rpd']:'--',
                'tauxApp'=>$nombrePointVenteVisite>0?$excApp[0]['sapp']*100/$nombrePointVenteVisite:'--',
                'nApp'=>$nombrePointVenteVisite>0?$nombrePointVenteVisite-$excApp[0]['sapp']:'--',
                'tauxAff'=>$nombrePointVenteVisite>0?$excApp[0]['aff']*100/$nombrePointVenteVisite:'--',
                'nAff'=>$nombrePointVenteVisite>0?$nombrePointVenteVisite-$excApp[0]['aff']:'--',
                 'tauxpas_client'=>$nombrePointVenteVisite>0?(100-$excApp[0]['pas_client']*100/$nombrePointVenteVisite):'--',
                'pas_client'=>$excApp[0]['pas_client'],
               //'concurents'=>$concurents,
                'colors'=>$colors,
                'stockSiatParSemaine'=>$stockSiatParSemaine,
                 'stockConParSemaine'=>$stockConParSemaine,
                'excAppParSemaine'=>$excAppParSemaine,
                'situations'=>$situations
                ));
    }


   public function stockDernierExcelAction($name=null)
    {
      $em = $this->getDoctrine()->getManager();
      $session = $this->getRequest()->getSession();
      $region=$session->get('region');
      $startDate=$session->get('startDate',date('Y').'-01-01');
      $endDate=$session->get('endDate', date('Y').'-12-31');
      $periode= $session->get('periode',' 01/01 - 31/12/'.date('Y'));
      $situations = $em->getRepository('AppBundle:Situation')->stockParProduitDernier($region,$startDate, $endDate);
      $nombrePointVenteVisite = $em->getRepository('AppBundle:PointVente')->nombrePointVenteVisite($region,$startDate, $endDate);
        // ask the service for a Excel5
       $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

       $phpExcelObject->getProperties()->setCreator("AllReport")
           ->setLastModifiedBy("AllReport")
           ->setTitle("Derniere statistiques".$region." de ".$periode)
           ->setSubject("Derniere statistiques".$region." de ".$periode)
           ->setDescription("Derniere statistiques".$region." de ".$periode)
           ->setKeywords("Derniere statistiques".$region." de ".$periode)
           ->setCategory("Rapports AllReport");
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A1', 'Produit')
               ->setCellValue('B1', 'STOCK')
               ->setCellValue('C1', 'MOYENNE')
               ->setCellValue('D1', 'PRESENCE');
             foreach ($situations as $key => $value) {
                // $startDate= \DateTime::createFromFormat('Y-m-d', $value['createdAt']);
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A'.($key+2), $value['id'])
               ->setCellValue('B'.($key+2), $value['sd'])
               ->setCellValue('C'.($key+2), $nombrePointVenteVisite>0?$value['sd']/$nombrePointVenteVisite:"--")
               ->setCellValue('D'.($key+2), $nombrePointVenteVisite>0?$value['presence']*100/$nombrePointVenteVisite:"--");
               
           };
        $startDate=new \DateTime($startDate);
        $endDate= new \DateTime($endDate);
       $phpExcelObject->getActiveSheet()->setTitle('Du '.$startDate->format('d M Y').' au '.$endDate->format('d M Y'));
       // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'dernieres statistiques '.$region.' du '.$startDate->format('d M Y').' au '.$endDate->format('d M Y').'.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;        
    }

 
    /**
     * Lists all etape entities.
     *
     */
    public function periodeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $session = $this->getRequest()->getSession();
        $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31');
        $nombrePointVente = $em->getRepository('AppBundle:PointVente')->nombrePointVente($region);
        $nombrePointVenteVisite = $em->getRepository('AppBundle:PointVente')->nombrePointVenteVisite($region,$startDate, $endDate);
        $nombreVisite = $em->getRepository('AppBundle:Visite')->nombreVisite($region,$startDate, $endDate);
        $excApp = $em->getRepository('AppBundle:Visite')->excAppPeriode($region,$startDate, $endDate);
        $excAppParSemaine = $em->getRepository('AppBundle:Visite')->excAppParSemaine($region,$startDate, $endDate);
        $stockSiatParSemaine = $em->getRepository('AppBundle:Produit')->stockSemaine('produit',$region,$startDate, $endDate);
        $stockConParSemaine = $em->getRepository('AppBundle:Produit')->stockSemaine('concurrence',$region,$startDate, $endDate);
        $situations = $em->getRepository('AppBundle:Situation')->stockParProduitPeriode($region,$startDate, $endDate);  
     //$concurents=array_column($situationsComparee, 'nomcon', 'id');
       $colors=array("#FF6384","#36A2EB","#FFCE56","#F7464A","#FF5A5E","#46BFBD", "#5AD3D1","#FDB45C","#FFC870", "#5AE4D1","#FDB478","#FFD973");
        return $this->render('statistiques/periode.html.twig',
            array(
                'nombrePointVente'=>$nombrePointVente ,
                'nombrePointVenteVisite'=>$nombrePointVenteVisite,
                'nombreVisite'=>$nombreVisite,
                'taux'=>$excApp[0],
                'colors'=>$colors,
                'stockSiatParSemaine'=>$stockSiatParSemaine,
                'stockConParSemaine'=>$stockConParSemaine,
                'excAppParSemaine'=>$excAppParSemaine,
                'situations'=>$situations
                ));
    }


       public function stockPeriodeExcelAction($name=null)
    {
      $em = $this->getDoctrine()->getManager();
      $session = $this->getRequest()->getSession();
      $region=$session->get('region');
      $startDate=$session->get('startDate',date('Y').'-01-01');
      $endDate=$session->get('endDate', date('Y').'-12-31');
      $periode= $session->get('periode',' 01/01 - 31/12/'.date('Y'));
      $situations = $em->getRepository('AppBundle:Situation')->stockParProduitPeriode($region,$startDate, $endDate);
      $nombrePointVenteVisite = $em->getRepository('AppBundle:PointVente')->nombrePointVenteVisite($region,$startDate, $endDate);
        // ask the service for a Excel5
       $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

       $phpExcelObject->getProperties()->setCreator("AllReport")
           ->setLastModifiedBy("AllReport")
           ->setTitle("statistiques periode".$region." de ".$periode)
           ->setSubject("statistiques periode".$region." de ".$periode)
           ->setDescription("statistiques periode".$region." de ".$periode)
           ->setKeywords("statistiques periode".$region." de ".$periode)
           ->setCategory("Rapports AllReport");
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A1', 'Produit')
               ->setCellValue('B1', 'STOCK')
               ->setCellValue('C1', 'MOYENNE')
               ->setCellValue('D1', 'PRESENCE');
             foreach ($situations as $key => $value) {
                // $startDate= \DateTime::createFromFormat('Y-m-d', $value['createdAt']);
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A'.($key+2), $value['nom'])
               ->setCellValue('B'.($key+2), $value['sd'])
               ->setCellValue('C'.($key+2), $value['moyenne'])
               ->setCellValue('D'.($key+2), $value['presence']*100);
               
           };
        $startDate=new \DateTime($startDate);
        $endDate= new \DateTime($endDate);
        $phpExcelObject->getActiveSheet()->setTitle('Du '.$startDate->format('d M Y').' au '.$endDate->format('d M Y'));
       // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       $phpExcelObject->setActiveSheetIndex(0);
        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'statistiques periodiques'.$region.' du '.$startDate->format('d M Y').' au '.$endDate->format('d M Y').'.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;        
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
        $session->set('periode',$periode);
        $session->set('end_date_formated',$endDate->format('d/m/Y'));
        $session->set('start_date_formated',$startDate->format('d/m/Y'));
       $referer = $this->getRequest()->headers->get('referer');   
         return new RedirectResponse($referer);
    }



    /*load secteurs from excel*/
  public function loadSecteursAction()
    {
        $manager = $this->getDoctrine()->getManager();
    $path = $this->get('kernel')->getRootDir(). "/../web/import/segmentation.xlsx";
     $objPHPExcel = $this->get('phpexcel')->createPHPExcelObject($path);
    $secteurs= $objPHPExcel->getSheet(0);
    $highestRow  = $secteurs->getHighestRow(); // e.g. 10
    for ($row = 2; $row <= $highestRow; ++ $row) {
            $ville = $secteurs->getCellByColumnAndRow(0, $row);
             $numero = $secteurs->getCellByColumnAndRow(1, $row);
            $secteur=new Secteur( $ville->getValue(),$numero->getValue());
             $manager->persist($secteur);
    }
     $manager->flush();
    return $this->redirectToRoute('user_homepage');      
    }

    /*load secteurs from excel*/
  public function loadQuartiersAction()
    {
    $manager = $this->getDoctrine()->getManager();
    $path = $this->get('kernel')->getRootDir(). "/../web/import/segmentation.xlsx";
     $objPHPExcel = $this->get('phpexcel')->createPHPExcelObject($path);
    $quartiers= $objPHPExcel->getSheet(1);
    $highestRow  = $quartiers->getHighestRow(); // e.g. 10
    for ($row = 2; $row <= $highestRow; ++ $row) {
            $id = $quartiers->getCellByColumnAndRow(0, $row);
             $idSecteur = $quartiers->getCellByColumnAndRow(1, $row);       
            $idSecteur=$idSecteur->getValue();
   $RAW_QUERY='insert into quartier (id,secteur_id) values (:id,:secteur);' ;
    $statement = $manager->getConnection()->prepare($RAW_QUERY);
    $statement->bindValue('id', $id ->getValue());
    $statement->bindValue('secteur', $idSecteur);  
    $statement->execute(); 
    }
 
    return $this->redirectToRoute('user_homepage');      
    } 
/*load default visite*/

  public function loadDefaultVisiteAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $user= $this->getUser();
        $pointVentes = $manager->getRepository('AppBundle:PointVente')->findAll();
        $produits = $manager->getRepository('AppBundle:Produit')->findAll();
         $a=array(true,null,true,true,null,true,true,true);
      foreach ($pointVentes as $key => $pointVente) {
           $random_keys=array_rand($a,7);
            $visite=new Visite( 
              $user,
              uniqid(),
              new \DateTime('2017-'.rand(1,12).'-'.rand(10,31)),
               $pointVente,
                $a[$random_keys[0]]
                ,$a[$random_keys[1]]
                ,$a[$random_keys[2]]
                 ,$a[$random_keys[3]]
                  ,$a[$random_keys[4]]
                  ,$a[$random_keys[6]]
                  ,$a[$random_keys[5]]
                ); 
            //a completer dans la bd
            foreach ($produits as  $produit) {
               $random_keys=array_rand($a,5);
 $visite->addSituation(
  new Situation(
    uniqid(),
   $produit,
   $a[$random_keys[0]],
   $a[$random_keys[1]],
   $a[$random_keys[3]],
   rand(10,1000),
   rand(0,200),
   rand(7,21),
   rand(10,500),
   $a[$random_keys[2]],
   $a[$random_keys[4]]));
            }
          $pointVente->addVisite($visite);
          $manager->persist($pointVente);
         }
     $manager->flush();
    return $this->redirectToRoute('user_homepage');      
    }



  public function loadDefaultSynchroAction()
    {
        $manager = $this->getDoctrine()->getManager();
      
        $users = $manager->getRepository('AppBundle:Client')->findAll();
       
      foreach ($users as $key => $user) {
        $synchro= new Synchro( $user,new \DateTime('2017-01-'.rand(10,31).' '.rand(9,23).':'.rand(9,58)));
         $manager->persist($synchro);
         }
        $manager->flush();
    return $this->redirectToRoute('user_homepage');      
    }

  public function loadDefaultEtapeAction()
    {
        $manager = $this->getDoctrine()->getManager();
      
        $users = $manager->getRepository('AppBundle:Client')->findAll();
       
      foreach ($users as $key => $user) {
        $day=rand(10,31);
        $etape= new Etape( $user,uniqid(),'debut', new \DateTime('2017-02-'.$day),new \DateTime('2017-01-'.$day.' '.rand(5,22).':'.rand(9,58)),328.25641,302.25641,
           new Etape( $user,uniqid(),'fin', new \DateTime('2017-02-'.$day),new \DateTime('2017-01-'.$day.' '.rand(5,22).':'.rand(9,58)),352.25641,345.25641));
         $manager->persist($etape);
         }
        $manager->flush();
    return $this->redirectToRoute('user_homepage');      
    }
//load default data
     public function loadDefaultProduitAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $user= $this->getUser();

       $produits = array(
 
       new Produit("FKS","produit"),
       new Produit("FKM","produit"),
       new Produit("FKL","produit"),
       new Produit("FMT","produit"),
       new Produit("SUPER MATCH","concurrence"),
       new Produit("L-M","concurrence"),
       new Produit("DUNHIL","concurrence"),
       new Produit("MALBORO","concurrence")
  );
        


         foreach ($produits as  $value) {
             $manager->persist($value);
         }
 

        $manager->flush();

    return $this->redirectToRoute('user_homepage');
    }

//load default data
     public function loadDefaultPointVenteAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $user= $this->getUser();

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
        


         foreach ($pointVentes as  $value) {
             $manager->persist($value);
         }
 
        $manager->flush();

    return $this->redirectToRoute('user_homepage');
    }
//load default data
     public function loadDefaultAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $user= $this->getUser();

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
           $random_keys=array_rand($a,5);
            $visite=new Visite( 
              $user,
              uniqid(),
              new \DateTime('2017-'.rand(1,12).'-'.rand(10,31)),
               $pointVente,
                $a[$random_keys[0]]
                ,$a[$random_keys[1]]
                ,$a[$random_keys[2]]
                ); 
            //a completer dans la bd
            foreach ($produits as  $produit) {
               $random_keys=array_rand($a,5);
 $visite->addSituation(
  new Situation(
    uniqid(),
   $produit,
   $a[$random_keys[0]],
   $a[$random_keys[1]],
   $a[$random_keys[3]],
   rand(10,1000),
   rand(0,200),
   rand(7,21),
   rand(10,500),
   $a[$random_keys[2]],
   $a[$random_keys[4]]));
            }
          $pointVente->addVisite($visite);
          $manager->persist($pointVente);
         }

        $manager->flush();

    return $this->redirectToRoute('user_homepage');
    }

}
