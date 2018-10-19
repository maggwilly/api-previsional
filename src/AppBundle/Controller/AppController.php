<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Etape controller.
 *
 */
class AppController extends Controller
{
    /**
     * Lists all etape entities.
     *
     */
    public function indexAction()
    {   
        //require __DIR__ . '/../../../vendor/google/apiclient/src/Google/Client.php'; /
        //$client = new Google_Client();
        $em = $this->getDoctrine()->getManager();
        $campagnes = $em->getRepository('AppBundle:Campagne')->findAll();
        return $this->render('layout.html.twig', array(
            'campagnes' => $campagnes,
        ));
    }


}