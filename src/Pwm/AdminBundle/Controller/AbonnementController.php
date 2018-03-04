<?php

namespace Pwm\AdminBundle\Controller;

use Pwm\AdminBundle\Entity\Abonnement;
use Pwm\MessagerBundle\Entity\Notification;
use Pwm\AdminBundle\Entity\Info;
use Pwm\AdminBundle\Entity\Commande;
use Pwm\MessagerBundle\Controller\NotificationController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
use AppBundle\Entity\Session;
use AppBundle\Event\CommandeEvent;
/**
 * Abonnement controller.
 *
 */
class AbonnementController extends Controller
{

    private   $authorization='Bearer 9xBFBcOar5G5ACWWL0gmLFR0dtXt';
    private  $merchant_key='027d30fb';
    private  $currency='XAF';
    private  $id_prefix='CMD.CM.';
    private  $return_url='http://help.centor.org/return.html';
    private  $cancel_url='http://help.centor.org/cancel.html';
    private  $base_url='https://concours.centor.org/v1/formated/commende/';
    /**
     * Lists all abonnement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $abonnements = $em->getRepository('AdminBundle:Abonnement')->findAll();
        $concours = $em->getRepository('AppBundle:Session')->findAll();
        return $this->render('AdminBundle:abonnement:index.html.twig', array(
            'abonnements' => $abonnements, 'concours' => $concours,
        ));
    }


    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"abonnement"})
     */
    public function indexJsonAction(Info $info)
    {
        $em = $this->getDoctrine()->getManager();
        $abonnements = $em->getRepository('AdminBundle:Abonnement')->findForMe($info);
        return  $abonnements;
    }

    public function tokenAction()
    {
 
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.orange.com/oauth/v2/token",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 120,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "grant_type=client_credentials",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic R3ltM0ZBMkdQSkhrTVRYTE1ySFFNd3Yxd0E5RWdHQnc6VklwRWhKU1lmeUFRY3NDcw=="
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
  return new Response( $err);
} else {
   return new Response( $response);
        
}
  return '';
}


    /**
     * Lists all Produit entities.
     *@Rest\View()
     */
    public function startCommandeAction(Request $request,Info $info, Session $session,$package)
    {
          $em = $this->getDoctrine()->getManager();
          $amount=0;
      switch ($package) {
          case 'starter':
            $amount=  $session->getPrice()->getStarter();
             $commande= new Commande($info, $session, $package, $amount);
            $em->persist( $commande);
            $em->flush();
               return array('success'=>true,'id'=>$commande->getId());
          case 'standard':
              $amount=$session->getPrice()->getStandard();
              break;          
           default:
               $amount=$session->getPrice()-> getPremium();
              break;
      }    
            $session->removeInfo($info);
            $session->addInfo($info);
           $commande= new Commande($info, $session, $package, $amount);
           $em->persist( $commande);
           $em->flush();
        return $this->getPayementUrl($commande);
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
           $abonnement=$em->getRepository('AdminBundle:Abonnement')->findMeOnThis($commande->getInfo(), $commande->getSession());
            if($abonnement==null){
                 $abonnement=new Abonnement($commande);  
                 $em->persist($abonnement);
                }

             $abonnement->setPlan($commande->getPackage());
             $abonnement->setPrice($commande->getAmount());
             $commande->getSession()->removeInfo($commande->getInfo());
             $commande->getSession()->addInfo($commande->getInfo());
             $commande->getSession()->setNombreInscrit($commande->getSession()->getNombreInscrit()+1) ;
             $commande->setAbonnement($abonnement);
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


public function getPayementUrl(Commande $commande)
  {
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.orange.com/orange-money-webpay/cm/v1/webpayment",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 120,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\"merchant_key\":\"".$this->merchant_key."\", \"currency\":\"".$this->currency."\",\"order_id\": \"".$this->id_prefix.$commande->getId()."\",\"amount\": \"".$commande->getAmount()."\", \"return_url\": \"".$this->return_url."\",\"cancel_url\": \"".$this->cancel_url."\",\"notif_url\": \"".$this->base_url.$commande->getId()."/confirm/json\",\"lang\": \"fr\",\"reference\": \"CENTOR .inc\"
     }",
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "authorization: Bearer 9xBFBcOar5G5ACWWL0gmLFR0dtXt",
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
  return new Response( $err);
} else {
   return new Response("{\"data\":". $response.", \"id\":\"".$commande->getId()."\"}");
        
}
  return '';
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
    public function showJsonAction(Info $info,Session $session){
        $em = $this->getDoctrine()->getManager();
         $abonnement = $em->getRepository('AdminBundle:Abonnement')->findMeOnThis($info, $session);
          if ( $abonnement!=null) {
          $info= $abonnement->getInfo();
          $url="https://trainings-fa73e.firebaseio.com/session/".$abonnement-> getSession()->getId()."/members/.json";
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
        return $abonnement;
    }

    /**
     * Creates a new abonnement entity.
     *
     */
    public function newAction(Request $request)
    {
        $abonnement = new Abonnement();
        $form = $this->createForm('Pwm\AdminBundle\Form\AbonnementType', $abonnement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($abonnement);
            $em->flush($abonnement);
            return $this->redirectToRoute('abonnement_show', array('id' => $abonnement->getId()));
        }

        return $this->render('AdminBundle:abonnement:new.html.twig', array(
            'abonnement' => $abonnement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a abonnement entity.
     *
     */
    public function showAction(Abonnement $abonnement)
    {
        $deleteForm = $this->createDeleteForm($abonnement);
        return $this->render('AdminBundle:abonnement:show.html.twig', array(
            'abonnement' => $abonnement,
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Deletes a abonnement entity.
     *
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
}
