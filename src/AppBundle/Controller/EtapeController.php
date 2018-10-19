<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Etape;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Campagne;
/**
 * Etape controller.
 */
class EtapeController extends Controller
{
    /**
     * Lists all etape entities.
     *
     */
    public function indexAction(Request $request, Campagne $campagne)
    {
        $em = $this->getDoctrine()->getManager();
        //$etapes = $em->getRepository('AppBundle:Etape')->findList( $campagne);
        return $this->render('etape/index.html.twig', array(
            'etapes' => $campagne->getEtapes(),
            'campagne' => $campagne
        ));
    }


    /**
     * Creates a new etape entity.
     *
     */
    public function newAction(Request $request, Campagne $campagne)
    {
        $etape = new Etape();
        $form = $this->createForm('AppBundle\Form\EtapeType', $etape);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $etape->setUser($this->getUser());
            $em->persist($etape);
            $em->flush();
            return $this->redirectToRoute('etape_index');
        }
        return $this->render('etape/new.html.twig', array(
            'etape' => $etape,
            'campagne' => $campagne,
            'campagne' => $campagne,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a etape entity.
     *
     */
    public function showAction(Etape $etape)
    {
        $deleteForm = $this->createDeleteForm($etape);
        return $this->render('etape/show.html.twig', array(
            'etape' => $etape,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing etape entity.
     *
     */
    public function editAction(Request $request, Etape $etape)
    {
        $deleteForm = $this->createDeleteForm($etape);
        $editForm = $this->createForm('AppBundle\Form\EtapeType', $etape);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('etape_edit', array('id' => $etape->getId()));
        }
        return $this->render('etape/edit.html.twig', array(
            'etape' => $etape,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a etape entity.
     *
     */
    public function deleteAction(Request $request, Etape $etape)
    {
        $form = $this->createDeleteForm($etape);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($etape);
            $em->flush();
        }
        return $this->redirectToRoute('etape_index');
    }

    /**
     * Creates a form to delete a etape entity.
     *
     * @param Etape $etape The etape entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Etape $etape)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('etape_delete', array('id' => $etape->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
