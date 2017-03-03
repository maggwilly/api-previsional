<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Secteur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Secteur controller.
 *
 */
class SecteurController extends Controller
{
    /**
     * Lists all secteur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $secteurs = $em->getRepository('AppBundle:Secteur')->findAll();

        return $this->render('secteur/index.html.twig', array(
            'secteurs' => $secteurs,
        ));
    }

    /**
     * Finds and displays a secteur entity.
     *
     */
    public function showAction(Secteur $secteur)
    {

        return $this->render('secteur/show.html.twig', array(
            'secteur' => $secteur,
        ));
    }
}
