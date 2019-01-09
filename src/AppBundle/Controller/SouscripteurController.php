<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Souscripteur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Souscripteur controller.
 *
 */
class SouscripteurController extends Controller
{
    /**
     * Lists all souscripteur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $souscripteurs = $em->getRepository('AppBundle:Souscripteur')->findAll();

        return $this->render('souscripteur/index.html.twig', array(
            'souscripteurs' => $souscripteurs,
        ));
    }

    /**
     * Creates a new souscripteur entity.
     *
     */
    public function newAction(Request $request)
    {
        $souscripteur = new Souscripteur();
        $form = $this->createForm('AppBundle\Form\SouscripteurType', $souscripteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($souscripteur);
            $em->flush();

            return $this->redirectToRoute('souscripteur_show', array('id' => $souscripteur->getId()));
        }

        return $this->render('souscripteur/new.html.twig', array(
            'souscripteur' => $souscripteur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a souscripteur entity.
     *
     */
    public function showAction(Souscripteur $souscripteur)
    {
        $deleteForm = $this->createDeleteForm($souscripteur);

        return $this->render('souscripteur/show.html.twig', array(
            'souscripteur' => $souscripteur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing souscripteur entity.
     *
     */
    public function editAction(Request $request, Souscripteur $souscripteur)
    {
        $deleteForm = $this->createDeleteForm($souscripteur);
        $editForm = $this->createForm('AppBundle\Form\SouscripteurType', $souscripteur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('souscripteur_edit', array('id' => $souscripteur->getId()));
        }

        return $this->render('souscripteur/edit.html.twig', array(
            'souscripteur' => $souscripteur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a souscripteur entity.
     *
     */
    public function deleteAction(Request $request, Souscripteur $souscripteur)
    {
        $form = $this->createDeleteForm($souscripteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($souscripteur);
            $em->flush();
        }

        return $this->redirectToRoute('souscripteur_index');
    }

    /**
     * Creates a form to delete a souscripteur entity.
     *
     * @param Souscripteur $souscripteur The souscripteur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Souscripteur $souscripteur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('souscripteur_delete', array('id' => $souscripteur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
