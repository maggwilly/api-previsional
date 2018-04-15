<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Explication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Content;
use AppBundle\Entity\Question;
use Pwm\MessagerBundle\Entity\Notification;
use AppBundle\Event\NotificationEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Explication controller.
 *
 */
class ExplicationController extends Controller
{
    /**
     * Lists all explication entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $explications = $em->getRepository('AppBundle:Explication')->findAll();

        return $this->render('explication/index.html.twig', array(
            'explications' => $explications,
        ));
    }

 /**
 * @Security("is_granted('ROLE_SAISIE')")
*/
    public function newAction(Request $request,Question $question=null,Content $content=null)
    {
        $explication = new Explication();
        $form = $this->createForm('AppBundle\Form\ExplicationType', $explication);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
             $session  = $em->getRepository('AppBundle:Session')->findOneById($this->get("session")->get('current_session_id'));
              $explication->setUser($this->getUser());
            $em->persist($explication);
            if(!is_null($question)){
                 $question->setExplication($explication);  

                  $notification = new Notification('public',true,true);
                  $notification
                ->setTitre( "Réponses à votre préoccupation ")
               ->setSousTitre("Une explication plus claire de la question ~ ".$question->getId()."de ".$question->getPartie()->getTitre())
               ->setText($question->getText().'<br>'.$explication->getText())
                ->setGroupe($session->getGroupe());
                 $em->persist($notification);

                 $url="https://trainings-fa73e.firebaseio.com/status/question/".$question->getPartie()->getId().'/'.$question->getId()."/.json";
                 $res =!is_null($this->get('fmc_manager')->sendOrGetData($url,null,'GET')) ?$this->get('fmc_manager')->sendOrGetData($url,null,'GET'):array();    
                 $destUids=array_keys($res);
                 $registrations = $em->getRepository('MessagerBundle:Registration')->findByUsers($destUids); 
                 $event=new NotificationEvent($registrations,$notification);
                 $this->get('event_dispatcher')->dispatch('notification.shedule.to.send', $event);
            }

              if(!is_null($content)){
                 $content->setExplication($explication);
                $notification = new Notification('public');
                $notification
               ->setTitre( "Réponses à votre préoccupation ")
               ->setSousTitre("Une explication plus claire de ~ ".$content->getSubtitle())
               ->setText($explication->getText()) 
               ->setGroupe($session->getGroupe());
                $em->persist($notification);

                $url="https://trainings-fa73e.firebaseio.com/status/content/".$content->getArticle()->getId().'/'.$content->getId()."/.json";
                $res =!is_null($this->get('fmc_manager')->sendOrGetData($url,null,'GET')) ?$this->get('fmc_manager')->sendOrGetData($url,null,'GET'):array(); 
                $destUids=array_keys($res);
                 $registrations = $em->getRepository('MessagerBundle:Registration')->findByUsers($destUids); 
                    $data=array(
                        'page'=>'notification',
                        'id'=>$notification->getId()
                      );
                 $event=new NotificationEvent($registrations,$notification,$data);
                 $this->get('event_dispatcher')->dispatch('notification.shedule.to.send', $event);
              }
               $em->flush();
                $this->addFlash('success', 'Enrégistrement effectué');
            return $this->redirectToRoute('explication_show', 
                array(
                'id' => $explication->getId(),
                'question' =>$question? $question->getId():0,
                'content' => $content?$content->getId():0));
        }elseif($form->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('explication/new.html.twig', array(
            'explication' => $explication,
            'question' => $question,
            'content' => $content,
            'form' => $form->createView(),
        ));
    }

 /**
 * @Security("is_granted('ROLE_SAISIE')")
*/
    public function showAction(Explication $explication,Question $question=null,Content $content=null)
    {
        $deleteForm = $this->createDeleteForm($explication);
        return $this->render('explication/show.html.twig', array(
            'question' => $question,
            'content' => $content,
            'explication' => $explication,
            'delete_form' => $deleteForm->createView(),
        ));
    }

 /**
 * @Security("is_granted('ROLE_SAISIE')")
*/
    public function editAction(Request $request, Explication $explication,Question $question=null,Content $content=null)
    {
        $deleteForm = $this->createDeleteForm($explication);
        $editForm = $this->createForm('AppBundle\Form\ExplicationType', $explication);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
             $this->addFlash('success', 'Modifications  enrégistrées avec succès.');
            return $this->redirectToRoute('explication_edit', array('id' => $explication->getId()));
        }elseif($editForm->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');
        return $this->render('explication/edit.html.twig', array(
            'question' => $question,
            'content' => $content,
            'explication' => $explication,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

 /**
 * @Security("is_granted('ROLE_SAISIE')")
*/
    public function deleteAction(Request $request, Explication $explication)
    {
        $form = $this->createDeleteForm($explication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($explication);
            $em->flush();
            $this->addFlash('success', 'Supprimé.');
        }

        return $this->redirectToRoute('explication_index');
    }

    /**
     * Creates a form to delete a explication entity.
     *
     * @param Explication $explication The explication entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Explication $explication)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('explication_delete', array('id' => $explication->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
