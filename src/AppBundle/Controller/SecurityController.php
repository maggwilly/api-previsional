<?php

// src/OC/UserBundle/Controller/SecurityController.php;


namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\JsonResponse;

class SecurityController extends Controller

{

  public function loginAction(Request $request)

  {

    // Si le visiteur est déjà identifié, on le redirige vers l'accueil

    if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
      //return $this->redirectToRoute('homepage');
    }
 
    $authenticationUtils = $this->get('security.authentication_utils');

   return $this->render('AppBundle::login.html.twig', array(
      'last_username' => $authenticationUtils->getLastUsername(),
      'error'         => $authenticationUtils->getLastAuthenticationError(),
    ));
    // return new JsonResponse(array('action' => 'goToLoginPage',
      //                           'last_status' => array('last_username' => $authenticationUtils->getLastUsername(),
       //                               'error' =>$authenticationUtils->getLastAuthenticationError())));

  }

}