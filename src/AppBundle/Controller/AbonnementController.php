<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Abonnement controller.
 *
 */
class AbonnementController extends Controller
{

  
  /**
   * @Security("is_granted('ROLE_DELEGUE')")
  */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $abonnements = $em->getRepository('AdminBundle:Abonnement')->findList();
         $extrats = $em->getRepository('AdminBundle:Abonnement')->findSinceDate();
        $concours = $em->getRepository('AppBundle:Session')->findList();

        return $this->render('AdminBundle:abonnement:index.html.twig', array(
            'abonnements' => $abonnements, 'concours' => $concours,
        ));
    }


 
    
    /**
     * Lists all Produit entities.
     *@Rest\View()
     */
    public function tokenAction()
    {
    $res=$this->get('payment_service')->getToken();

  return  $res;
}


    /**
     * @Rest\View()
     * 
     */
    public function initAction(Request $request)
    {
             $user=$this->getMobileUser($request);
              $em = $this->getDoctrine()->getManager();
               $commande= new Commande($user);
              $form = $this->createForm('AppBundle\Form\CommandeType', $commande);
              $form->submit($request->request->all());              
                if ($form->isValid()) {
                   $em->persist($commande);
                   $em->flush(); 
                   $res=$this->get('payment_service')->getPaimentCredentials($commande);
                   $res['duree']=$commande->getDuree();
                 return $res; // $this->redirect($res['payment_url']);
              }
         return   array(
                'status' => 'error'); 
    }






    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"abonnement"})
     */
    public function confirmCommandeAction(Request $request,Commande $commande)
    {
         $form = $this->createForm('Pwm\AdminBundle\Form\CommandeType', $commande);
         $form->submit($request->request->all(),false);
        if ($form->isValid()&&$commande->getStatus()=='SUCCESS') {
            $em = $this->getDoctrine()->getManager();
            if (is_null($commande->getRessource())) {
           $abonnement=$em->getRepository('AdminBundle:Abonnement')
                          ->findMeOnThis($commande->getInfo(), $commande->getSession());
            if($abonnement==null){
                 $abonnement=new Abonnement($commande); 
                 if(!is_null($commande->getSession())){
                  $commande->getSession()->removeInfo($commande->getInfo()); 
                  $commande->getSession()->addInfo($commande->getInfo());
                  $commande->getSession()->setNombreInscrit($commande->getSession()->getNombreInscrit()+1) ;
                  }              
                 $em->persist($abonnement);
                }
              $abonnement->setPlan($commande->getPackage());
              $abonnement->setPrice($commande->getAmount());
              $commande->setAbonnement($abonnement); 
              }
              $em->flush();
              $event= new CommandeEvent($commande);
               $this->get('event_dispatcher')->dispatch('commande.confirmed', $event);
            return $commande;
        }
        return $form;
    }


    /**
     * Lists all Produit entities.
     *@Rest\View()
     */
    public function cancelCommandeAction(Request $request,Commande $commande)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush($commande);
        return  array('success'=>true);
    }



        /**
     * Displays a form to edit an existing analyse entity.
     *
     */
    public function editAction(Request $request, Abonnement $abonnement)
    {
        $form = $this->createForm('Pwm\AdminBundle\Form\AbonnementType', $abonnement);
         $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $abonnement;
        }
        return $form;
    }



    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"abonnement"})
     */
    public function showJsonAction(Info $info, Session $session=null){
        $em = $this->getDoctrine()->getManager();
         $abonnement = $em->getRepository('AdminBundle:Abonnement')->findMeOnThis($info, $session);
          if ( $abonnement!=null&&$session!=null) {
          $info= $abonnement->getInfo();
          $url="https://trainings-fa73e.firebaseio.com/session/".$session->getId()."/members/.json";
          $data = array($info->getUid() => array('uid' => $info->getUid(),'displayName' => $info->getDisplayName(),'photoURL' => $info->getPhotoURL()));
           $this->get('fmc_manager')->sendOrGetData($url,$data,'PATCH');
        }
        return $abonnement;
    }

        /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"abonnement"})
     */
    public function showOneJsonAction(Abonnement $abonnement){
          if ( $abonnement!=nulll&&$abonnement-> getSession()!=null) {
          $info= $abonnement->getInfo();
          $url="https://trainings-fa73e.firebaseio.com/session/".$abonnement-> getSession()->getId()."/members/.json";
          $data = array($info->getUid() => array('uid' => $info->getUid(),'displayName' => $info->getDisplayName(),'photoURL' => $info->getPhotoURL()));
           $this->get('fmc_manager')->sendOrGetData($url,$data,'PATCH');
        }
        return $abonnement;
    }


  /**
   * @Security("is_granted('ROLE_DELEGUE')")
  */
    public function showAction(Abonnement $abonnement)
    {

        if ( $abonnement!=null) {
          $info= $abonnement->getInfo();
          $url="https://trainings-fa73e.firebaseio.com/session/".$abonnement-> getSession()->getId()."/members/.json";
          $data = array($info->getUid() => array('uid' => $info->getUid(),'displayName' => $info->getDisplayName(),'photoURL' => $info->getPhotoURL()));
           $this->get('fmc_manager')->sendOrGetData($url,$data,'PATCH');
        } 
        $deleteForm = $this->createDeleteForm($abonnement);
        return $this->render('AdminBundle:abonnement:show.html.twig', array(
            'abonnement' => $abonnement,
            'delete_form' => $deleteForm->createView(),
        ));
    }



  /**
   * @Security("is_granted('ROLE_DELEGUE')")
  */
    public function deleteAction(Request $request, Abonnement $abonnement)
    {
        $form = $this->createDeleteForm($abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($abonnement);
            $em->flush($abonnement);
        }

        return $this->redirectToRoute('abonnement_index');
    }

    /**
     * Creates a form to delete a abonnement entity.
     *
     * @param Abonnement $abonnement The abonnement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Abonnement $abonnement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('abonnement_delete', array('id' => $abonnement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

public function getMobileUser(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
          $user = $em->getRepository('AppBundle:User')->findOneById($request->headers->get('X-User-Id'));
        return $user;
    } 
   
}
