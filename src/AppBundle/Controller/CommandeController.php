<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use AppBundle\Entity\Plat;
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
     * @Security("has_role('ROLE_USER')")
     */
    public function newAction(Request $request)
    {
        $commande = new Commande();
        $serializer = new Serializer(
         array(new GetSetMethodNormalizer(), new ArrayDenormalizer()),
         array(new JsonEncoder())
       ); 
         $content = $request->getContent();
        if (!empty($content)){
            $em = $this->getDoctrine()->getManager();
            try{                       
           $data =json_decode($content, true); // 2nd param to get as array  
           $commandes = $serializer->deserialize($content, 'AppBundle\Entity\Commande[]', 'json');   

            foreach ($commandes as $commande) {
            
             $plat = $em->getRepository('AppBundle:Plat')->find(array('id' => $commande->getPlatId()));
             $commande->setClient($this->getUser())->setDateSave(new \DateTime())->setPlat($plat);
           if (!$commande->isACettePosition()) {               
                $commande->setPlace(null);
               }        
            for ($i=0; $i < $commande->getNombrePlat(); $i++) { 
                $copy = clone $commande;
                $copy->setNombrePlat(1);
                $em->persist($copy);
              } 
            }
           $em->flush();
           $response = new JsonResponse(['success' => true,$data], 200);
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
     * @Security("has_role('ROLE_RESTAURATEUR')")
     */
    public function newSuperAction(Request $request)
    {
        $commande = new Commande();
       $normalizer = new ObjectNormalizer();   
         $content = $request->getContent();
        if (!empty($content))
           {
            $em = $this->getDoctrine()->getManager();
                   try{ 
            $data = json_decode($content, true); // 2nd param to get as array
            foreach ($data as $key => $value) {
             $commande= $normalizer->denormalize($data[$key], 'AppBundle\Entity\Commande');
             $plat = $em->getRepository('AppBundle:Plat')->findBy(array('id' => $data[$key]["plat"]));
             $commande->setUser($this->getUser())->setDateSave(new \DateTime())->setPlat($plat);
           if (!$commande->isACettePosition()) {               
                $commande->setPlace(null);
               }        
            for ($i=0; $i < $commande->getNombrePlat(); $i++) { 
                $copy = clone $commande;
                $copy->setNombrePlat(1);
                $em->persist($copy);
              } 
            }
           $em->flush();
           $response = new JsonResponse(['success' => true,$data], 200);
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
