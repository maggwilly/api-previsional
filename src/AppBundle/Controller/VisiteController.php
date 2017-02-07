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

        $visitesParPDV = $em->getRepository('AppBundle:PointVente')->visitesParPDV($session->get('region'),$session->get('startDate'),$session->get('endDate'));
        $nombreVisite = $em->getRepository('AppBundle:Visite')->nombreVisite($session->get('region'),$session->get('startDate'),$session->get('endDate'));
        
       
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
