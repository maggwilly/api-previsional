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


class SessionController extends Controller
{
/**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function indexAction(Concours $concours=null, $all=false)
    {
        $em = $this->getDoctrine()->getManager();
         $sessions=array();
          if(!is_null($concours))
                $sessions=$concours->getSessions();
           elseif(!$all)
              $sessions= $em->getRepository('AppBundle:Session')->findListByUser($this->getUser());
          else
             $sessions = $em->getRepository('AppBundle:Session')->findAll();
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
     public function jsonForUserAction(Request $request,Info $info)
     {
         $em = $this->getDoctrine()->getManager();
          $sessions =$em->getRepository('AppBundle:Session')->findForUser($info);
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
             ->setText("Un Nouveau concours est disponible. Verifiez s'il correspond à votre profil".$session->getNomConcours());
             $notification->setUser($this->getUser());
              $em->persist($notification);
              $em->flush();
               return $this->redirectToRoute('notification_edit', array('id' =>  $notification->getId()));
            }
            
             $em->flush();

            return $this->redirectToRoute('session_show', array('id' => $session->getId()));
        }
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
         $this->get("session")->set('current_session_id', $session->getId());     
        return $this->render('session/show.html.twig', array(
            'session' => $session,
            'delete_form' => $deleteForm->createView(),
        ));
    }


        /**
     * Lists all Produit entities.
     *@Rest\View()
     */
    public function followsAction(Request $request,Session $session, Info $info)
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
               return $this->redirectToRoute('notification_edit', array('id' =>  $notification->getId()));
            }
            $em->flush();
            return $this->redirectToRoute('session_index');
        }

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
              return $this->redirectToRoute('session_attr', array('id' => $session->getId()));
              }

        }
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
