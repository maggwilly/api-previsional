<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Form\CredentialsType;
use AppBundle\Entity\AuthToken;
use AppBundle\Entity\Credentials;

use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
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
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31');

        
        return $this->render('AppBundle::index.html.twig',   array());
    }



    public function setPeriodeAction(Request $request)
    {
  
        $region=$request->request->get('region');
        $periode= $request->request->get('periode');
        $dates = explode(" - ", $periode);
        $startDate=$dates[0];
        $endDate=$dates[1];
        $format = 'd/m/Y';
        $startDate= \DateTime::createFromFormat($format, $dates[0]);
        $endDate= \DateTime::createFromFormat($format, $dates[1]);
        $session = $this->getRequest()->getSession();
        $session->set('region',$region);
        $session->set('startDate',$startDate->format('Y-m-d'));
        $session->set('endDate',$endDate->format('Y-m-d'));
        $session->set('periode',$periode);
        $session->set('end_date_formated',$endDate->format('d/m/Y'));
        $session->set('start_date_formated',$startDate->format('d/m/Y'));
       $referer = $this->getRequest()->headers->get('referer');   
         return new RedirectResponse($referer);
    }



private function getConnectedUser(){
    return $this->get('security.token_storage')->getToken()->getUser();
}
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"auth-token"})
     * 
     */
    public function postAuthTokensAction(Request $request)
    {
        $credentials = new Credentials();
        $form = $this->createForm( CredentialsType::class, $credentials);
        $form->submit($request->request->all());
        if (!$form->isValid()) {
            return $form;
        }
         $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:Client')->findOneByUsername($credentials->getLogin());

        if (!$user) { // L'utilisateur n'existe pas
            return $this->invalidCredentials();
        }
       /** $encoder = $this->get('security.password_encoder');
        $isPasswordValid = $encoder->isPasswordValid($user, $credentials->getPassword());

        if (!$isPasswordValid) { // Le mot de passe n'est pas correct
            return $this->invalidCredentials();
        }*/
        $authToken=AuthToken::create($user);
        $em->persist($authToken);
        $em->flush();
        return $authToken;
    }

   /*   public function indexAction()
    {   
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $region=$session->get('region');
        $startDate=$session->get('startDate',date('Y').'-01-01');
        $endDate=$session->get('endDate', date('Y').'-12-31');

        $nombreCout = $em->getRepository('AppBundle:Souscripteur')->nombreCout($region,$startDate,$endDate);
        $performences = $em->getRepository('AppBundle:Souscripteur')->performances($region,$startDate,$endDate);

        $repartition = $em->getRepository('AppBundle:Souscripteur')->repartition($region,$startDate,$endDate);
        $evolutionByWeek = $em->getRepository('AppBundle:Souscripteur')->evolutionByWeek($region,$startDate,$endDate);
        $evolutionByMonth = $em->getRepository('AppBundle:Souscripteur')->evolutionByMonth($region,$startDate,$endDate);

        $especesByMonth = $em->getRepository('AppBundle:Souscripteur')->especesByMonth($region,$startDate,$endDate);
        $majoritaireCSP = $em->getRepository('AppBundle:Souscripteur')->majoritaireCSP($region,$startDate,$endDate);
        $majoritaireAge = $em->getRepository('AppBundle:Souscripteur')->majoritaireAge($region,$startDate,$endDate);

        return $this->render('AppBundle::index.html.twig', 
            array(
                'performences'=> $performences,
                'repartitions'=> $repartition,
                'evolutionByWeek'=> $evolutionByWeek,
                'evolutionByMonth'=> $evolutionByMonth,
                'especesByMonth'=> $especesByMonth,
                'majoritaireCSP'=> empty($majoritaireCSP)?'--':$majoritaireCSP[0]['csp'],
                'majoritaireAge'=> empty($majoritaireAge)?'--':$majoritaireAge[0]['age'],
                'nombre'=> $nombreCout[0]['nombre'],
                'cout'=> $nombreCout[0]['cout']
        ));
    }  */
}