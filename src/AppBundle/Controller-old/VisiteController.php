<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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
    public function indexAction()
    {
        $session = $this->getRequest()->getSession();

        $em = $this->getDoctrine()->getManager();
         $session = $this->getRequest()->getSession();
            $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31')
;
        $visitesParPDV = $em->getRepository('AppBundle:PointVente')->visitesParPDV($region,$startDate, $endDate);
        $nombreVisite = $em->getRepository('AppBundle:Visite')->nombreVisite($region,$startDate, $endDate);
        
       
        return $this->render('visite/index.html.twig', array(
            'visitesParPDV' => $visitesParPDV,'nombreVisite'=> $nombreVisite
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
}
