<?php

namespace AppBundle\Controller;
use Pwm\AdminBundle\Entity\Info;
use Pwm\AdminBundle\Entity\Groupe;
use AppBundle\Entity\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Concours;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Pwm\MessagerBundle\Entity\Notification;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Event\NotificationEvent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SessionController extends Controller
{
/**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function indexAction(Concours $concours=null, $all=false)
    {
        $em = $this->getDoctrine()->getManager();
         $sessions=array();
     /*     if(!$all){
              $sessions= $em->getRepository('AppBundle:Session')->findListByUser($this->getUser());
              return $this->render('session/index.html.twig', array(
            'sessions' => $sessions,'concour' => $concours,
             ));
           }
          else*/
             $sessions = $em->getRepository('AppBundle:Session')->findAll($concours);
         /*foreach ($sessions as $key => $session) {
                 $url="https://trainings-fa73e.firebaseio.com/session/".$session->getId()."/.json";
                 $data = array(
                'info'=>array('groupName' => $session->getNomConcours()),
                'owner'=>$this->getUser()->getId()
              );
             $this->get('fmc_manager')->sendOrGetData($url,$data,'PATCH');
            
         } */
        return $this->render('session/index.html.twig', array(
            'sessions' => $sessions,'concour' => $concours,
        ));
    }

        /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"session"})
     */
     public function jsonIndexAction(Request $request)
     {
        $all=$request->query->get('all');
        $order=$request->query->get('order');
        $start=$request->query->get('start');
         $em = $this->getDoctrine()->getManager();
          $sessions =$em->getRepository('AppBundle:Session')->findList($start,$all,$order);
         return  $sessions;
     }

        /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"session"})
     */
     public function jsonRecentsAction(Request $request)
     {
         $em = $this->getDoctrine()->getManager();
          $sessions =$em->getRepository('AppBundle:Session')->findRecents();
         return  $sessions;
     }


    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"session"})
     */
     public function jsonEnVusAction(Request $request)
     {
         $em = $this->getDoctrine()->getManager();
          $sessions =$em->getRepository('AppBundle:Session')->findEnVus();
         return  $sessions;
     }

    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"session"})
     */
     public function jsonOwardsAction(Request $request)
     {
         $em = $this->getDoctrine()->getManager();
          $sessions =$em->getRepository('AppBundle:Session')->findOwards();
         return  $sessions;
     }     

    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"session"})
     */
     public function jsonForUserAction(Request $request,Info $info=null)
     {
         $em = $this->getDoctrine()->getManager();
          $sessions =is_null($info)?array():$em->getRepository('AppBundle:Session')->findForUser($info);
         return  $sessions;
     }

     /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"full"})
     */
    public function showJsonAction(Session $session){
        $em = $this->getDoctrine()->getManager();
         $ressources =$em->getRepository('AdminBundle:Ressource')->findNewRessources($session);
         $session->setNewressource(!empty( $ressources));
        return $session;
    }

