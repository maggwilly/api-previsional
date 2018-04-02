<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Concours;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Concour controller.
 *
 */
class ConcoursController extends Controller
{
 /**
 * @Security("is_granted('ROLE_CONTROLEUR')")
*/
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $concours = $em->getRepository('AppBundle:Concours')->findAll();

        return $this->render('concours/index.html.twig', array(
            'concours' => $concours,
        ));
    }

        /**
     * Creates a new session entity.
     *
     */
    public function newFromProgrmmeAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
      $programmes = $em->getRepository('AppBundle:Programme')->findAll();
      foreach ( $programmes as  $programme) {
          $concour = new Concours($programme);
           $em->persist($concour);
      }
     $em->flush();
   return $this->redirectToRoute('concours_index');
    }

 /**
 * @Security("is_granted('ROLE_CONTROLEUR')")
*/
    public function newAction(Request $request)
    {
        $concour = new Concours();
        $form = $this->createForm('AppBundle\Form\ConcoursType', $concour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($concour);
            $em->flush();
            $this->addFlash('success', 'Cours enrégistré avec succès.');
            return $this->redirectToRoute('concours_show', array('id' => $concour->getId()));
        }elseif($form->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('concours/new.html.twig', array(
            'concour' => $concour,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a concour entity.
     *
     */
    public function showAction(Concours $concour)
    {
        $deleteForm = $this->createDeleteForm($concour);
        return $this->render('concours/show.html.twig', array(
            'concour' => $concour,
            'delete_form' => $deleteForm->createView(),
        ));
    }

 /**
 * @Security("is_granted('ROLE_CONTROLEUR')")
*/
    public function editAction(Request $request, Concours $concour)
    {
        $deleteForm = $this->createDeleteForm($concour);
        $editForm = $this->createForm('AppBundle\Form\ConcoursType', $concour);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
           $this->addFlash('success', 'Modifications  enrégistrées avec succès.');
            return $this->redirectToRoute('concours_edit', array('id' => $concour->getId()));
        }elseif($editForm->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('concours/edit.html.twig', array(
            'concour' => $concour,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

 /**
 * @Security("is_granted('ROLE_CONTROLEUR')")
*/
    public function deleteAction(Request $request, Concours $concour)
    {
        $form = $this->createDeleteForm($concour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($concour);
            $em->flush();
            $this->addFlash('success', 'Supprimé.');
        }

        return $this->redirectToRoute('concours_index');
    }

    /**
     * Creates a form to delete a concour entity.
     *
     * @param Concours $concour The concour entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Concours $concour)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('concours_delete', array('id' => $concour->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
