<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Partie;
use AppBundle\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
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
        $em = $this->getDoctrine()->getManager();
        $questions = $em->getRepository('AppBundle:Question')->findAll();
        return $this->render('question/index.html.twig', array(
            'questions' => $partie->getQuestions(), 'partie' => $partie,
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

    /**
     * Creates a new question entity.
     *
     */
    public function newAction(Partie $partie,Request $request)
    {
        $question = new Question();
        $form = $this->createForm('AppBundle\Form\QuestionType', $question);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $question->setPartie($partie);
            $question->setUser($this->getUser());
            $em->persist($question);
            $em->flush($question);
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
     * Displays a form to edit an existing question entity.
     *
     */
    public function editAction(Request $request, Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm('AppBundle\Form\QuestionType', $question);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
             $question->setValidated(false);
            $this->getDoctrine()->getManager()->flush();
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
        $form = $this->createDeleteForm($question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($question);
            $em->flush($question);
        }

        return $this->redirectToRoute('question_index');
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
