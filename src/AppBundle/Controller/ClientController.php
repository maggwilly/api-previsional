<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Client controller.
 *
 */
class ClientController extends Controller
{
    /**
     * Lists all client entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $clients = $em->getRepository('AppBundle:Client')->findAll();

        return $this->render('client/index.html.twig', array(
            'clients' => $clients,
        ));
    }

    /**
     * Finds and displays a client entity.
     *
     */
    public function showAction(Client $client)
    {

        return $this->render('client/show.html.twig', array(
            'client' => $client,
        ));
    }
}
