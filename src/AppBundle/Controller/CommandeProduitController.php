<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CommandeProduit;
use AppBundle\Entity\CommandeClient;
use AppBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use AppBundle\Entity\PointVente;

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
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response; 
    }

    /**
     * Creates a new commandeProduit entity.
     *
     */
    public function newAction(Request $request, Client $user ,PointVente $pointVente)
    {
        $commandeProduit = new Commandeproduit();
        $normalizer = new ObjectNormalizer();      
        $content = $request->getContent();
         if (!empty($content)){
           $data = json_decode($content, true); 
           $em = $this->getDoctrine()->getManager();                  
            $commandeProduit= $normalizer->denormalize($data, 'AppBundle\Entity\CommandeProduit');
            $dateObject = new \DateTime();
            commandeProduit->setDateSave($dateObject);
            $em = $this->getDoctrine()->getManager();
            $commandeOuverte = $em->getRepository('AppBundle:CommandeClientt')->findCommandeOuverte($user,$pointVente);
            if (is_null($commandeOuverte)) {
               $commandeClient = new CommandeClient();
               $commandeClient->setPointVente($pointVente)->setDate($dateObject)->setUser($user); 
              }
            $commandeClient->addCommandesProduit( $commandeProduit);    
            $em->persist($commandeClient);
            $em->flush();
             $response = new JsonResponse(array('action' => 'goToNewPage' ), 200);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
           return $response;
        }

          $response = new JsonResponse(['success' => false], 500);
             $response->headers->set('Content-Type', 'application/json');
             $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response; 
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
			   $response->headers->set('Access-Control-Allow-Origin', '*');
         return $response;     
      } 
          $response = new JsonResponse(['success' => true], 200);
          $response->headers->set('Content-Type', 'application/json');
		  $response->headers->set('Access-Control-Allow-Origin', '*');
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
