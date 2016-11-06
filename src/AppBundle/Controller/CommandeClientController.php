<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CommandeClient;
use AppBundle\Entity\Journee;
use AppBundle\Entity\Client;
use AppBundle\Entity\PointVente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
/**
 * Commandeclient controller.
 *
 */
class CommandeClientController extends Controller
{
    /**
     * Lists all commandeClient entities.
     *
     */
    public function indexAction(Request $request, Client $client=null)
    {
        $nomPointVente=$request->query->get("nom");
        $em = $this->getDoctrine()->getManager();
        $commandeClients = $em->getRepository('AppBundle:CommandeClient')->findCommandeByDate($client, $nomPointVente);
        
        $data=array();
        foreach ($commandeClients as $key=> $commandeClient) {
              
               $data[]=$commandeClient->jsonSerialize();
                
          }

         $response = new JsonResponse(['data'=>$data], 200);

        $response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response; 
    }

    /**
     * Creates a new commandeClient entity.
     */
    public function newAction(Request $request,PointVente $pointVente, Client $user)
    {
        $commandeClient = new CommandeClient();
        $serializer = new Serializer(
         array(new GetSetMethodNormalizer(), new ArrayDenormalizer()),
         array(new JsonEncoder())
       );       
        $content = $request->getContent();
        if (!empty($content)){  
             try{
           $em = $this->getDoctrine()->getManager();                   
           $data =json_decode($content, true); // 2nd param to get as array  
           $commandesProduit = $serializer->deserialize($content, 'AppBundle\Entity\CommandeProduit[]', 'json'); 
           $dateObject = new \DateTime();             
            foreach ($commandesProduit as $commandeProduit) {           
             $produit = $em->getRepository('AppBundle:Produit')->find(array('id' => $commandeProduit->getProduitId()));
             $commandeProduit->setDateSave($dateObject)->setProduit($produit);
             $commandeClient->addCommandesProduit( $commandeProduit)->setStatus('ouverte');           
            }
         $commandeClient->setPointVente($pointVente)->setDate($dateObject)->setUser($user); ;  
         $em->persist($commandeClient);
         $em->flush();
         $response = new JsonResponse(['success' => true], 200);
         $response->headers->set('Content-Type', 'application/json');
         return $response;
          } catch(Exception $e) {
             $response = new JsonResponse(['success' => false], 500);
             $response->headers->set('Content-Type', 'application/json');
         return $response;
         }                 
        }   
        $response = new JsonResponse(array('action' => 'goToNewPage' ), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Finds and displays a commandeClient entity.
     *
     */
    public function showAction(CommandeClient $commandeClient)
    {
      $commandeProduits = $em->getRepository('AppBundle:CommandeProduit')->findByCommande($commandeClient);
        $response = new JsonResponse(array("commandeClient"=>$commandeClient,"commandesProduit"=>$commandeProduits), 200);
        $response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;   
    }
    /**
     * Displays a form to edit an existing commandeClient entity.
     *
     */
    public function editAction(Request $request, CommandeClient $commandeClient)
    {
        $deleteForm = $this->createDeleteForm($commandeClient);
        $editForm = $this->createForm('AppBundle\Form\CommandeClientType', $commandeClient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commandeclient_edit', array('id' => $commandeClient->getId()));
        }

        return $this->render('commandeclient/edit.html.twig', array(
            'commandeClient' => $commandeClient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commandeClient entity.
     *
     */
    public function deleteAction(Request $request, CommandeClient $commandeClient)
    {
        try{  
            $em = $this->getDoctrine()->getManager();
            $em->remove($commandeClient);
            $em->flush($commandeClient);

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
     * Creates a form to delete a commandeClient entity.
     *
     * @param CommandeClient $commandeClient The commandeClient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CommandeClient $commandeClient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commandeclient_delete', array('id' => $commandeClient->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
