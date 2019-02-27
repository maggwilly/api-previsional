<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View;
use AppBundle\Entity\PointVente; 
/**
 * Produit controller.
 *
 */
class ProduitController extends Controller
{
    /**
     * Lists all produit entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('AppBundle:Produit')->findByUser($this->getUser());
        return $this->render('produit/index.html.twig', array(
            'produits' => $produits,
        ));
    }


    /**
     * @Rest\View(serializerGroups={"produit"})
     * 
     */
    public function indexJsonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $order=$request->query->get('order');
        $start=$request->query->get('start');
        $user=$this->getMobileUser($request);
        $produits = $em->getRepository('AppBundle:Produit')->findByUser($user->getParent(),$start);
        return $produits;
    }



    /**
     * Creates a new produit entity.
     *
     */
    public function newAction(Request $request)
    {
        $user=$this->getUser();
        $produit = new Produit($user);
        $form = $this->createForm('AppBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('produit_show', array('id' => $produit->getId()));
        }

        return $this->render('produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Rest\View(serializerGroups={"full"})
     * 
     */
    public function newAJsonction(Request $request)
    {
        $user=$this->getMobileUser($request);
        $produit = new Produit($user);
        $form = $this->createForm('AppBundle\Form\PointVenteType', $produit);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $produit;
        }

        return  array(
            'status' => 'error');
    }
    /**
     * Finds and displays a produit entity.
     *
     */
    public function showAction(Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        return $this->render('produit/show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     */
    public function editAction(Request $request, Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('AppBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_edit', array('id' => $produit->getId()));
        }

        return $this->render('produit/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     */
    public function deleteAction(Request $request, Produit $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produit_index');
    }

    public function deleteJsonAction(Request $request, Produit $produit)
    {
         $em = $this->getDoctrine()->getManager();    
       try {
          $em->remove($produit);
          $em->flush();
        } catch (\Exception $e) {
       return array('status' => "error" );
     }

        return array('status' => "ok" );
    }
    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produit_delete', array('id' => $produit->getId())))
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
