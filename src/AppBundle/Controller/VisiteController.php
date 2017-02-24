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
    public function visitesParPDVAction()
    {
        $session = $this->getRequest()->getSession();

        $em = $this->getDoctrine()->getManager();
         $session = $this->getRequest()->getSession();
        $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31')
         ;
        $visitesParPDV = $em->getRepository('AppBundle:Visite')->visitesParPDV($region,$startDate, $endDate);

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
}
