<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Explication;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Content;
use AppBundle\Entity\Question;
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
     * Creates a new explication entity.
     *
     */
    public function newAction(Request $request,Question $question=null,Content $content=null)
    {
        $explication = new Explication();
        $form = $this->createForm('AppBundle\Form\ExplicationType', $explication);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($explication);
            if(!is_null($question))
                $question->setExplication($explication);
              if(!is_null($content))
                 $content->setExplication($explication);
            $em->flush();
            return $this->redirectToRoute('explication_show', array('id' => $explication->getId()));
        }

        return $this->render('explication/new.html.twig', array(
            'explication' => $explication,
            'question' => $question,
            'content' => $content,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a explication entity.
     *
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
     * Displays a form to edit an existing explication entity.
     *
     */
    public function editAction(Request $request, Explication $explication)
    {
        $deleteForm = $this->createDeleteForm($explication);
        $editForm = $this->createForm('AppBundle\Form\ExplicationType', $explication);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('explication_edit', array('id' => $explication->getId()));
        }
        return $this->render('explication/edit.html.twig', array(
            'explication' => $explication,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a explication entity.
     *
     */
    public function deleteAction(Request $request, Explication $explication)
    {
        $form = $this->createDeleteForm($explication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($explication);
            $em->flush();
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
