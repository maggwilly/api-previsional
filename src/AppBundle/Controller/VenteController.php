<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Vente controller.
 *
 */
class VenteController extends Controller
{
    /**
     * Lists all vente entities.
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
        $ventes = $em->getRepository('AppBundle:Vente')->findList($region,$startDate, $endDate);
        return $this->render('vente/index.html.twig', array(
            'ventes' => $ventes,
        ));
    }

    /**
     * Creates a new vente entity.
     *
     */
    public function newAction(Request $request)
    {
        $vente = new Vente();
        $form = $this->createForm('AppBundle\Form\VenteType', $vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($vente);
            $em->flush($vente);

            return $this->redirectToRoute('vente_show', array('id' => $vente->getId()));
        }

        return $this->render('vente/new.html.twig', array(
            'vente' => $vente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a vente entity.
     *
     */
    public function showAction(Vente $vente)
    {
        $deleteForm = $this->createDeleteForm($vente);

        return $this->render('vente/show.html.twig', array(
            'vente' => $vente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing vente entity.
     *
     */
    public function editAction(Request $request, Vente $vente)
    {
        $deleteForm = $this->createDeleteForm($vente);
        $editForm = $this->createForm('AppBundle\Form\VenteType', $vente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('vente_edit', array('id' => $vente->getId()));
        }

        return $this->render('vente/edit.html.twig', array(
            'vente' => $vente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a vente entity.
     *
     */
    public function deleteAction(Request $request, Vente $vente)
    {
        $form = $this->createDeleteForm($vente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vente);
            $em->flush($vente);
        }

        return $this->redirectToRoute('vente_index');
    }

    /**
     * Creates a form to delete a vente entity.
     *
     * @param Vente $vente The vente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Vente $vente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vente_delete', array('id' => $vente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
