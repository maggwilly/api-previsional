<?php

namespace Pwm\AdminBundle\Controller;

use Pwm\AdminBundle\Entity\Ambassador;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Ambassador controller.
 *
 */
class AmbassadorController extends Controller
{
    /**
     * Lists all ambassador entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ambassadors = $em->getRepository('AdminBundle:Ambassador')->findAll();

        return $this->render('ambassador/index.html.twig', array(
            'ambassadors' => $ambassadors,
        ));
    }

    /**
     * Creates a new ambassador entity.
     *
     */
    public function newAction(Request $request)
    {
        $ambassador = new Ambassador();
        $form = $this->createForm('Pwm\AdminBundle\Form\AmbassadorType', $ambassador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($ambassador);
            $em->flush();

            return $this->redirectToRoute('ambassador_show', array('id' => $ambassador->getId()));
        }

        return $this->render('ambassador/new.html.twig', array(
            'ambassador' => $ambassador,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ambassador entity.
     *
     */
    public function showAction(Ambassador $ambassador)
    {
        $deleteForm = $this->createDeleteForm($ambassador);

        return $this->render('ambassador/show.html.twig', array(
            'ambassador' => $ambassador,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ambassador entity.
     *
     */
    public function editAction(Request $request, Ambassador $ambassador)
    {
        $deleteForm = $this->createDeleteForm($ambassador);
        $editForm = $this->createForm('Pwm\AdminBundle\Form\AmbassadorType', $ambassador);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ambassador_edit', array('id' => $ambassador->getId()));
        }

        return $this->render('ambassador/edit.html.twig', array(
            'ambassador' => $ambassador,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ambassador entity.
     *
     */
    public function deleteAction(Request $request, Ambassador $ambassador)
    {
        $form = $this->createDeleteForm($ambassador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ambassador);
            $em->flush();
        }

        return $this->redirectToRoute('ambassador_index');
    }

    /**
     * Creates a form to delete a ambassador entity.
     *
     * @param Ambassador $ambassador The ambassador entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Ambassador $ambassador)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ambassador_delete', array('id' => $ambassador->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
