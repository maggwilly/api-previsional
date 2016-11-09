<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PointVente;
use AppBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
/**
 * Pointvente controller.
 *
 */

class PointVenteController extends Controller
{
    /**
     * Lists all pointVente entities.
     *
     */

    public function indexAction(Request $request)
    {
         $nom=$request->query->all()["nom"];
        $em = $this->getDoctrine()->getManager();
        $pointVentes = $em->getRepository('AppBundle:PointVente')->findByNom($nom);
        $response = new JsonResponse(['data'=>$pointVentes], 200);
        $response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;  
    }

    /**
     * Creates a new pointVente entity.
     *
     */
    public function newAction(Request $request, Client $client)
    {
         $pointvente = new Pointvente();
       $normalizer = new ObjectNormalizer();       
       $content = $request->getContent();
        if (!empty($content)){
            try{
         $data = json_decode($content, true); 
         $em = $this->getDoctrine()->getManager();                  
        $pointvente= $normalizer->denormalize($data, 'AppBundle\Entity\Pointvente'); 
         $pointvente->setUser($client)  ;      
        $em->persist($pointvente);
        $em->flush($pointvente);
         $response = new JsonResponse(['success' => true], 200);
         $response->headers->set('Content-Type', 'application/json');
		 $response->headers->set('Access-Control-Allow-Origin', '*');
         return $response; 
         } catch(UniqueConstraintViolationException $e) {
          $response = new JsonResponse(['success' => false], 500);
         $response->headers->set('Content-Type', 'application/json');
		 $response->headers->set('Access-Control-Allow-Origin', '*');
         return $response;
         }        
        }
       
        $response = new JsonResponse(array('action' => 'goToNewPage' ), 200);
		$response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Finds and displays a pointVente entity.
     *
     */
    public function showAction(PointVente $pointVente)
    {
        $deleteForm = $this->createDeleteForm($pointVente);

        return $this->render('pointvente/show.html.twig', array(
            'pointVente' => $pointVente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pointVente entity.
     *
     */
    public function editAction(Request $request, PointVente $pointVente)
    {
        $normalizer = new ObjectNormalizer();       
        $content = $request->getContent();
        if (!empty($content)){
          $data = json_decode($content, true);                   
         $pointVente= $normalizer->denormalize($data, 'AppBundle\Entity\PointVente');
         $em = $this->getDoctrine()->getManager();
         $em->persist($pointVente);
         $em->flush($pointVente);
           $response = new JsonResponse(['success' => true,'pointVente' => $pointVente], 200);
           $response->headers->set('Content-Type', 'application/json');
		   $response->headers->set('Access-Control-Allow-Origin', '*');
          return $response;         
        } 
          $response->headers->set('Access-Control-Allow-Origin', '*');		
        $response = new JsonResponse(array('action' => 'goToEditPage','pointVente' => $pointVente), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;  
    }

    /**
     * Deletes a pointVente entity.
     *
     */
    public function deleteAction(Request $request, PointVente $pointVente)
    {      
            try{  
            $em = $this->getDoctrine()->getManager();
            $em->remove($pointVente);
            $em->flush($pointVente);

             } catch(Exception $e){
               $response = new JsonResponse(['success' => false], 500);
               $response->headers->set('Content-Type', 'application/json');
			   $response->headers->set('Access-Control-Allow-Origin', '*');
         return $response;     
      } 
          $response->headers->set('Access-Control-Allow-Origin', '*');
          $response = new JsonResponse(['success' => true], 200);
          $response->headers->set('Content-Type', 'application/json');
          return $response;  
    }

    /**
     * Creates a form to delete a pointVente entity.
     *
     * @param PointVente $pointVente The pointVente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PointVente $pointVente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pointvente_delete', array('id' => $pointVente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
