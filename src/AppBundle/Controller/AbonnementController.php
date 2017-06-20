<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Abonnement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
use AppBundle\Entity\Programme;
/**
 * Abonnement controller.
 *
 */
class AbonnementController extends Controller
{

    
    /**
     * Lists all abonnement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $abonnements = $em->getRepository('AppBundle:Abonnement')->findAll();

        return $this->render('abonnement/index.html.twig', array(
            'abonnements' => $abonnements,
        ));
    }


    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"abonnement"})
     */
    public function indexJsonAction($studentId)
    {
        $em = $this->getDoctrine()->getManager();
        $abonnements = $em->getRepository('AppBundle:Abonnement')->findForMe($studentId);
        return  $abonnements;
    }


    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"abonnement"})
     */
    public function newJsonAction(Request $request, Abonnement $abonnement=null)
    {   
        if($abonnement!=null)
            return $this->editAction($request, $abonnement);
            $abonnement = new Abonnement();
         $form = $this->createForm('AppBundle\Form\AbonnementType', $abonnement);
         $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $programme-=$abonnement->getProgramme()->addInscrit();
              $em->persist($abonnement);
             $em->flush();
            return $abonnement;
        }
        return $form;
    }

        /**
     * Displays a form to edit an existing analyse entity.
     *
     */
    public function editAction(Request $request, Abonnement $abonnement)
    {
        $form = $this->createForm('AppBundle\Form\AbonnementType', $abonnement);
         $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $abonnement;
        }
        return $form;
    }


    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"abonnement"})
     */
    public function showJsonAction($studentId,Programme $programme){
        $em = $this->getDoctrine()->getManager();
         $abonnement = $em->getRepository('AppBundle:Abonnement')->findOneForMe($studentId,$programme);
        return $abonnement;
    }

    /**
     * Creates a new abonnement entity.
     *
     */
    public function newAction(Request $request)
    {
        $abonnement = new Abonnement();
        $form = $this->createForm('AppBundle\Form\AbonnementType', $abonnement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($abonnement);
            $em->flush($abonnement);
            return $this->redirectToRoute('abonnement_show', array('id' => $abonnement->getId()));
        }

        return $this->render('abonnement/new.html.twig', array(
            'abonnement' => $abonnement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a abonnement entity.
     *
     */
    public function showAction(Abonnement $abonnement)
    {
        $deleteForm = $this->createDeleteForm($abonnement);

        return $this->render('abonnement/show.html.twig', array(
            'abonnement' => $abonnement,
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Deletes a abonnement entity.
     *
     */
    public function deleteAction(Request $request, Abonnement $abonnement)
    {
        $form = $this->createDeleteForm($abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($abonnement);
            $em->flush($abonnement);
        }

        return $this->redirectToRoute('abonnement_index');
    }

    /**
     * Creates a form to delete a abonnement entity.
     *
     * @param Abonnement $abonnement The abonnement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Abonnement $abonnement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('abonnement_delete', array('id' => $abonnement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
