<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Programme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
/**
 * Concour controller.
 *
 */
class ProgrammeController extends Controller
{
    /**
     * Lists all concour entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $concours = $em->getRepository('AppBundle:Programme')->findAll();

        return $this->render('programme/index.html.twig', array(
            'concours' => $concours,
        ));
    }



    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"programme"})
     */
    public function jsonIndexAction($start=0)
    {
        $em = $this->getDoctrine()->getManager();
         $programmes =$em->getRepository('AppBundle:Programme')->findList($start);

        return  $programmes;
    }

        /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"full"})
     */
    public function showJsonAction(Programme $programme){
        
        return $programme;
    }

    /**
     * Creates a new concour entity.
     *
     */
    public function newAction(Request $request)
    {
        $concours = new Programme();
        $form = $this->createForm('AppBundle\Form\ProgrammeType', $concours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($concours);
            $em->flush($concours);
            return $this->redirectToRoute('programme_show', array('id' => $concours->getId()));
        }
        return $this->render('programme/new.html.twig', array(
            'concour' => $concours,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a concour entity.
     *
     */
    public function showAction(Programme $concour)
    {
        $deleteForm = $this->createDeleteForm($concour);

 return $this->render('programme/show.html.twig', array(
      'concour' => $concour, 'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing concour entity.
     *
     */
    public function editAction(Request $request, Programme $concour)
    {
        $deleteForm = $this->createDeleteForm($concour);
        $editForm = $this->createForm('AppBundle\Form\ProgrammeEditType', $concour);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('programme_edit', array('id' => $concour->getId()));
        }

        return $this->render('programme/edit.html.twig', array(
            'concour' => $concour,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a concour entity.
     *
     */
    public function deleteAction(Request $request, Programme $concour)
    {
        $form = $this->createDeleteForm($concour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($concour);
            $em->flush($concour);
        }

        return $this->redirectToRoute('programme_index');
    }

    /**
     * Creates a form to delete a concour entity.
     *
     * @param Concours $concour The concour entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Programme $concour)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('concours_delete', array('id' => $concour->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
