<?php

namespace AppBundle\Controller;

use AppBundle\Entity\RendezVous;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Rendezvous controller.
 *
 */
class RendezVousController extends Controller
{
    /**
     * Lists all rendezVous entities.
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

        $rendezVouses = $em->getRepository('AppBundle:RendezVous')->findList($region,$startDate,$endDate);

        return $this->render('rendezvous/index.html.twig', array(
            'rendezVouses' => $rendezVouses,
        ));
    }

    /**
     * Creates a new rendezVous entity.
     *
     */
    public function newAction(Request $request)
    {
        $rendezVous = new Rendezvous();
        $form = $this->createForm('AppBundle\Form\RendezVousType', $rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rendezVous);
            $em->flush($rendezVous);

            return $this->redirectToRoute('rendezvous_show', array('id' => $rendezVous->getId()));
        }

        return $this->render('rendezvous/new.html.twig', array(
            'rendezVous' => $rendezVous,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rendezVous entity.
     *
     */
    public function showAction(RendezVous $rendezVous)
    {
        $deleteForm = $this->createDeleteForm($rendezVous);

        return $this->render('rendezvous/show.html.twig', array(
            'rendezVous' => $rendezVous,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rendezVous entity.
     *
     */
    public function editAction(Request $request, RendezVous $rendezVous)
    {
        $deleteForm = $this->createDeleteForm($rendezVous);
        $editForm = $this->createForm('AppBundle\Form\RendezVousType', $rendezVous);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rendezvous_edit', array('id' => $rendezVous->getId()));
        }

        return $this->render('rendezvous/edit.html.twig', array(
            'rendezVous' => $rendezVous,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a rendezVous entity.
     *
     */
    public function deleteAction(Request $request, RendezVous $rendezVous)
    {
        $form = $this->createDeleteForm($rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rendezVous);
            $em->flush($rendezVous);
        }

        return $this->redirectToRoute('rendezvous_index');
    }

    /**
     * Creates a form to delete a rendezVous entity.
     *
     * @param RendezVous $rendezVous The rendezVous entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RendezVous $rendezVous)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rendezvous_delete', array('id' => $rendezVous->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
