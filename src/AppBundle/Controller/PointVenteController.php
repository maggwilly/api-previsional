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

        return $this->render('pointvente/show.html.twig', array(
            'pointVente' => $pointVente,
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
      $pointVentes = $em->getRepository('AppBundle:PointVente')->pointVentes($session->get('region'),$session->get('startDate'),$session->get('endDate'));
     $nombrePointVente = $em->getRepository('AppBundle:PointVente')->nombrePointVente($session->get('region'),$session->get('startDate'),$session->get('endDate'));
        return $this->render('pointvente/map.html.twig', array(
            'pointVentes' => $pointVentes,  'nombrePointVente' => $nombrePointVente,
        ));
    }  
}
