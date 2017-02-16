<?php

namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Synchro;
use AppBundle\Form\SynchroType;
use AppBundle\Form\EtapeType;
use AppBundle\Form\PointVenteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\CredentialsType;
use AppBundle\Entity\AuthToken;
use AppBundle\Entity\Credentials;
/**
 * CommandeClient controller.
 */
class MobileController extends Controller
{
//mobile
    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"produit"})
     */
    public function produitsAction(Request $request)
    {
          $em = $this->getDoctrine()->getManager();
       /**   $entity = $this->getConnectedUser();
       if (!$entity) {
           throw $this->createNotFoundException('Unable to find Organ entity.');
          }*/
        $produits= $em->getRepository('AppBundle:Produit')->findAll(); 
       return $produits;
    }
   
    /**
     * Lists all Produit entities.
     *@Rest\View()
     */
    public function pointVentesAction(Request $request)
    {
          $em = $this->getDoctrine()->getManager();
         /** $entity = $this->getConnectedUser();
       if (!$entity) {
           throw $this->createNotFoundException('Unable to find Organ entity.');
          }*/
        $pointVentes= $em->getRepository('AppBundle:PointVente')->pdvs(); 

       return $pointVentes;
    }

  /**
     * Lists all Produit entities.
     *@Rest\View()
     */
    public function createPointVentesAction(Request $request)
    {
        $entity= new Synchro(null,new \DateTime());
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $form->submit($request->request->all(),false); // Validation des d
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
         return ['success'=>true];
        }
        return  $form;
    }

     /** Creates a new Produit entity.
     *@Rest\View()
     */
    public function createVisitesAction(Request $request)
    {
   
        $form = $this->createCreateVisitesForm();
        $form->handleRequest($request);
        $form->submit($request->request->all(),false); // Validation des d
        if ($form->isValid()) {
            $data=$form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data['visites']);
            $em->flush();
         return ['success'=>true];
        }
        return  $form;
    }

    /** Creates a new Produit entity.
     *@Rest\View()
     */
    public function createEtapesAction(Request $request)
    {
   
        $form = $this->createCreateEtapesForm();
        $form->handleRequest($request);
        $form->submit($request->request->all(),false); // Validation des d
        if ($form->isValid()) {
            $data=$form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($data['etapes']);
            $em->flush();
         return ['success'=>true];
        }
        return  $form;
    } 
  
    /**
     * Creates a form to create a Produit entity.
     * @param Produit $entity The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Synchro $entity)
    {
        $form = $this->createForm(SynchroType::class, $entity);
        return $form;
    }

private function getConnectedUser(){
    return $this->get('security.token_storage')->getToken()->getUser();
}

        /**
     * @Rest\View(statusCode=Response::HTTP_CREATED, serializerGroups={"full"})
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
}
