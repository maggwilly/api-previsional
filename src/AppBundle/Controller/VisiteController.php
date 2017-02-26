<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Visite controller.
 *
 */
class VisiteController extends Controller
{
    /**
     * Lists all visite entities.
     *
     */
    public function visitesParPDVAction()
    {
        $session = $this->getRequest()->getSession();

        $em = $this->getDoctrine()->getManager();
         $session = $this->getRequest()->getSession();
        $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31')
         ;
        $visitesParPDV = $em->getRepository('AppBundle:Visite')->visitesParPDVDetaillees($region,$startDate, $endDate);

        return $this->render('visite/visitespdv.html.twig', array(
            'visitesParPDV' => $visitesParPDV
        ));
    }


    /**
     * Lists all visite entities.
     *
     */
    public function visitesAction()
    {
        $session = $this->getRequest()->getSession();

        $em = $this->getDoctrine()->getManager();
         $session = $this->getRequest()->getSession();
        $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31')
         ;
        $visites = $em->getRepository('AppBundle:Visite')->visites(null,$region,$startDate, $endDate,null);
        return $this->render('visite/visites.html.twig', array(
            'visites' => $visites
        ));
    }
    /**
     * Finds and displays a visite entity.
     *
     */
    public function showAction(Visite $visite)
    {

        return $this->render('visite/show.html.twig', array(
            'visite' => $visite,
        ));
    }

public function boleanToString($boolVal,$id=true){
    if ($boolVal&&$id) 
     return 'OUI';
     elseif ($id) 
       return 'NON';
      else
       return '';
   
}

public function numberToString($intVal,$id=true){
    if ($intVal&&$id) 
     return $intVal;
     elseif ($id) 
       return $intVal;
      else
       return '';
   
}
       public function visitesExcelAction($name=null)
    {
      $em = $this->getDoctrine()->getManager();
      $session = $this->getRequest()->getSession();
      $region=$session->get('region');
      $startDate=$session->get('startDate',date('Y').'-01-01');
      $endDate=$session->get('endDate', date('Y').'-12-31');
      $periode= $session->get('periode',' 01/01 - 31/12/'.date('Y'));
      $visites = $em->getRepository('AppBundle:Visite')->visitesDetaillees($region,$startDate, $endDate);
      
        // ask the service for a Excel5
       $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

       $phpExcelObject->getProperties()->setCreator("AllReport")
           ->setLastModifiedBy("AllReport")
           ->setTitle("Historique des visites ".$region." de ".$periode)
           ->setSubject("Historique des visites ".$region." de ".$periode)
           ->setDescription("Historique des visites ".$region." de ".$periode)
           ->setKeywords("Historique des visites".$region." de ".$periode)
           ->setCategory("Rapports AllReport");
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A1', 'PDV')
               ->setCellValue('B1', 'Auditeur')
               ->setCellValue('C1', 'date')
               ->setCellValue('D1', 'FKS')
               ->setCellValue('E1', 'FKL')
               ->setCellValue('F1', 'FMT')
               ->setCellValue('G1', 'FKM')
               ->setCellValue('H1', 'DUNHIL')
               ->setCellValue('I1', 'L-M')
               ->setCellValue('J1', 'MALBORO')
               ->setCellValue('K1', 'SUPER MATCH')
               ->setCellValue('L1', 'EXC')
               ->setCellValue('M1', 'MAP')
               ->setCellValue('N1', 'PRE')
               ->setCellValue('O1', 'RPD')
               ->setCellValue('P1', 'RPP')
               ->setCellValue('Q1', 'AP AC')
               ->setCellValue('R1', 'EST-IL OUVERT')
               ->setCellValue('S1', 'RAISON FERMETURE')
               ->setCellValue('T1', 'EST-IL CLIENT')
               ->setCellValue('U1', 'RAISON NON CLIENT')
               ->setCellValue('V1', 'COMMENTAIRE')
               ;
             foreach ($visites as $key => $value) {
                $date=new \DateTime($value['date']);
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A'.($key+2), $value['nom'])
               ->setCellValue('B'.($key+2), $value['auditeur'])
               ->setCellValue('C'.($key+2), $date->format('d/m/Y'))
               ->setCellValue('D'.($key+2), $value['fks'])
               ->setCellValue('E'.($key+2), $value['fkl'])
               ->setCellValue('F'.($key+2), $value['fmt'])
               ->setCellValue('G'.($key+2), $value['fkm']) 
               ->setCellValue('H'.($key+2), $value['dunhil'])
               ->setCellValue('I'.($key+2), $value['l_m'])
               ->setCellValue('J'.($key+2), $value['malboro'])
               ->setCellValue('K'.($key+2), $value['super_match'])                
               ->setCellValue('L'.($key+2), $this->boleanToString($value['exc']))
               ->setCellValue('M'.($key+2), $this->boleanToString($value['map'])) 
               ->setCellValue('N'.($key+2), $this->boleanToString($value['pre']))
               ->setCellValue('O'.($key+2), $this->boleanToString($value['rpd'])) 
               ->setCellValue('P'.($key+2), $this->boleanToString($value['rpp']))
               ->setCellValue('Q'.($key+2), $this->boleanToString($value['sapp'])) 
               ->setCellValue('R'.($key+2), $this->boleanToString(!$value['pas_ouvert']))
               ->setCellValue('S'.($key+2), $value['raison_pas_ouvert']) 
               ->setCellValue('T'.($key+2), $this->boleanToString(!$value['pas_client']))
               ->setCellValue('U'.($key+2), $value['raison_pas_client'])
               ->setCellValue('V'.($key+2), $value['commentaire'])   ;
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
            'visites '.$region.' du '.$startDate->format('d M Y').' au '.$endDate->format('d M Y').'.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;        
    } 

  public function derniereVisiteExcelAction($name=null)
    {
      $em = $this->getDoctrine()->getManager();
      $session = $this->getRequest()->getSession();
      $region=$session->get('region');
      $startDate=$session->get('startDate',date('Y').'-01-01');
      $endDate=$session->get('endDate', date('Y').'-12-31');
      $periode= $session->get('periode',' 01/01 - 31/12/'.date('Y'));
      $visites = $em->getRepository('AppBundle:Visite')->visitesParPDVDetaillees($region,$startDate, $endDate);
      
        // ask the service for a Excel5
       $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

       $phpExcelObject->getProperties()->setCreator("AllReport")
           ->setLastModifiedBy("AllReport")
           ->setTitle("Dernières visites ".$region." de ".$periode)
           ->setSubject("Dernières visites ".$region." de ".$periode)
           ->setDescription("Dernières visites ".$region." de ".$periode)
           ->setKeywords("Dernières visites".$region." de ".$periode)
           ->setCategory("Rapports AllReport");
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A1', 'PDV')
               ->setCellValue('B1', 'Auditeur')
               ->setCellValue('C1', 'date')
               ->setCellValue('D1', 'FKS')
               ->setCellValue('E1', 'FKL')
               ->setCellValue('F1', 'FMT')
               ->setCellValue('G1', 'FKM')
               ->setCellValue('H1', 'DUNHIL')
               ->setCellValue('I1', 'L-M')
               ->setCellValue('J1', 'MALBORO')
               ->setCellValue('K1', 'SUPER MATCH')
               ->setCellValue('L1', 'EXC')
               ->setCellValue('M1', 'MAP')
               ->setCellValue('N1', 'PRE')
               ->setCellValue('O1', 'RPD')
               ->setCellValue('P1', 'RPP')
               ->setCellValue('Q1', 'AP AC')
               ->setCellValue('R1', 'EST-IL OUVERT')
               ->setCellValue('S1', 'RAISON FERMETURE')
               ->setCellValue('T1', 'EST-IL CLIENT')
               ->setCellValue('U1', 'RAISON NON CLIENT')
               ->setCellValue('V1', 'COMMENTAIRE')
               ;
             foreach ($visites as $key => $value) {
                $date=($value['date'])?new \DateTime($value['date']):null;
               $phpExcelObject->setActiveSheetIndex(0)
               ->setCellValue('A'.($key+2), $value['nom'])
               ->setCellValue('B'.($key+2), $value['auditeur']?$value['auditeur']:'Personne')
               ->setCellValue('C'.($key+2), $date?$date->format('d/m/Y'):'Aucune visite')
               ->setCellValue('D'.($key+2), $this->numberToString($value['fks'],$value['id']))
               ->setCellValue('E'.($key+2), $this->numberToString($value['fkl'],$value['id']))
               ->setCellValue('F'.($key+2), $this->numberToString($value['fmt'],$value['id']))
               ->setCellValue('G'.($key+2), $this->numberToString($value['fkm'],$value['id'])) 
               ->setCellValue('H'.($key+2), $this->numberToString($value['dunhil'],$value['id']))
               ->setCellValue('I'.($key+2), $this->numberToString($value['l_m'],$value['id']))
               ->setCellValue('J'.($key+2), $this->numberToString($value['malboro'],$value['id']))
               ->setCellValue('K'.($key+2), $this->numberToString($value['super_match'],$value['id']))                
               ->setCellValue('L'.($key+2), $this->boleanToString($value['exc'],$value['id']))
               ->setCellValue('M'.($key+2), $this->boleanToString($value['map'],$value['id'])) 
               ->setCellValue('N'.($key+2), $this->boleanToString($value['pre'],$value['id']))
               ->setCellValue('O'.($key+2), $this->boleanToString($value['rpd'],$value['id'])) 
               ->setCellValue('P'.($key+2), $this->boleanToString($value['rpp'],$value['id']))
               ->setCellValue('Q'.($key+2), $this->boleanToString($value['sapp'],$value['id'])) 
               ->setCellValue('R'.($key+2), $this->boleanToString(!$value['pas_ouvert'],$value['id']))
               ->setCellValue('S'.($key+2), $value['raison_pas_ouvert']) 
               ->setCellValue('T'.($key+2), $this->boleanToString(!$value['pas_client'],$value['id']))
               ->setCellValue('U'.($key+2), $value['raison_pas_client'])
               ->setCellValue('V'.($key+2), $value['commentaire'])   ;
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
            'dernieres visites '.$region.' du '.$startDate->format('d M Y').' au '.$endDate->format('d M Y').'.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;        
    }         
}
