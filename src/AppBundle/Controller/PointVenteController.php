<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PointVente;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Pointvente controller.
 *
 */
class PointVenteController extends Controller
{
    /**
     * Lists all pointVente entities.
     *
     */
    public function indexAction()
    {

      $session = $this->getRequest()->getSession();
       $em = $this->getDoctrine()->getManager();
        $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31');  
       $pointVentes = $em->getRepository('AppBundle:PointVente')->pointVentes($region,$startDate, $endDate);
      $nombrePointVente = $em->getRepository('AppBundle:PointVente')->nombrePointVente($region,$startDate, $endDate);
        return $this->render('pointvente/index.html.twig', array(
            'pointVentes' => $pointVentes,  'nombrePointVente' => $nombrePointVente,
        ));
    }

    /**
     * Finds and displays a pointVente entity.
     *
     */
    public function showAction(PointVente $pointVente)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $this->getRequest()->getSession();
        $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31');
        $visites  = $em->getRepository('AppBundle:Visite')->visites(null,null,$startDate, $endDate,$pointVente);
         $excAppPeriodePDV  = $em->getRepository('AppBundle:Visite')->excAppPeriodePDV($pointVente,$startDate, $endDate);
       $colors=array("#FF6384","#36A2EB","#FFCE56","#F7464A","#FF5A5E","#46BFBD", "#5AD3D1","#FDB45C","#FFC870", "#5AE4D1","#FDB478","#FFD973");
        return $this->render('pointvente/show.html.twig', array(
            'pointVente' => $pointVente,
             'taux'=>$excAppPeriodePDV[0],
             'colors'=>$colors,
            'visites' => new \Doctrine\Common\Collections\ArrayCollection($visites)
        ));
    }

     /**
     * Finds and displays a pointVente entity.
     *
     */
    public function eligiblesAction($note=0)
    {

    $em = $this->getDoctrine()->getManager();
      $session = $this->getRequest()->getSession();
        $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31');
      $eligibles = $em->getRepository('AppBundle:PointVente')->eligibles($region,$startDate, $endDate);
       $eligiblesranking = $em->getRepository('AppBundle:PointVente')->eligiblesranking($region,$startDate, $endDate);
       $nombrePointVenteVisite = $em->getRepository('AppBundle:PointVente')->nombrePointVenteVisite($region,$startDate, $endDate);
        return $this->render('pointvente/eligibles.html.twig', array(
            'eligibles' => $eligibles,  
            'eligiblesranking' => $eligiblesranking,
             'nombrePointVenteVisite' => $nombrePointVenteVisite,
        ));
    } 


     /**
     * Finds and displays a pointVente entity.
     *
     */
    public function mapAction()
    {

    $em = $this->getDoctrine()->getManager();
      $session = $this->getRequest()->getSession();
      $region=$session->get('region');
       $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31');
      $pointVentes = $em->getRepository('AppBundle:PointVente')->pointVentes($region,$startDate, $endDate);
     $nombrePointVente = $em->getRepository('AppBundle:PointVente')->nombrePointVente($region,$startDate, $endDate);
        return $this->render('pointvente/map.html.twig', array(
            'pointVentes' => $pointVentes,  'nombrePointVente' => $nombrePointVente,
        ));
    } 

    public function pdvExcelAction($name=null)
    {
      $em = $this->getDoctrine()->getManager();
      $session = $this->getRequest()->getSession();
      $region=$session->get('region');
      $startDate=$session->get('startDate',date('Y').'-01-01');
      $endDate=$session->get('endDate', date('Y').'-12-31');
      $periode= $session->get('periode');
      $pointVentes = $em->getRepository('AppBundle:PointVente')->pointVentes($region,$startDate, $endDate);
      
        // ask the service for a Excel5
       $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

       $phpExcelObject->getProperties()->setCreator("AllReport")
           ->setLastModifiedBy("AllReport")
           ->setTitle("Liste des points de vente")
           ->setSubject("Liste des points de vente")
           ->setDescription("Liste des points de vente")
           ->setKeywords("Liste des points de vente")
           ->setCategory("Rapports AllReport");
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A1', 'NOM')
               ->setCellValue('B1', 'MATRICULE')
               ->setCellValue('C1', 'CATEGORIE')
               ->setCellValue('D1', 'REGION')
               ->setCellValue('E1', 'QUARTIER')
               ->setCellValue('F1', 'DESCRIPTION')
               ->setCellValue('G1', 'MOIS DE CREATION')
               ->setCellValue('H1', 'TELEPHONE');
             foreach ($pointVentes as $key => $value) {
                // $startDate= \DateTime::createFromFormat('Y-m-d', $value['createdAt']);
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A'.($key+2), $value['nom'])
               ->setCellValue('B'.($key+2), $value['matricule'])
               ->setCellValue('C'.($key+2), $value['type'])
               ->setCellValue('D'.($key+2), $value['ville'])
               ->setCellValue('E'.($key+2), $value['quartier'])
               ->setCellValue('F'.($key+2), $value['description'])
               ->setCellValue('G'.($key+2), $value['createdAt']->format('M Y'))
               ->setCellValue('H'.($key+2), $value['tel']) ;
           };
            $format = 'd/m/Y';
       $phpExcelObject->getActiveSheet()->setTitle('liste-des-points-de-vente');
       // Set active sheet index to the first sheet, so Excel opens this as the first sheet
       $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'liste-des-points-de-vente.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;        
    }

