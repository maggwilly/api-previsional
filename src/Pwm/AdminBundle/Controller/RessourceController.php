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
use Pwm\MessagerBundle\Entity\Notification;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Event\NotificationEvent;
/**
 * Ressource controller.
 *
 */
class RessourceController extends Controller
{
  /**
   * @Security("is_granted('ROLE_SUPERVISEUR')")ROLE_SUPERVISEUR
  */
    public function indexAction(Session $session=null)
    {   $ressources=array();
        $em = $this->getDoctrine()->getManager();
        if(is_null($session))
           $ressources = $em->getRepository('AdminBundle:Ressource')->findAll();
       else
            $ressources=$session->getRessources();
        return $this->render('ressource/index.html.twig', array(
            'ressources' => $ressources, 'session' => $session,
        ));
    }

  /**
   * @Security("is_granted('ROLE_SUPERVISEUR')")
  */
    public function newAction(Request $request,Session $session=null)
    {
        $ressource = new Ressource($session);
        $form = $this->createForm('Pwm\AdminBundle\Form\RessourceType', $ressource);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ressource->setIsPublic(is_null($session));
            $em->persist($ressource);
            $em->flush();
             $notification = new Notification('public',false,true);
             $notification
             ->setTitre($ressource->getIsPublic()?'Nouveau document':'Nouveau document ~'.$ressource->getSession()->getNomConcours())
             ->setSousTitre($ressource->getNom().' '.$ressource->getDescription())
             ->setText($ressource->getNom().' '.$ressource->getDescription());
             $notification->setUser($this->getUser());
             $registrations=array();
             $data=array(
                        'page'=>'document',
                         'id'=>$ressource->getId()
                      );
             if($ressource->getIsPublic())
                  $registrations = $em->getRepository('MessagerBundle:Registration')->findAll();
             elseif(!is_null($ressource->getSession())){
                  $destinations=$ressource->getSession()->getInfos();
                  $registrations=$this->findRegistrations($destinations); 
             }
            $event=new NotificationEvent($registrations,$notification, $data);
            $this->get('event_dispatcher')->dispatch('notification.shedule.to.send', $event);
             /* $this->pushInGroup($ressource);
              $this->addFlash('success', 'Enrégistrement effectué. une notification envoyée aux utilisateurs');*/
             // return $this->redirectToRoute('ressource_show', array('id' =>  $ressource->getId()));
           // return $this->redirectToRoute('ressource_show', array('id' => $ressource->getId()));
             return $this->redirectToRoute('push_ressource', array('id' => $ressource->getId()));
        }elseif($form->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');
        return $this->render('ressource/new.html.twig', array(
            'ressource' => $ressource,'session' => $session,
            'form' => $form->createView(),
        ));
    }
  /**
   * @Security("is_granted('ROLE_SUPERVISEUR')")
  */
    public function pushInGroupAction(Ressource $ressource)
    {
          $this->pushInGroup($ressource);
          $this->addFlash('success', 'Envoyé dans le groupe. ');
       return $this->redirectToRoute('ressource_show', array('id' => $ressource->getId()));
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

    public function pushInGroup(Ressource $ressource)
    {   
       // ,'url'=> $ressource->getUrl()
              if(!is_null($ressource->getSession())){
                 $date = new \DateTime();
            $msg=array(
                'message' =>array(
                     'ressource'=>array(
                          'id'=> $ressource->getId(),
                          'price'=> $ressource->getPrice(),
                          'nom'=> $ressource->getNom(),
                          'description'=> $ressource->getDescription(),
                          'size'=> $ressource->getSize(),
                          'style'=> $ressource->getStyle()
                        
                    ),
                    'type'=>'ressource',
                    'fromAdmin'=>true
                ) , 
                'uiniqid'=>uniqid(),
                'displayName'=>'Centor .inc',
                'timestamp'=>time(),
                'sentby'=>'uid',
                'photoURL'=>'https://firebasestorage.googleapis.com/v0/b/trainings-fa73e.appspot.com/o/ressources%2Ficon-blue.png?alt=media&token=b146afb4-66db-49e0-9261-0216721daa8c',
                'sentTo'=>''
            );
            $url="https://trainings-fa73e.firebaseio.com/session/".$ressource->getSession()->getId()."/documents.json";
            $this->get('fmc_manager')->sendOrGetData($url, $msg,'POST',false);
              }
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
          $paymentUrl=$request->query->get('paymentUrl');
          $em = $this->getDoctrine()->getManager();
          $info = $em->getRepository('AdminBundle:Info')->findOneByUid($uid);
          $commande=$em->getRepository('AdminBundle:Commande')->findOneByUserRessource($info,$ressource);
            if((($commande!=null)&&$commande->getStatus()==='SUCCESS')||($ressource->getPrice()==null||$ressource->getPrice()==0))
                 return $ressource;
          if(is_null($commande)||!is_null($commande->getStatus())){
              $commande= new Commande($info, null, null, $ressource->getPrice(),$ressource);
                $em->persist( $commande);
                $em->flush();
            }else{
             $commande->setDate(new \DateTime())->setAmount($ressource->getPrice());
             $em->flush();   
            }
            if($paymentUrl)
                return $ressource->setPaymentUrl($paymentUrl);
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
   * @Security("is_granted('ROLE_SUPERVISEUR')")
  */
    public function editAction(Request $request, Ressource $ressource)
    {
        $deleteForm = $this->createDeleteForm($ressource);
        $editForm = $this->createForm('Pwm\AdminBundle\Form\RessourceType', $ressource);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
             $this->addFlash('success', 'Modifications  enrégistrées avec succès.');
            return $this->redirectToRoute('ressource_edit', array('id' => $ressource->getId()));
        }elseif($editForm->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('ressource/edit.html.twig', array(
            'ressource' => $ressource,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

  /**
   * @Security("is_granted('ROLE_SUPERVISEUR')")
  */
    public function deleteAction(Request $request, Ressource $ressource)
    {
        $form = $this->createDeleteForm($ressource);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ressource);
            $em->flush();
            $this->addFlash('success', 'Supprimé.');
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
