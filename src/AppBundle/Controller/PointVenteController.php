<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PointVente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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
        $visites  = $em->getRepository('AppBundle:Visite')->visites($startDate, $endDate,$pointVente);
          $colors=array("#FF6384","#36A2EB","#FFCE56","#F7464A","#FF5A5E","#46BFBD", "#5AD3D1","#FDB45C","#FFC870");
        return $this->render('pointvente/show.html.twig', array(
            'pointVente' => $pointVente,
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
      $eligibles = $em->getRepository('AppBundle:PointVente')->eligibles($note,$region,$startDate, $endDate);
       $nombrePointVenteVisite = $em->getRepository('AppBundle:PointVente')->nombrePointVenteVisite($region,$startDate, $endDate);
        return $this->render('pointvente/eligibles.html.twig', array(
            'eligibles' => $eligibles,  'nombrePointVenteVisite' => $nombrePointVenteVisite,
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
}
