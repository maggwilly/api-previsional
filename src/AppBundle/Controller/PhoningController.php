<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Phoning;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Phoning controller.
 *
 */
class PhoningController extends Controller
{
    /**
     * Lists all phoning entities.
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

        $phonings = $em->getRepository('AppBundle:Phoning')->findList($region, $startDate, $endDate);

        return $this->render('phoning/index.html.twig', array(
            'phonings' => $phonings,
        ));
    }

    /**
     * Creates a new phoning entity.
     *
     */
    public function newAction(Request $request)
    {
        $phoning = new Phoning();
        $form = $this->createForm('AppBundle\Form\PhoningType', $phoning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($phoning);
            $em->flush($phoning);

            return $this->redirectToRoute('phoning_show', array('id' => $phoning->getId()));
        }

        return $this->render('phoning/new.html.twig', array(
            'phoning' => $phoning,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a phoning entity.
     *
     */
    public function showAction(Phoning $phoning)
    {
        $deleteForm = $this->createDeleteForm($phoning);

        return $this->render('phoning/show.html.twig', array(
            'phoning' => $phoning,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing phoning entity.
     *
     */
    public function editAction(Request $request, Phoning $phoning)
    {
        $deleteForm = $this->createDeleteForm($phoning);
        $editForm = $this->createForm('AppBundle\Form\PhoningType', $phoning);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('phoning_edit', array('id' => $phoning->getId()));
        }

        return $this->render('phoning/edit.html.twig', array(
            'phoning' => $phoning,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a phoning entity.
     *
     */
    public function deleteAction(Request $request, Phoning $phoning)
    {
        $form = $this->createDeleteForm($phoning);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($phoning);
            $em->flush($phoning);
        }

        return $this->redirectToRoute('phoning_index');
    }

    /**
     * Creates a form to delete a phoning entity.
     *
     * @param Phoning $phoning The phoning entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Phoning $phoning)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('phoning_delete', array('id' => $phoning->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
