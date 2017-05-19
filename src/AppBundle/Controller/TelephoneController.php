<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Telephone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Telephone controller.
 *
 */
class TelephoneController extends Controller
{
    /**
     * Lists all telephone entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $telephones = $em->getRepository('AppBundle:Telephone')->findAll();

        return $this->render('telephone/index.html.twig', array(
            'telephones' => $telephones,
        ));
    }

    /**
     * Finds and displays a telephone entity.
     *
     */
    public function showAction(Telephone $telephone)
    {

        return $this->render('telephone/show.html.twig', array(
            'telephone' => $telephone,
        ));
    }
}
