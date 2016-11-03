<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Journee;
use AppBundle\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * Journee controller.
 *
 */
class JourneeController extends Controller
{
    /**
     * Lists all journee entities.
     *
     */
    public function indexAction(Client $user=null,$date=null)
    {
        $em = $this->getDoctrine()->getManager();
        $journees = $em->getRepository('AppBundle:Journee')->findByUser($user,$date);
        $response = new JsonResponse( $journees , 200);
         $response->headers->set('Content-Type', 'application/json');
        return $response; 
    }

    /**
     * Creates a new journee entity.
     *
     */
    public function newAction(Request $request,Client $user=null)
    {       
      $normalizer = new ObjectNormalizer();       
       $content = $request->getContent();
          try{      
         $data = json_decode($content, true); 
         $em = $this->getDoctrine()->getManager();                  
          $journee= $normalizer->denormalize($data, 'AppBundle\Entity\Journee');
          $dateObject = new \DateTime();
          $date = $dateObject->format('Y-m-d');          
           $journee= $em->getRepository('AppBundle:Journee')->findToday($user);
           if (is_null($journee)) {
            $journee = new Journee();
            $journee->setDate(\DateTime::createFromFormat('Y-m-d',$date))->setDebut($dateObject)->setUser($user);
             $em->persist($journee);
             $em->flush();
           }          
                         
        } catch(Exception $e){
             $response = new JsonResponse(array('success' => false), 500);
             $response->headers->set('Content-Type', 'application/json');
            return $response;     
           }  
          $response = new JsonResponse(array('success' => true), 200);
           $response->headers->set('Content-Type', 'application/json');
          return $response;     
}

    /**
     * Finds and displays a journee entity.
     *
     */
    public function showAction(Journee $journee)
    {
        $deleteForm = $this->createDeleteForm($journee);

        return $this->render('journee/show.html.twig', array(
            'journee' => $journee,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing journee entity.
     *
     */
    public function editAction(Request $request, Journee $journee)
    {
        $deleteForm = $this->createDeleteForm($journee);
        $editForm = $this->createForm('AppBundle\Form\JourneeType', $journee);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('journee_edit', array('id' => $journee->getId()));
        }

        return $this->render('journee/edit.html.twig', array(
            'journee' => $journee,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a journee entity.
     *
     */
    public function deleteAction(Request $request, Journee $journee)
    {
        $form = $this->createDeleteForm($journee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($journee);
            $em->flush($journee);
        }

        return $this->redirectToRoute('journee_index');
    }

    /**
     * Creates a form to delete a journee entity.
     *
     * @param Journee $journee The journee entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Journee $journee)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('journee_delete', array('id' => $journee->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