/**
 * @Security("is_granted('ROLE_SUPERVISEUR') or has_role('ROLE_MESSAGER')")
*/
    public function decrireAction(Request $request,Session $session)
    {
         if(!is_null($session->getArticleDescriptif()))
         return $this->redirectToRoute('notification_show', array('id' => $session->getArticleDescriptif()->getId()));

        if(is_null($session->getConcours()->getArticleDescriptif()))
              $notification = $session->getConcours()->defaultDescription();
        else   
            $notification= clone $session->getConcours()->getArticleDescriptif();
          $notification->setSendNow(false);
           $formBuilder=$this->createFormBuilder($notification)
              ->add('titre','text' ,array('label'=>"Titre"))
             ->add('sousTitre', 'textarea' ,array('label'=>"Texte simple de moin de  132 caractères à afficher sur l'ecran veroullé"))
             ->add('text', 'textarea' ,array('label'=>'Corps du message en texte riche contenant imqges et média','attr'=>array('class'=>'ckeditor')));
             if($this->get('security.authorization_checker')->isGranted('ROLE_MESSAGER'))
                 $formBuilder->add('sendNow', 'checkbox' ,array('label'=>'Envoyer maintenant','required' => false));
                $form = $formBuilder ->setAction($this->generateUrl('session_decrire', array('id' => $session->getId())))->setMethod('POST')->getForm();   
                $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $notification->setUser($this->getUser());
            $session->setArticleDescriptif($notification);
             $em->flush();
            if($notification->getSendNow())
                return $this->redirectToRoute('notification_send', array('id' => $notification->getId()));
               $this->addFlash('success', "Enrégistrement effectué. Article non publié");
              return $this->redirectToRoute('notification_show', array('id' => $notification->getId()));
        }elseif($form->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('MessagerBundle:notification:new.html.twig', array(
            'notification' => $notification,
            'form' => $form->createView(),
        ));
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
 * @Security("is_granted('ROLE_CONTROLEUR')")
*/
    public function newAction(Concours $concour,Request $request)
    {
        $session = new Session($concour);
        $form = $this->createForm('AppBundle\Form\SessionType', $session);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
             $em->persist($session);
            if( $session->getShouldAlert()){
             $notification = new Notification('public',false,true);
             $notification
             ->setTitre($session->getNomConcours())
             ->setSousTitre('Concours disponible'.$session->getNomConcours())
             ->setText("Un Nouveau concours est disponible. Verifiez s'il correspond à votre profil".$session->getNomConcours())
             ->setUser($this->getUser());
              $em->persist($notification);
              $em->flush();
               return $this->redirectToRoute('notification_edit', array('id' =>  $notification->getId()));
            }
             $em->flush();
            $this->addFlash('success', 'Enrégistrement effectué');
            return $this->redirectToRoute('session_show', array('id' => $session->getId()));
        }elseif($form->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('session/new.html.twig', array(
            'session' => $session, 'concour' => $concour,
            'form' => $form->createView(),
        ));
    }




    /**
     * Finds and displays a question entity.
     *
     */
    public function showFromMobileAction(Session $session)
    {
        return $this->render('programme/showFromMobile.html.twig', array(
            'concours' => $session,
        ));
    }

/**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function showAction(Session $session)
    {
        $deleteForm = $this->createDeleteForm($session);  

            if (is_null($session->getGroupe())) {
                 $em=$this->getDoctrine()->getManager();
                 $session->setGroupe(new Groupe($this->nomConcours,$session));
                  $em->flush();
             }
         $this->get("session")->set('current_session_id', $session->getId());  
                 $url="https://trainings-fa73e.firebaseio.com/session/".$session->getId()."/.json";
                 $data = array(
                'info'=>array('groupName' => $session->getNomConcours()),
                'owner'=>$this->getUser()->getId()
              );
             $this->get('fmc_manager')->sendOrGetData($url,$data,'PATCH');           
        return $this->render('session/show.html.twig', array(
            'session' => $session,
            'delete_form' => $deleteForm->createView(),
        ));
    }

/**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function analyseAction(Session $session)
    {
    
        return $this->redirectToRoute('session_show', array('id' => $session->getId()));
    }

        /**
     * Lists all Produit entities.
     *@Rest\View()
     */
    public function followsAction(Request $request,Session $session, Info $info=null)
    {
         $status=$request->query->get('status');
          if ($session!=null && $info!=null) {
                switch ($status) {
                    case 'true':
                        $session->addInfo($info);
                         $this->getDoctrine()->getManager()->flush();
                         return  true;
                    case 'false':
                          $session->removeInfo($info);
                           $this->getDoctrine()->getManager()->flush();
                        return  false;                    
                    default:
                    return !empty($this->getDoctrine()->getManager()->getRepository('AppBundle:Session')->findByUser($session,$info));  
                }
          }
         return  false;
    }

/**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function editAction(Request $request, Session $session)
    {
        $deleteForm = $this->createDeleteForm($session);
        $editForm = $this->createForm('AppBundle\Form\SessionType', $session);
         $this->get("session")->set('current_session_id', $session->getId());
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em=$this->getDoctrine()->getManager();
            if( $session->getShouldAlert()){
             $notification = new Notification('public',false,true);
             $notification
             ->setTitre($session->getNomConcours())
             ->setSousTitre("Consultez les changements sur ..".$session->getNomConcours())
             ->setText("Consultez les changements sur ..".$session->getNomConcours())
             ->setGroupe($session->getGroupe());
             $notification->setUser($this->getUser());
              $em->persist($notification);
              $em->flush();
               $this->addFlash('success', 'Modifications  enrégistrées avec succès.');
               return $this->redirectToRoute('notification_edit', array('id' =>  $notification->getId()));
            }
              $em->flush();
               $url="https://trainings-fa73e.firebaseio.com/session/".$session->getId()."/.json";
                 $data = array(
                'info'=>array('groupName' => $session->getNomConcours()),
                'owner'=>$this->getUser()->getId()
              );
             $this->get('fmc_manager')->sendOrGetData($url,$data,'PATCH');

            return $this->redirectToRoute('session_index');
        }elseif($editForm->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('session/edit.html.twig', array(
            'session' => $session,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
 
 /**
 * @Security("is_granted('ROLE_CONTROLEUR')")
*/
    public function deleteAction(Request $request, Session $session)
    {
        $form = $this->createDeleteForm($session);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($session);
            $em->flush();
            $this->addFlash('success', 'Supprimé.');
        }
        return $this->redirectToRoute('session_index');
    }

    /**
     * Creates a form to delete a session entity.
     *
     * @param Session $session The session entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Session $session)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('session_delete', array('id' => $session->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

 
 /**
 * @Security("is_granted('ROLE_CONTROLEUR')")
*/
    public function attrAction(Request $request, Session $session)
    {
         $referer = $this->getRequest()->headers->get('referer');   
        $form = $this->createAttForm($session);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
              $formData=$form->getData();
              $superviseur=$em->getRepository('AppBundle:User')->findOneByUsername($formData['user']);
              if($superviseur!=null){
                  $session->setOwner($formData['user']);
                   $session->setUser( $superviseur);
                   $em->flush();
                 $url="https://trainings-fa73e.firebaseio.com/session/".$session->getId()."/.json";
                 $data = array(
                'info'=>array('groupName' => $session->getNomConcours()),
                'owner'=>$formData['user']
              );
             $this->get('fmc_manager')->sendOrGetData($url,$data,'PATCH');
             $this->addFlash('success', 'Attribution de responsabilité à '.$session->getUser()->getNom());
              return $this->redirectToRoute('session_attr', array('id' => $session->getId()));
              }
              $this->addFlash('error', "Le numéro de téléphone ne corresponds à celui d'aucun utilisateur enrégistré. Veillez saisir un numéro de 09 chiffres.");

        }elseif($form->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');
       return $this->render('session/attr.html.twig', array(
            'session' => $session,
            'form' => $form->createView(),
        ));
    }

     /**
     * Creates a form to delete a partie entity.
     * @param Partie $partie The partie entity
     * @return \Symfony\Component\Form\Form The form
     */

    private function createAttForm()
    {
        return $this->createFormBuilder()
               ->add('user','text',array('label'=>'Telephone superviseur'))
             //->setAction($this->generateUrl('session_attr', array('id' => $session->getId())))
             ->setMethod('GET')
            ->getForm()
        ;
    }   
}
