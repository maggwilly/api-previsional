<?php

namespace Pwm\AdminBundle\Controller;

use Pwm\AdminBundle\Entity\Ressource;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
use AppBundle\Entity\Session;
use Pwm\AdminBundle\Entity\Commande;
use AppBundle\Event\ResultEvent;
/**
 * Ressource controller.
 *
 */
class RessourceController extends Controller
{
    /**
     * Lists all ressource entities.
     *
     */
    public function indexAction(Session $session)
    {
        $em = $this->getDoctrine()->getManager();
        $ressources = $em->getRepository('AdminBundle:Ressource')->findAll();
        return $this->render('ressource/index.html.twig', array(
            'ressources' => $ressources, 'session' => $session,
        ));
    }

    /**
     * Creates a new ressource entity.
     *
     */
    public function newAction(Request $request,Session $session)
    {
        $ressource = new Ressource($session);
        $form = $this->createForm('Pwm\AdminBundle\Form\RessourceType', $ressource);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ressource);
            $em->flush();
            $registrationIds=array();
            if($ressource->getIsPublic()){
           $registrations = $em->getRepository('MessagerBundle:Registration')->findAll(); 
            foreach ($registrations as $registration) {
                if (!$registration->getIsFake()) {
                $registrationIds[]=$registration->getRegistrationId();
                  }
                }
              }else{
                  $destinations=$session->getInfos();
                  foreach ($destinations as $info) {
                    foreach ($info->getRegistrations() as $registration) {
                        if (!$registration->getIsFake()) {
                            $registrationIds[]=$registration->getRegistrationId();
                          }
                    }
                           
                }
              }
            $result= $this->firebaseSend($registrationIds ,$ressource);
            $resultats= $result['results'];
            $success=$result['success'];
            $failure=$result['failure'];
            $event= new ResultEvent($registrationIds, $resultats);
            $this->get('event_dispatcher')->dispatch('fcm.result', $event);

            return $this->redirectToRoute('ressource_show', array('id' => $ressource->getId()));
        }
        return $this->render('ressource/new.html.twig', array(
            'ressource' => $ressource,'session' => $session,
            'form' => $form->createView(),
        ));
    }


public function firebaseSend($registrationIds,Ressource $ressource ){
$data=array(
        'registration_ids' => array_values($registrationIds),
        //'dry_run'=>true,
         'notification'=>array('title' => $ressource->getIsPublic()?'Ressource':'Ressource ~'.$ressource->getSession()->getNomConcours(),
                      ' body' => $ressource->getDescription(),
                       'badge' => 1,
                      // 'sound'=> "default",
                       'tag' => 'ressources')
    );
     $fmc_response= $this->get('fmc_manager')->sendMessage($data);
  return $fmc_response;
}
    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"ressource"})
     */
    public function indexJsonAction(Session $session)
    {     $em = $this->getDoctrine()->getManager();
          $sessions= $em->getRepository('AdminBundle:Ressource')->findRessources($session);
        return  $sessions;
    }

    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"full"})
     */
    public function showJsonAction(Request $request,Ressource $ressource)
    {    

          $uid=$request->query->get('uid');
          $em = $this->getDoctrine()->getManager();
          $info = $em->getRepository('AdminBundle:Info')->findOneByUid($uid);
          $commande=$em->getRepository('AdminBundle:Commande')->findOneByUserRessource($info,$ressource);
            if((!is_null($commande)&&$commande->getStatus()=='SUCCESS')||(is_null($ressource->getPrice())||$ressource->getPrice()==0))
                 return $ressource;
          if(is_null($commande)||!is_null($commande->getStatus())){
              $commande= new Commande($info, null, null, $ressource->getPrice(),$ressource);
                $em->persist( $commande);
                $em->flush();
            }else{
             $commande->setDate(new \DateTime());
             $em->flush();   
            }
             $response=$this->get('payment_service')->getPayementUrl($commande);
        return $ressource->setPaymentUrl($response['payment_url']);
    }

    /**
     * Finds and displays a ressource entity.
     *
     */
    public function showAction(Ressource $ressource)
    {
        $deleteForm = $this->createDeleteForm($ressource);
        return $this->render('ressource/show.html.twig', array(
            'ressource' => $ressource,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ressource entity.
     *
     */
    public function editAction(Request $request, Ressource $ressource)
    {
        $deleteForm = $this->createDeleteForm($ressource);
        $editForm = $this->createForm('Pwm\AdminBundle\Form\RessourceType', $ressource);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('ressource_edit', array('id' => $ressource->getId()));
        }
        return $this->render('ressource/edit.html.twig', array(
            'ressource' => $ressource,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ressource entity.
     *
     */
    public function deleteAction(Request $request, Ressource $ressource)
    {
        $form = $this->createDeleteForm($ressource);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ressource);
            $em->flush();
        }
        return $this->redirectToRoute('ressource_index');
    }

    /**
     * Creates a form to delete a ressource entity.
     * @param Ressource $ressource The ressource entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ressource $ressource)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ressource_delete', array('id' => $ressource->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
