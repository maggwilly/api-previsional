<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Partie;
use AppBundle\Entity\Objectif;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Objectif controller.
 *
 */
class ObjectifController extends Controller
{
    /**
     * Lists all objectif entities.
     *
     */

    public function indexAction(Partie $partie)
    {
        $em = $this->getDoctrine()->getManager();

        $objectifs = $em->getRepository('AppBundle:Objectif')->findAll();

        return $this->render('objectif/index.html.twig', array(
            'objectifs' =>  $partie->getObjectifs(),  'partie' => $partie,
        ));
    }

    /**
     * Creates a new objectif entity.
     *
     */
    public function newAction(Partie $partie,Request $request)
    {
        $objectif = new Objectif();
        $form = $this->createForm('AppBundle\Form\ObjectifType', $objectif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $objectif->setPartie($partie);
            $em->persist($objectif);
            $em->flush($objectif);

            return $this->redirectToRoute('partie_show', array('id' => $partie->getId()));
        }

        return $this->render('objectif/new.html.twig', array(
            'objectif' => $objectif,'partie' => $partie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a objectif entity.
     *
     */
    public function showAction(Objectif $objectif)
    {
        $deleteForm = $this->createDeleteForm($objectif);

        return $this->render('objectif/show.html.twig', array(
            'objectif' => $objectif,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing objectif entity.
     *
     */
    public function editAction(Request $request, Objectif $objectif)
    {
        $deleteForm = $this->createDeleteForm($objectif);
        $editForm = $this->createForm('AppBundle\Form\ObjectifType', $objectif);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('objectif_edit', array('id' => $objectif->getId()));
        }

        return $this->render('objectif/edit.html.twig', array(
            'objectif' => $objectif,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a objectif entity.
     *
     */
    public function deleteAction(Request $request, Objectif $objectif)
    {
        $partie=$objectif->getPartie();
        $form = $this->createDeleteForm($objectif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($objectif);
            $em->flush($objectif);
        }

         return $this->redirectToRoute('partie_show', array('id' => $partie->getId()));
    }

    /**
     * Creates a form to delete a objectif entity.
     *
     * @param Objectif $objectif The objectif entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Objectif $objectif)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('objectif_delete', array('id' => $objectif->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
