<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Chargement;
use AppBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
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
         return $response;   
    }
  
    public function newAction(Request $request, Client $user)
    {
       
        $serializer = new Serializer(
         array(new GetSetMethodNormalizer(), new ArrayDenormalizer()),
         array(new JsonEncoder())
       ); 
         $content = $request->getContent();
        if (!empty($content)){
            $em = $this->getDoctrine()->getManager();
            try{                       
           $data =json_decode($content, true); // 2nd param to get as array  
           $chargements = $serializer->deserialize($content, 'AppBundle\Entity\Chargement[]', 'json');   

            foreach ($chargements as $chargement) {           
             $produit = $em->getRepository('AppBundle:Produit')->find(array('id' => $chargement->getProduitId()));
             $chargement->setUser($user)->setDateSave(new \DateTime())->setProduit($produit);
             $em->persist($chargement);
            }
           $em->flush();
           $response = new JsonResponse(['success' => true,'data' => $data], 200);
           $response->headers->set('Content-Type', 'application/json');
           return $response;
            } catch(Exception $e){
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
          return $response;         
        }    
        $response = new JsonResponse(array('action' => 'goToEditPage','chargement' => $chargement), 200);
        $response->headers->set('Content-Type', 'application/json');
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
