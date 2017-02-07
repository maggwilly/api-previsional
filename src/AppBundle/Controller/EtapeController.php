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
         $visitesParUser = $em->getRepository('AppBundle:Client')->visitesParUser($session->get('region'),$session->get('startDate'),$session->get('endDate'));
         $synchrosParUser = $em->getRepository('AppBundle:Client')->synchrosParUser($session->get('startDate'),$session->get('endDate'));
         $etapesParUser = $em->getRepository('AppBundle:Etape')->etapesParUser($session->get('startDate'),$session->get('endDate'));

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
