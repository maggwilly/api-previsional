<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Form\CredentialsType;
use AppBundle\Entity\AuthToken;
use AppBundle\Entity\Credentials;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
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
       
       $user=$this->getUser();
       
        return $this->render('AppBundle::index.html.php',   array( 
            'user_token' =>$user->getApiKey(),
            'user_id' =>$user->getId(),
            'user' =>json_encode( array('id' => $user->getId(),'nom' => $user->getNom())),
            'autentificator' =>'form_authentificator'));
    }



    public function helpAction($page='index')
    {   
        return $this->render('AppBundle:help:'.$page.'.html.twig',   array());
    }


 

}