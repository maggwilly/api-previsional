<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Price;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View;
/**
 * Price controller.
 *
 */
class PriceController extends Controller
{
    /**
     * Lists all price entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $prices = $em->getRepository('AppBundle:Price')->findAll();

        return $this->render('price/index.html.twig', array(
            'prices' => $prices,
        ));
    }

    /**
     * Creates a new price entity.
     *
     */
    public function newAction(Request $request)
    {
        $price = new Price();
        $form = $this->createForm('AppBundle\Form\PriceType', $price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($price);
            $em->flush();

            return $this->redirectToRoute('price_show', array('id' => $price->getId()));
        }

        return $this->render('price/new.html.twig', array(
            'price' => $price,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a price entity.
     *
     */
    public function showAction(Price $price)
    {
        $deleteForm = $this->createDeleteForm($price);

        return $this->render('price/show.html.twig', array(
            'price' => $price,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * @Rest\View(serializerGroups={"price"})
     * 
     */
    public function showJsonAction(Price $price)
    {
        return $price;
    }

    /**
     * @Rest\View(serializerGroups={"price"})
     * 
     */
    public function indexJsonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $prices = $em->getRepository('AppBundle:Price')->findAll();
        return $prices;
    }
    /**
     * Displays a form to edit an existing price entity.
     *
     */
    public function editAction(Request $request, Price $price)
    {
        $deleteForm = $this->createDeleteForm($price);
        $editForm = $this->createForm('AppBundle\Form\PriceType', $price);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('price_edit', array('id' => $price->getId()));
        }

        return $this->render('price/edit.html.twig', array(
            'price' => $price,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a price entity.
     *
     */
    public function deleteAction(Request $request, Price $price)
    {
        $form = $this->createDeleteForm($price);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($price);
            $em->flush();
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

        public function getMobileUser(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
          $user = $em->getRepository('AppBundle:User')->findOneById($request->headers->get('X-User-Id'));
        return $user;
    }  
}
