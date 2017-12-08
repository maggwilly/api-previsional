<?php

namespace Pwm\MessagerBundle\Controller;

use Pwm\MessagerBundle\Entity\Pub;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
/**
 * Pub controller.
 *
 */
class PubController extends Controller
{
    /**
     * Lists all pub entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pubs = $em->getRepository('MessagerBundle:Pub')->findAll();
        return $this->render('MessagerBundle:pub:index.html.twig', array(
            'pubs' => $pubs,
        ));
    }


    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"pub"})
     */
    public function jsonIndexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pubs = $em->getRepository('MessagerBundle:Pub')->findList();
        return  $pubs;
    }

    /**
     * Creates a new pub entity.
     *
     */
    public function newAction(Request $request)
    {
        $pub = new Pub();
        $form = $this->createForm('Pwm\MessagerBundle\Form\PubType', $pub);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pub);
            $em->flush();

            return $this->redirectToRoute('pub_show', array('id' => $pub->getId()));
        }

        return $this->render('MessagerBundle:pub:new.html.twig', array(
            'pub' => $pub,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pub entity.
     *
     */
    public function showAction(Pub $pub)
    {
        $deleteForm = $this->createDeleteForm($pub);

        return $this->render('MessagerBundle:pub:show.html.twig', array(
            'pub' => $pub,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pub entity.
     *
     */
    public function editAction(Request $request, Pub $pub)
    {
        $deleteForm = $this->createDeleteForm($pub);
        $editForm = $this->createForm('Pwm\MessagerBundle\Form\PubType', $pub);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pub_edit', array('id' => $pub->getId()));
        }

        return $this->render('MessagerBundle:pub:edit.html.twig', array(
            'pub' => $pub,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pub entity.
     *
     */
    public function deleteAction(Request $request, Pub $pub)
    {
        $form = $this->createDeleteForm($pub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pub);
            $em->flush();
        }

        return $this->redirectToRoute('pub_index');
    }

    /**
     * Creates a form to delete a pub entity.
     *
     * @param Pub $pub The pub entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pub $pub)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pub_delete', array('id' => $pub->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
