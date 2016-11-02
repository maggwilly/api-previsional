<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use AppBundle\Entity\Plat;
use AppBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{
    /**
     * Lists all commande entities.
     *
     */
     /**
     * @Security("has_role('ROLE_USER')")
     */
    public function indexAction($status=null)
    {
        $em = $this->getDoctrine()->getManager();
        $commandes = $em->getRepository('AppBundle:Commande')->findCommandeByStatus($status);
        $response = new JsonResponse($commandes, 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;   
    }

    /**
     * Creates a new commande entity.
     *
     */
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $commande = new Commande();
       $normalizer = new ObjectNormalizer();       
      if ( $request->getMethod()=="POST" ) {
         $data = $request->query->all();
         // $em = $this->getDoctrine()->getManager();
       //  foreach ($data as $key => $value) {
       //       $commande= $normalizer->denormalize($data[$key], 'AppBundle\Entity\Commande');
         //     $commande->setPlat($plat)->setClient($client)->setDateSave(new \DateTime());
         //   if (!$commande->isACettePosition()) {
          //      $commande->setLatLocal($client->getLatLocal())
           //     ->setLongLocal($client->getLongLocal())
           //     ->setPlace($client->getPlace());
          //     }
        // if ($commande->getNombrePlat()>1) {
           //  for ($i=1; $i < $commande->getNombrePlat(); $i++) { 
           //       $copy = clone $commande;
            //      $em->persist($copy);
            //  } 
           // }
        //}                    
        
        
        

        // $em->persist($commande);
         //$em->flush($commande);
           $response = new JsonResponse(['success' => true,$data], 200);
           $response->headers->set('Content-Type', 'application/json');
        return $response;         
        }
        $response = new JsonResponse(array('action' => 'goToNewPage' ), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

 /**
     * @Security("has_role('ROLE_RESTAURATEUR')")
     */
    public function newSuperAction(Request $request,Plat $plat,Client $user)
    {
        $commande = new Commande();
       $normalizer = new ObjectNormalizer();       
      if ( $request->getMethod()=="POST" ) {
         $data = $request->query->all();                    
         $commande= $normalizer->denormalize($data, 'AppBundle\Entity\Commande');
         $commande->setPlat($plat)->setUser($user)->setDateSave(new \DateTime());
         $em = $this->getDoctrine()->getManager();  
         if ($commande->getNombrePlat()>1) {
             for ($i=1; $i < $commande->getNombrePlat(); $i++) { 
                  $copy = clone $commande;
                  $em->persist($copy);
              } 
         }

         $em->persist($commande);
         $em->flush($commande);
           $response = new JsonResponse(['success' => true], 200);
           $response->headers->set('Content-Type', 'application/json');
        return $response;         
        }

        $response = new JsonResponse(array('action' => 'goToNewPage' ), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

     /**
     * @Security("has_role('ROLE_USER')")
     */
    public function showAction(Commande $commande)
    {
         $deleteForm = $this->createDeleteForm($commande);
         $response = new JsonResponse($commande, 200);
         $response->headers->set('Content-Type', 'application/json');
        return $response;     
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     */
     /**
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, Commande $commande)
    {          
        $normalizer = new ObjectNormalizer();       
      if ( $request->getMethod()=="POST" ) {
         $data = $request->query->all();                    
         $commande= $normalizer->denormalize($data, 'AppBundle\Entity\Commande');
         $em = $this->getDoctrine()->getManager();
         $em->persist($commande);
         $em->flush($commande);
           $response = new JsonResponse(['success' => true, array('id' => $commande->getId())], 200);
           $response->headers->set('Content-Type', 'application/json');
          return $response;         
        }    
        $response = new JsonResponse(array('action' => 'goToEditPage','commande' => $commande), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;  
    }

    /**
     * Deletes a commande entity.
     *
     */
     /**
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Request $request, Commande $commande)
    {
       if ($request->getMethod()=="DELETE") {
            $em = $this->getDoctrine()->getManager();
             $commande->setStatus("canceled");
            $em->persist($commande);
            $em->flush($commande);
            $response = new JsonResponse(['success' => true], 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;  
        }  
            $response = new JsonResponse(['success' => false], 401);
            $response->headers->set('Content-Type', 'application/json');
            return $response;      
    }

    /**
     * Creates a form to delete a commande entity.
     *
     * @param Commande $commande The commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commande $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
