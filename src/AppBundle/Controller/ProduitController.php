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
        $start=$request->request->get('start');
        $keys=$request->query->get('keys');
         if (count_chars($keys)>0) {
              $keys=explode(".", $keys);
         }else $keys=[0];
         $user=$this->getUser();
        $produits = $em->getRepository('AppBundle:Produit')->findByUser($user->getParent(),$start,$keys);
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
     * @Rest\View(serializerGroups={"produit"})
     * 
     */
    public function newJsonAction(Request $request)
    {
        $user=$this->getUser();
        $produit = new Produit($user);
        $form = $this->createForm('AppBundle\Form\ProduitType', $produit);
        $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
           if ($em->getRepository('AppBundle:Produit')->find($produit->getId())==null) {
               $em->persist($produit);
            }
           
            $em->flush();
            return $produit;
        }

        return array('error' => true );
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
     * @Rest\View(serializerGroups={"produit"})
     * 
     */
    public function editJsonAction(Request $request, Produit $produit)
    {
       $user=$this->getUser();
        $form = $this->createForm('AppBundle\Form\ProduitType', $produit);
       $alls=$request->request->all();
        unset($alls['id']);
        $form->submit($alls,false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $produit;
        }

        return  array(
            'status' => 'error');
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

    /**
     * @Rest\View()
     * 
     */
    public function deleteJsonAction(Request $request, Produit $produit)
    {
         $id=$produit->getId();
         $em = $this->getDoctrine()->getManager();    
       try {
          $em->remove($produit);
          $em->flush();
        } catch (\Exception $e) {
       return array('error' => true );
     }

      return array('ok' => true,'deletedId' => $id );
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
 
}
