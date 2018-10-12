<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Campagne;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Campagne controller.
 *
 */
class CampagneController extends Controller
{
    /**
     * Lists all campagne entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $campagnes = $em->getRepository('AppBundle:Campagne')->findAll();

        return $this->render('campagne/index.html.twig', array(
            'campagnes' => $campagnes,
        ));
    }

    /**
     * Creates a new campagne entity.
     *
     */
    public function newAction(Request $request)
    {
        $campagne = new Campagne();
        $form = $this->createForm('AppBundle\Form\CampagneType', $campagne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($campagne);
            $em->flush();

            return $this->redirectToRoute('campagne_show', array('id' => $campagne->getId()));
        }

        return $this->render('campagne/new.html.twig', array(
            'campagne' => $campagne,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a campagne entity.
     *
     */
    public function showAction(Campagne $campagne)
    {
        $deleteForm = $this->createDeleteForm($campagne);

        return $this->render('campagne/show.html.twig', array(
            'campagne' => $campagne,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing campagne entity.
     *
     */
    public function editAction(Request $request, Campagne $campagne)
    {
        $deleteForm = $this->createDeleteForm($campagne);
        $editForm = $this->createForm('AppBundle\Form\CampagneType', $campagne);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('campagne_edit', array('id' => $campagne->getId()));
        }

        return $this->render('campagne/edit.html.twig', array(
            'campagne' => $campagne,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a campagne entity.
     *
     */
    public function deleteAction(Request $request, Campagne $campagne)
    {
        $form = $this->createDeleteForm($campagne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($campagne);
            $em->flush();
        }

        return $this->redirectToRoute('campagne_index');
    }

    /**
     * Creates a form to delete a campagne entity.
     *
     * @param Campagne $campagne The campagne entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Campagne $campagne)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('campagne_delete', array('id' => $campagne->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
