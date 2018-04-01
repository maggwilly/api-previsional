<?php

namespace Pwm\MessagerBundle\Controller;
use Pwm\MessagerBundle\Entity\Sending;
use Pwm\MessagerBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Event\ResultEvent;
use Pwm\AdminBundle\Entity\Groupe;
use Pwm\AdminBundle\Entity\Info;
use AppBundle\Event\NotificationEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Notification controller.
 *
 */
class NotificationController extends Controller
{
    /**
     * Lists all notification entities.
     *
     */
    private $registrationIds=array();
    const HEADERS=array(
    "Authorization: key=AAAAJiQu4xo:APA91bH63R7-CeJ7jEgGtb2TNVkCx0TDWAYbu32mO1_4baLtrrFidNrbNy98Qngb6G67efbuJ8BpInpJiCeoTp-p5mt2706P2hXbXqrTXOWlaJFTDHza2QVWSlwsbF27eBhD2PZVJKuu",
    "content-type: application/json"
  );
  const FCM_URL = "https://fcm.googleapis.com/fcm/send";
 
  /**
   * @Security("is_granted('ROLE_MESSAGER')")
  */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('MessagerBundle:Notification')->findList();
        return $this->render('MessagerBundle:notification:index.html.twig', array(
            'notifications' => $notifications,
        ));
    }


    public function renderTemplate(\Pwm\AdminBundle\Entity\Commande $commande=null)
    {
        return $this->renderView(
            'MessagerBundle:notification:confirmation.html.twig',
            array(
                'commande' => $commande
            )
        );
    }
    /**
     * Creates a new notification entity.
     *
     */
    public function newAction(Request $request,Groupe $groupe=null)
    {
        $notification = new Notification();
       $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('Pwm\MessagerBundle\Form\NotificationType', $notification);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
           $notification->setUser($this->getUser());
            $em->persist($notification);
            $em->flush();
            if($notification->getSendNow())
                  return $this->send($notification);
            return $this->redirectToRoute('notification_show', array('id' => $notification->getId()));
        }

        return $this->render('MessagerBundle:notification:new.html.twig', array(
            'notification' => $notification,
            'form' => $form->createView(),
        ));
    }
    /**
     * Finds and displays a article entity.
     *
     */
    public function getRateAction(Notification $notification)
    {
         $url= "https://us-central1-trainings-fa73e.cloudfunctions.net/getRate?article=".$notification->getId();
         $renderTemplate = $this->get('fmc_manager')->sendOrGetData($url,null,'GET'); 

        return  new Response($renderTemplate);
    }

    /**
     * Finds and displays a article entity.
     *
     */
    public function getReadingAction(Notification $notification)
    {
         $em = $this->getDoctrine()->getManager();
         $readed= $em->getRepository('MessagerBundle:Sending')->findReading($notification);
         $envois=$notification->getSendings();
         $reading=count($envois)>0?$readed*100/count($envois):'--';
        return  new Response("".$reading);
    }

    public function getDestNumberAction(Notification $notification)
    {
         $em = $this->getDoctrine()->getManager();
         $nuberDesc=count($em->getRepository('MessagerBundle:Registration')->findAll()) ;
          $groupe= $notification->getGroupe();
         if(!is_null($groupe)){
             $numberDestTmp=0;
             foreach ($groupe->getSession()->getInfos() as $info) {
               foreach ($info->getRegistrations() as $registration) {
                 if (!$registration->getIsFake()) {
                     $numberDestTmp++;
                    } 
                 }
             }
            $nuberDesc=$numberDestTmp;
            }
        return  new Response("".$nuberDesc);
    }
    /**
     * Finds and displays a notification entity.
     *
     */
    public function showAction(Request $request,Notification $notification)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($notification);
        $sendForm = $this->createForm('Pwm\MessagerBundle\Form\NotificationSendType', $notification);
        $sendForm->handleRequest($request);
        if ($sendForm->isSubmitted() && $sendForm->isValid()) {
           return $this->send($notification);
        }
        return $this->render('MessagerBundle:notification:show.html.twig', array(
            'notification' => $notification,
            'send_form' => $sendForm->createView(),
            'delete_form' => $deleteForm->createView()
        ));
    }

  /**
   * @Security("is_granted('ROLE_MESSAGER')")
  */
    public function resentAction()
    {
        $em = $this->getDoctrine()->getManager();
        $sendings=$em->getRepository('MessagerBundle:Sending')->findNotRead();
        $registrationIds=array_column($sendings, 'registrationId');
        $registrationIds=array_unique($registrationIds);
         $notification = new Notification();
         $notification
         ->setTitre('Des messages et annonces non lus')
         ->setSousTitre(
            `Vous avez de nombreuses annonces non consultées.
              Prennez quelaues minutes pour consulter vos messages pour ne rater aucune opportunités.`);
         $this->firebaseSend($registrationIds,  $notification );
       return  $this->redirectToRoute('notification_index');
    }


