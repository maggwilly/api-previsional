<?php

namespace Pwm\AdminBundle\Controller;

use Pwm\AdminBundle\Entity\Price;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Price controller.
 *
 */
class PriceController extends Controller
{
  /**
   * @Security("is_granted('ROLE_PRICER')")
  */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $prices = $em->getRepository('AdminBundle:Price')->findAll();

        return $this->render('AdminBundle:price:index.html.twig', array(
            'prices' => $prices,
        ));
    }

  /**
   * @Security("is_granted('ROLE_PRICER')")
  */
    public function newAction(Request $request)
    {
        $price = new Price();
        $form = $this->createForm('Pwm\AdminBundle\Form\PriceType', $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($price);
            $em->flush();
           $this->addFlash('success', 'Enrégistrement effectué');
            return $this->redirectToRoute('price_show', array('id' => $price->getId()));
        }elseif($form->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('AdminBundle:price:new.html.twig', array(
            'price' => $price,
            'form' => $form->createView(),
        ));
    }

  /**
   * @Security("is_granted('ROLE_PRICER')")
  */
    public function showAction(Price $price)
    {
        $deleteForm = $this->createDeleteForm($price);

        return $this->render('AdminBundle:price:show.html.twig', array(
            'price' => $price,
            'delete_form' => $deleteForm->createView(),
        ));
    }

  /**
   * @Security("is_granted('ROLE_PRICER')")
  */
    public function editAction(Request $request, Price $price)
    {
        $deleteForm = $this->createDeleteForm($price);
        $editForm = $this->createForm('Pwm\AdminBundle\Form\PriceType', $price);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
             $this->addFlash('success', 'Modifications  enrégistrées avec succès.');
            return $this->redirectToRoute('price_edit', array('id' => $price->getId()));
        }elseif($editForm->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('AdminBundle:price:edit.html.twig', array(
            'price' => $price,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

  /**
   * @Security("is_granted('ROLE_PRICER')")
  */
    public function deleteAction(Request $request, Price $price)
    {
        $form = $this->createDeleteForm($price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($price);
            $em->flush();
            $this->addFlash('success', 'Supprimé.');
        }

        return $this->redirectToRoute('price_index');
    }

    /**
     * Creates a form to delete a price entity.
     *
     * @param Price $price The price entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Price $price)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('price_delete', array('id' => $price->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
