<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Session;
use AppBundle\Entity\Objectif;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
/**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function indexAction(Session $session=null)
    {
        $em = $this->getDoctrine()->getManager();
        $liens=array();
        if (!is_null($session)) {
            $liens=$session->getLiens();
        }
        $liens=$em->getRepository('AppBundle:Objectif')->findAll();

        return $this->render('objectif/index.html.twig', array(
            'liens' =>  $liens,  'session' => $session,
        ));
    }

    /**
     * Creates a new objectif entity.
     *
     */
    /**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function newAction(Request $request,Session $session=null)
    {
        $objectif = new Objectif();
        $form = $this->createForm('AppBundle\Form\ObjectifType', $objectif);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($objectif);
            $em->flush($objectif);
             $this->addFlash('success', 'Enrégistrement effectué');
            return $this->redirectToRoute('objectif_index', array('id' => $session->getId()));
        }elseif($form->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('objectif/new.html.twig', array(
            'objectif' => $objectif,'session' => $session,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a objectif entity.
     *
     */
    /**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
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
    /**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function editAction(Request $request, Objectif $objectif)
    {
        $deleteForm = $this->createDeleteForm($objectif);
        $editForm = $this->createForm('AppBundle\Form\ObjectifType', $objectif);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Modifications  enrégistrées avec succès.');
            return $this->redirectToRoute('objectif_edit', array('id' => $objectif->getId()));
        }elseif($editForm->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

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
    /**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
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
            $this->addFlash('success', 'Supprimé.');
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
