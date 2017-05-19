<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Activation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Activation controller.
 *
 */
class ActivationController extends Controller
{
    /**
     * Lists all activation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
       $session = $this->getRequest()->getSession();
       $date = new \DateTime();
        $week = $date->format("W");
        $year=$date->format("Y");
        $date->setISODate($year, $week);
         $weekStart = $date->format('Y-m-d');
         $date->modify('+6 days');
         $weekEnd=$date->format('Y-m-d'); 
        $region=$session->get('region');
        $startDate=$session->get('startDate',$weekStart);
        $endDate=$session->get('endDate',$weekEnd);
        $activations = $em->getRepository('AppBundle:Activation')->findList( $region,$startDate,$endDate);
        return $this->render('activation/index.html.twig', array(
            'activations' => $activations,
        ));
    }

    /**
     * Creates a new activation entity.
     *
     */
    public function newAction(Request $request)
    {
        $activation = new Activation();
        $form = $this->createForm('AppBundle\Form\ActivationType', $activation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($activation);
            $em->flush($activation);

            return $this->redirectToRoute('activation_show', array('id' => $activation->getId()));
        }

        return $this->render('activation/new.html.twig', array(
            'activation' => $activation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a activation entity.
     *
     */
    public function showAction(Activation $activation)
    {
        $deleteForm = $this->createDeleteForm($activation);

        return $this->render('activation/show.html.twig', array(
            'activation' => $activation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing activation entity.
     *
     */
    public function editAction(Request $request, Activation $activation)
    {
        $deleteForm = $this->createDeleteForm($activation);
        $editForm = $this->createForm('AppBundle\Form\ActivationType', $activation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('activation_edit', array('id' => $activation->getId()));
        }

        return $this->render('activation/edit.html.twig', array(
            'activation' => $activation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a activation entity.
     *
     */
    public function deleteAction(Request $request, Activation $activation)
    {
        $form = $this->createDeleteForm($activation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($activation);
            $em->flush($activation);
        }

        return $this->redirectToRoute('activation_index');
    }

    /**
     * Creates a form to delete a activation entity.
     *
     * @param Activation $activation The activation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Activation $activation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('activation_delete', array('id' => $activation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
