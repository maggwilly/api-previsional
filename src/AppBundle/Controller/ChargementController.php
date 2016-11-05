<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Chargement;
use AppBundle\Entity\Client;
use AppBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
/**
 * Chargement controller.
 *
 */
class ChargementController extends Controller
{
    /**
     * Lists all chargement entities.
     *
     */

    public function indexAction(Client $client=null, $dateSave=null)
    {
        $em = $this->getDoctrine()->getManager();
        $chargements = $em->getRepository('AppBundle:Chargement')->findByUser($client,$dateSave); // a terminer
         $response = new JsonResponse($chargements, 200);
         $response->headers->set('Content-Type', 'application/json');
		 $response->headers->set('Access-Control-Allow-Origin', '*');
         return $response;   
    }
  

    public function newAction(Request $request, Client $user, Produit $produit)
    {     
        $chargement = new Chargement();
        $normalizer = new ObjectNormalizer(); 
         $dateObject = new \DateTime();
         $content = $request->getContent();
        if (!empty($content)){
           $data = json_decode($content, true); 
           $em = $this->getDoctrine()->getManager();                  
            $chargement= $normalizer->denormalize($data, 'AppBundle\Entity\Chargement');
            $dateObject = new \DateTime();
            $chargement->setDateSave($dateObject)->setUser($user)->setProduit($produit);   
            $em->persist($chargement);
            $em->flush();
            $response = new JsonResponse(['success' => true,'data' => $data], 200);
            $response->headers->set('Content-Type', 'application/json');
		    $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
          }
        $response = new JsonResponse(array('action' => 'goToNewPage' ), 200);
        $response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }

    /**
     * Finds and displays a chargement entity.
     *
     */
    public function showAction(Chargement $chargement)
    {
        $deleteForm = $this->createDeleteForm($chargement);

        return $this->render('chargement/show.html.twig', array(
            'chargement' => $chargement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing chargement entity.
     *
     */
    public function editAction(Request $request, Chargement $chargement)
    {
        $normalizer = new ObjectNormalizer();       
        $content = $request->getContent();
        if (!empty($content)){
          $data = json_decode($content, true);                    
         $chargement= $normalizer->denormalize($data, 'AppBundle\Entity\Chargement');
         $em = $this->getDoctrine()->getManager();
         $em->persist($chargement);
         $em->flush($chargement);
           $response = new JsonResponse(['success' => true,'chargement' => $chargement], 200);
           $response->headers->set('Content-Type', 'application/json');
           $response->headers->set('Access-Control-Allow-Origin', '*');
          return $response;         
        }    
        $response = new JsonResponse(array('action' => 'goToEditPage','chargement' => $chargement), 200);
        $response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;  
    }

    /**
     * Deletes a chargement entity.
     *
     */
    public function deleteAction(Request $request, Chargement $chargement)
    {       
            try{  
            $em = $this->getDoctrine()->getManager();
            $em->remove($chargement);
            $em->flush($chargement);

             } catch(Exception $e){
               $response = new JsonResponse(['success' => false], 500);
               $response->headers->set('Content-Type', 'application/json');
			   $response->headers->set('Access-Control-Allow-Origin', '*');
         return $response;     
      } 

          $response = new JsonResponse(['success' => true], 200);
          $response->headers->set('Content-Type', 'application/json');
          return $response;  
    }

    /**
     * Creates a form to delete a chargement entity.
     *
     * @param Chargement $chargement The chargement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Chargement $chargement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('chargement_delete', array('id' => $chargement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
