<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Etape;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Etape controller.
 *
 */
class EtapeController extends Controller
{
    /**
     * Lists all etape entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
         $session = $this->getRequest()->getSession();

            $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31');
         $visitesParUser = $em->getRepository('AppBundle:Client')->visitesParUser($region,$startDate, $endDate);
         $synchrosParUser = $em->getRepository('AppBundle:Client')->synchrosParUser($startDate, $endDate);
         $etapesParUser = $em->getRepository('AppBundle:Etape')->etapesParUser($startDate, $endDate);

        return $this->render('etape/index.html.twig', array(
            'visitesParUser' => $visitesParUser,
            'synchrosParUser' => $synchrosParUser,
            'etapesParUser' => $etapesParUser,
        ));
    }

    /**
     * Finds and displays a etape entity.
     *
     */
    public function showAction(Etape $etape)
    {

        return $this->render('etape/show.html.twig', array(
            'etape' => $etape,
        ));
    }
}
