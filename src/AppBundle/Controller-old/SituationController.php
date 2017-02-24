<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Situation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Situation controller.
 *
 */
class SituationController extends Controller
{
    /**
     * Lists all situation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $situations = $em->getRepository('AppBundle:Situation')->findAll();

        return $this->render('situation/index.html.twig', array(
            'situations' => $situations,
        ));
    }

    /**
     * Finds and displays a situation entity.
     *
     */
    public function showAction(Situation $situation)
    {

        return $this->render('situation/show.html.twig', array(
            'situation' => $situation,
        ));
    }
}
