<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Client;
use AppBundle\Entity\Image;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
/**
 * Client controller.
 *
 */
class ClientController extends Controller
{

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository('AppBundle:Client')->findUsers();
        $response = new JsonResponse($clients, 200);
        $response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;     
    }

    /**
     * Creates a new client entity.
     *
     */

    public function newAction(Request $request)
    {
        $client = new Client();     
        $normalizer = new ObjectNormalizer();       
        $content = $request->getContent();
        if (!empty($content)){
         $data = json_decode($content, true);               
         $client= $normalizer->denormalize($data, 'AppBundle\Entity\Client');
         $em = $this->getDoctrine()->getManager();

         $client->setEnabled(true)->setRoles(array("ROLE_USER"));
         $em->persist($client);
         $em->flush($client);
           $response = new JsonResponse(['success' => true], 200);
           $response->headers->set('Content-Type', 'application/json');
		   $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;         
        }
        $response = new JsonResponse(array('action' => 'goToNewPage','client'=>$content ), 200);
        $response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }


   /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newSuperAction(Request $request)
    {
        $client = new Client();     
        $normalizer = new ObjectNormalizer();       
       $content = $request->getContent();
        if (!empty($content)){
          $data = json_decode($content, true);                    
          $client= $normalizer->denormalize($data, 'AppBundle\Entity\Client');
           $client->setEnabled(true)->setRoles(array("ROLE_RESTAURATEUR"));
           $em = $this->getDoctrine()->getManager();
           $em->persist($client);
           $em->flush($client);
           $response = new JsonResponse(['success' => true], 200);
           $response->headers->set('Content-Type', 'application/json');
		   $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;         
        }

        $response = new JsonResponse(array('action' => 'goToNewPage','client'=>$client ), 200);
        $response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function showAction(Client $client)
    {
        $deleteForm = $this->createDeleteForm($client);
        $response = new JsonResponse($client, 200);
        $response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;            
    }

    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function editAction(Request $request, Client $client)
    {   
        $normalizer = new ObjectNormalizer();       
       $content = $request->getContent();
        if (!empty($content)){
         $data = json_decode($content, true); 
         $file = $this->getRequest()->files->get('image');                    
         $client= $normalizer->denormalize($data, 'AppBundle\Entity\Client');
          $image= $client->getImage();
          $image->setFile($file);
          $em = $this->getDoctrine()->getManager();
          $em->persist($client);
          $em->flush($client);
           $response = new JsonResponse(['success' => true, array('id' => $client->getId())], 200);
           $response->headers->set('Content-Type', 'application/json');
		   $response->headers->set('Access-Control-Allow-Origin', '*');
          return $response;         
        }    
        $response = new JsonResponse(array('action' => 'goToEditPage','client' => $client), 200);
        $response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;          
    }


    /**
     * @Security("has_role('ROLE_USER')")
     */
    public function changePasswordAction(Request $request, Client $client)
    {   
        $normalizer = new ObjectNormalizer();       
        $content = $request->getContent();
        if (!empty($content)){
         $data = json_decode($content, true);     
         $client= $normalizer->denormalize($data, 'AppBundle\Entity\Client');
         $client->setNom("Serveur")->setPsasseword("restomobile");
          $em = $this->getDoctrine()->getManager();
          $em->persist($client);
          $em->flush($client);
          $response = new JsonResponse(['success' => true, array('id' => $client->getId())], 200);
          $response->headers->set('Content-Type', 'application/json');
		  $response->headers->set('Access-Control-Allow-Origin', '*');
          return $response;         
        }    
        $response = new JsonResponse(array('action' => 'goToChangePassewordPage','client' => $client), 200);
        $response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;          
    }
    

    /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Client $client)
    {
        if ($request->getMethod()=="DELETE") {
            $em = $this->getDoctrine()->getManager();
            $client->setEnabled(false);
            $em->persist($client);
            $em->flush($client);
            $response = new JsonResponse(['success' => true], 200);
            $response->headers->set('Content-Type', 'application/json');
			$response->headers->set('Access-Control-Allow-Origin', '*');
          return $response;     
         }
        $response = new JsonResponse(['success' => false], 401);
        $response->headers->set('Content-Type', 'application/json');
		$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
       
    }

    /**
     * Creates a form to delete a client entity.
     *
     * @param Client $client The client entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Client $client)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $client->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