public function firebaseSend($registrationIds, Notification $notification ){
$data=array('registration_ids' => array_values($registrationIds),
                      'notification'=>array('title' => $notification->getTitre(),
                       'body' => $notification->getSousTitre(),
                       'badge' => 1,
                       'sound'=> "default",
                       'tag' => 'message')
    );
  return $this->get('fmc_manager')->sendMessage($data);
}

    /**
     * Displays a form to edit an existing notification entity.
     *
     */
    public function send(Notification $notification)
    {
           $em = $this->getDoctrine()->getManager();
             $registrations=array();
             $groupe= $notification->getGroupe();
            if($groupe!=null){
               switch ($groupe->getTag()) {
                   case 'is.registred.not.singup':
                     $registrations = $em->getRepository('MessagerBundle:Registration')->findNotsingup();
                       
                    break;
                   case 'loaded.too.long.time':
                     $registrations = $em->getRepository('MessagerBundle:Registration')->findTooLongTimeLogin();
                    break;                     
                   case 'singup.subscribed.starter':
                        $destinations=$em->getRepository('AdminBundle:Info')->findSubscribersByBundle('starter');
                        $registrations=$this->findRegistrations($destinations);
                    break; 
                   case 'singup.subscribed.standard':
                        $destinations=$em->getRepository('AdminBundle:Info')->findSubscribersByBundle('standard');
                       $registrations=$this->findRegistrations($destinations);
                    break;                    
                   case 'singup.subscribed.expired':
                        $destinations=$em->getRepository('AdminBundle:Info')->findSubscribersExpired();
                        $registrations=$this->findRegistrations($destinations);
                    break;
                                                             
                   case 'singup.not.profil.filled':
                       $destinations=$em->getRepository('AdminBundle:Info')->findNotProfilFilled();
                       $registrations=$this->findRegistrations($destinations);
                       
                    break;                                      
                   default:
                       if ($groupe->getSession()!=null) {
                     $destinations=$groupe->getSession()->getInfos();
                      $registrations=$this->findRegistrations($destinations);
                       }
                       break;
               }

              }else
                 $registrations = $em->getRepository('MessagerBundle:Registration')->findAll();
               
                $event=new NotificationEvent($registrations,$notification);
                 $this->get('event_dispatcher')->dispatch('notification.shedule.to.send', $event);

            return $this->redirectToRoute('notification_show', array('id' => $notification->getId()));
    }

    public function findRegistrations($destinations)
    {
        $registrations= array();
      foreach ($destinations as $info) {
         foreach ($info->getRegistrations() as  $registration) {
             if (is_null($registration->getIsFake())) 
                    $registrations[]=$registration;
             }
         }
      return  $registrations;
    
    }



    /**
     * Displays a form to edit an existing notification entity.
     *
     */
    public function editAction(Request $request, Notification $notification)
    {
        $deleteForm = $this->createDeleteForm($notification);
        $editForm = $this->createForm('Pwm\MessagerBundle\Form\NotificationType', $notification);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
             if($notification->getSendNow())
                  return $this->send($notification);
            return $this->redirectToRoute('notification_edit', array('id' => $notification->getId()));
        }
        return $this->render('MessagerBundle:notification:edit.html.twig', array(
            'notification' => $notification,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a notification entity.
     *
     */
    public function deleteAction(Request $request, Notification $notification)
    {
        $form = $this->createDeleteForm($notification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notification);
            $em->flush();
        }

        return $this->redirectToRoute('notification_index');
    }

    /**
     * Creates a form to delete a notification entity.
     *
     * @param Notification $notification The notification entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Notification $notification)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notification_delete', array('id' => $notification->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