public function boleanToString($boolVal){
    switch ($boolVal) {
        case 1:
            # code...
           return 'OUI';
        
        default:
            # code...
           return 'NON';
    }
}


     public function eligibiliteExcelAction($name=null)
    {
      $em = $this->getDoctrine()->getManager();
      $session = $this->getRequest()->getSession();
      $region=$session->get('region');
      $startDate=$session->get('startDate',date('Y').'-01-01');
      $endDate=$session->get('endDate', date('Y').'-12-31');
      $periode= $session->get('periode',' 01/01 - 31/12/'.date('Y'));
      $eligibles = $em->getRepository('AppBundle:PointVente')->eligibles($region,$startDate, $endDate);
      
        // ask the service for a Excel5
       $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

       $phpExcelObject->getProperties()->setCreator("AllReport")
           ->setLastModifiedBy("AllReport")
           ->setTitle("Eligibilité ".$region." de ".$periode)
           ->setSubject("Eligibilité ".$region." de ".$periode)
           ->setDescription("Eligibilité ".$region." de ".$periode)
           ->setKeywords("Eligibilité ".$region." de ".$periode)
           ->setCategory("Rapports AllReport");
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A1', 'NOM')
               ->setCellValue('B1', 'MATRICULE')
               ->setCellValue('C1', 'EXC')
               ->setCellValue('D1', 'MAP')
               ->setCellValue('E1', 'FKS')
               ->setCellValue('F1', 'FKL')
               ->setCellValue('G1', 'FMT')
               ->setCellValue('H1', 'FKM')
               ->setCellValue('I1', 'Stock total')
               ->setCellValue('J1', 'Points');
             foreach ($eligibles as $key => $value) {
                // $startDate= \DateTime::createFromFormat('Y-m-d', $value['createdAt']);
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A'.($key+2), $value['nom'])
               ->setCellValue('B'.($key+2), $value['matricule'])
               ->setCellValue('C'.($key+2), $this->boleanToString($value['exc']))
               ->setCellValue('D'.($key+2),  $this->boleanToString($value['map']))
               ->setCellValue('E'.($key+2), $value['fks'])
               ->setCellValue('F'.($key+2), $value['fkl'])
               ->setCellValue('G'.($key+2), $value['fmt'])
               ->setCellValue('H'.($key+2), $value['fkm']) 
               ->setCellValue('I'.($key+2), $value['stock'])
               ->setCellValue('J'.($key+2), $value['note'])  ;
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
            'eligibilites '.$region.' du '.$startDate->format('d M Y').' au '.$endDate->format('d M Y').'.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;        
    } 

     public function eligibiliteRackingExcelAction($name=null)
    {
      $em = $this->getDoctrine()->getManager();
      $session = $this->getRequest()->getSession();
      $region=$session->get('region');
      $startDate=$session->get('startDate',date('Y').'-01-01');
      $endDate=$session->get('endDate', date('Y').'-12-31');
      $periode= $session->get('periode',' 01/01 - 31/12/'.date('Y'));
      $eligibles = $em->getRepository('AppBundle:PointVente')->eligiblesranking($region,$startDate, $endDate);
      
        // ask the service for a Excel5
       $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

       $phpExcelObject->getProperties()->setCreator("AllReport")
           ->setLastModifiedBy("AllReport")
           ->setTitle("Racking ".$region." de ".$periode)
           ->setSubject("Eligibilité ".$region." de ".$periode)
           ->setDescription("Eligibilité ".$region." de ".$periode)
           ->setKeywords("Eligibilité ".$region." de ".$periode)
           ->setCategory("Rapports AllReport");
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A1', 'NOM')
               ->setCellValue('B1', 'MATRICULE')
               ->setCellValue('C1', 'EXC')
               ->setCellValue('D1', 'MAP')
               ->setCellValue('E1', 'FKS')
               ->setCellValue('F1', 'FKL')
               ->setCellValue('G1', 'FMT')
               ->setCellValue('H1', 'FKM')
               ->setCellValue('I1', 'Stock total')
               ->setCellValue('J1', 'Points');
             foreach ($eligibles as $key => $value) {
                // $startDate= \DateTime::createFromFormat('Y-m-d', $value['createdAt']);
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A'.($key+2), $value['nom'])
               ->setCellValue('B'.($key+2), $value['matricule'])
               ->setCellValue('C'.($key+2), $this->boleanToString($value['exc']))
               ->setCellValue('D'.($key+2),  $this->boleanToString($value['map']))
               ->setCellValue('E'.($key+2), $value['fks'])
               ->setCellValue('F'.($key+2), $value['fkl'])
               ->setCellValue('G'.($key+2), $value['fmt'])
               ->setCellValue('H'.($key+2), $value['fkm']) 
               ->setCellValue('I'.($key+2), $value['stock'])
               ->setCellValue('J'.($key+2), $value['note'])  ;
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
            'Racking '.$region.' du '.$startDate->format('d M Y').' au '.$endDate->format('d M Y').'.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;        
    }
    //apk
    public function importAction()
{
  $request = $this->get('request');
    $path = $this->get('kernel')->getRootDir(). "/../web/import/secteurs.xls";
     $objPHPExcel = $this->get('phpexcel')->createPHPExcelObject($path);

   foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    for ($row = 1; $row <= $highestRow; ++ $row) {


        for ($col = 0; $col < 2; ++ $col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = $cell->getValue();
        }
    }

} 
    $response = new Response();

    //set headers
    $response->headers->set('Content-Type', 'mime/type');
    $response->headers->set('Content-Disposition', 'attachment;filename="allreport_v1.0.8.1.apk"');

    $response->setContent($content);
    return $response;

 
}   
}
