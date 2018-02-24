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
/**
 * Session controller.
 *
 */
class SessionController extends Controller
{
    /**
     * Lists all session entities.
     *
     */
    public function indexAction(Concours $concours)
    {
      //  $em = $this->getDoctrine()->getManager();
       // $sessions = $em->getRepository('AppBundle:Session')->findAll();
        return $this->render('session/index.html.twig', array(
            'sessions' => $concours->getSessions(),'concour' => $concours,
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
        
        return $session;
    }


    /**
     * Creates a new session entity.
     *
     */
    public function newAction(Concours $concour,Request $request)
    {
        $session = new Session($concour);
        $form = $this->createForm('AppBundle\Form\SessionType', $session);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
             $em->persist($session);
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
     * Finds and displays a session entity.
     *
     */
    public function showAction(Session $session)
    {
        $deleteForm = $this->createDeleteForm($session);       
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
                    return !empty($this->getDoctrine()->getManager()->getRepository('AppBundle:Session')->findByUser( $session,$info));  
                }
          }
         return  false;
    }

    /**
     * Displays a form to edit an existing session entity.
     *
     */
    public function editAction(Request $request, Session $session)
    {
        $deleteForm = $this->createDeleteForm($session);
        $editForm = $this->createForm('AppBundle\Form\SessionType', $session);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        /*if ($session->getOwner()!=null) {
          $url="https://trainings-fa73e.firebaseio.com/session/".$session->getId()."/.json";
          $data = array(
            'info'=>array('groupName' => $session->getNomConcours()),
            'owner'=>$session->getOwner()->getUid()
              );
              return new Response($this->sendPostRequest($url,$data,array(),false));
        }*/
            return $this->redirectToRoute('session_edit', array('id' => $session->getId()));
        }

        return $this->render('session/edit.html.twig', array(
            'session' => $session,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
 
    /**
     * Deletes a session entity.
     *
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
}
