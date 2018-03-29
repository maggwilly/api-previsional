<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Partie;
use AppBundle\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
use AppBundle\Event\QuestionEvent;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
/**
 * Question controller.
 *
 */
class QuestionController extends Controller
{
    /**
     * Lists all question entities.
     *
     */
    public function indexAction(Partie $partie)
    {
         $questions= $partie->getQuestions();
        return $this->render('question/index.html.twig', array(
            'questions' => $questions, 'partie' => $partie,
        ));
    }
    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"question"})
     */
    public function jsonIndexAction(Partie $partie)
    {
        $questions= $partie->getQuestions();
        return   $questions;
    }

    public function sortCollection($collection){
    $iterator = $collection->getIterator();
    $iterator->uasort(function ($a, $b) {
    return ($a->getId() < $b->getId()) ? -1 : 1;
    });
   return  iterator_to_array($iterator);
 }

    /**
     * Finds and displays a partie entity.
     *
     */
    public function getBlockedPersonsAction(Question $question)
    {
         $url="https://trainings-fa73e.firebaseio.com/status/question/".$$question->getPartie()->getId().'/'.$question->getId()."/.json";
         $res =!is_null($this->get('fmc_manager')->sendOrGetData($url,null,'GET')) ?$this->get('fmc_manager')->sendOrGetData($url,null,'GET'):array(); 
        return  new Response(''.count($res));
    }

    public function newAction(Partie $partie,Request $request)
    {
        $question = new Question();
        $form = $this->createForm('AppBundle\Form\QuestionType', $question, array('partie'=>$partie));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $question->setPartie($partie);
            $question->setUser($this->getUser());
            $em->persist($question);
            $em->flush($question);
            $event= new QuestionEvent($question);
            $this->get('event_dispatcher')->dispatch('object.created', $event);
            return $this->redirectToRoute('question_show', array('id' => $question->getId()));
        }

        return $this->render('question/new.html.twig', array(
            'question' => $question, 'partie' => $partie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a question entity.
     *
     */
    public function showAction(Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);
        return $this->render('question/show.html.twig', array(
            'question' => $question,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a question entity.
     *
     */
    public function showFromMobileAction(Question $question)
    {
        return $this->render('question/showFromMobile.html.twig', array(
            'question' => $question,
        ));
    }
    /**
     * Displays a form to edit an existing question entity.
     *
     */
    public function editAction(Request $request, Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm('AppBundle\Form\QuestionType', $question, array('partie'=>$question->getPartie()));
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
             $question->setValidated(false);
            $this->getDoctrine()->getManager()->flush();
            $event= new QuestionEvent($question);
            $this->get('event_dispatcher')->dispatch('object.created', $event);
            return $this->redirectToRoute('question_show', array('id' => $question->getId()));
        }
        return $this->render('question/edit.html.twig', array(
            'question' => $question,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing question entity.
     *
     */
    public function valideAction(Request $request, Question $question)
    {
        $question->setValidated(true);
        $question->setValidateur($this->getUser());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('question_show', array('id' => $question->getId()));
    }
    /**
     * Deletes a question entity.
     *
     */
    public function deleteAction(Request $request, Question $question)
    {
        $cloudinary = $this -> container -> get('misteio_cloudinary_wrapper');
        $form = $this->createDeleteForm($question);
        $form->handleRequest($request);
         $id=$question->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($question);
            $em->flush($question);
            $cloudinary -> destroy('_question_'.$id);
        }

        return $this->redirectToRoute('question_index', array('id' => $question->getPartie()->getId()));
    }

    /**
     * Creates a form to delete a question entity.
     *
     * @param Question $question The question entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Question $question)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('question_delete', array('id' => $question->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
