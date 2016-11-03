<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CommandeProduit;
use AppBundle\Entity\CommandeClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * Commandeproduit controller.
 *
 */
class CommandeProduitController extends Controller
{
    /**
     * Lists all commandeProduit entities.
     *
     */
    public function indexAction(CommandeClient $commandeClient=null)
    {
        $em = $this->getDoctrine()->getManager();
        $commandeProduits = $em->getRepository('AppBundle:CommandeProduit')->findByCommande($commandeClient);
        $response = new JsonResponse($commandeProduits, 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response; 
    }

    /**
     * Creates a new commandeProduit entity.
     *
     */
    public function newAction(Request $request)
    {
        $commandeProduit = new Commandeproduit();
        $form = $this->createForm('AppBundle\Form\CommandeProduitType', $commandeProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commandeProduit);
            $em->flush($commandeProduit);

            return $this->redirectToRoute('commandeproduit_show', array('id' => $commandeProduit->getId()));
        }

        return $this->render('commandeproduit/new.html.twig', array(
            'commandeProduit' => $commandeProduit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commandeProduit entity.
     *
     */
    public function showAction(CommandeProduit $commandeProduit)
    {
        $deleteForm = $this->createDeleteForm($commandeProduit);

        return $this->render('commandeproduit/show.html.twig', array(
            'commandeProduit' => $commandeProduit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commandeProduit entity.
     *
     */
    public function editAction(Request $request, CommandeProduit $commandeProduit)
    {
        $deleteForm = $this->createDeleteForm($commandeProduit);
        $editForm = $this->createForm('AppBundle\Form\CommandeProduitType', $commandeProduit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commandeproduit_edit', array('id' => $commandeProduit->getId()));
        }

        return $this->render('commandeproduit/edit.html.twig', array(
            'commandeProduit' => $commandeProduit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commandeProduit entity.
     *
     */
    public function deleteAction(Request $request, CommandeProduit $commandeProduit)
    {
        try{  
            $em = $this->getDoctrine()->getManager();
            $em->remove($commandeProduit);
            $em->flush($commandeProduit);

             } catch(Exception $e){
               $response = new JsonResponse(['success' => false], 500);
               $response->headers->set('Content-Type', 'application/json');
         return $response;     
      } 
          $response = new JsonResponse(['success' => true], 200);
          $response->headers->set('Content-Type', 'application/json');
          return $response;  
    }

    /**
     * Creates a form to delete a commandeProduit entity.
     *
     * @param CommandeProduit $commandeProduit The commandeProduit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CommandeProduit $commandeProduit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commandeproduit_delete', array('id' => $commandeProduit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
