<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Matiere;
use AppBundle\Entity\Partie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
use Doctrine\Common\Collections\ArrayCollection;

// Utilisation de la vue de FOSRestBundle

/**
 * Partie controller.
 */
class PartieController extends Controller
{

    /**
     * Lists all partie entities.
     */
    public function indexAction(Matiere $matiere)
    {
        $parties= $matiere->getParties();
        return $this->render('partie/index.html.twig', array(
            'parties' => $this->sortCollection($parties), 'matiere' => $matiere,
        ));
    }

    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"partie"})
     */
    public function jsonIndexAction(Matiere $matiere)
    {
       $parties= $matiere->getParties();
        return   $this->sortCollection($parties);
    }
    
    public function sortCollection($collection){
    $iterator = $collection->getIterator();
    $iterator->uasort(function ($a, $b) {
    return ($a->getId() < $b->getId()) ? -1 : 1;
    });
   return  iterator_to_array($iterator);
 }
    /**
     * Creates a new partie entity.
     *
     */
    public function newAction(Matiere $matiere,Request $request)
    {
        $partie = new Partie();
        $form = $this->createForm('AppBundle\Form\PartieType', $partie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $partie->setMatiere($matiere);
            $em->persist($partie);
            $em->flush($partie);
            return $this->redirectToRoute('partie_show', array('id' => $partie->getId()));
        }

        return $this->render('partie/new.html.twig', array(
            'partie' => $partie, 'matiere' => $matiere,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a partie entity.
     *
     */
    public function showAction(Partie $partie)
    {
        $deleteForm = $this->createDeleteForm($partie);

        return $this->render('partie/show.html.twig', array(
            'partie' => $partie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing partie entity.
     *
     */
    public function editAction(Request $request, Partie $partie)
    {
        $deleteForm = $this->createDeleteForm($partie);
        $editForm = $this->createForm('AppBundle\Form\PartieEditType', $partie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partie_edit', array('id' => $partie->getId()));
        }

        return $this->render('partie/edit.html.twig', array(
            'partie' => $partie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a partie entity.
     *
     */
    public function deleteAction(Request $request, Partie $partie)
    {
        $form = $this->createDeleteForm($partie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($partie);
            $em->flush($partie);
        }

        return $this->redirectToRoute('partie_index');
    }

    /**
     * Creates a form to delete a partie entity.
     *
     * @param Partie $partie The partie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Partie $partie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partie_delete', array('id' => $partie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
