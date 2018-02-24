<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Resultat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
use Symfony\Component\HttpFoundation\Response;
/**
 * Resultat controller.
 *
 */
class ResultatController extends Controller
{
    /**
     * Lists all resultat entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $resultats = $em->getRepository('AppBundle:Resultat')->findAll();

        return $this->render('resultat/index.html.twig', array(
            'resultats' => $resultats,
        ));
    }
        /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"resultat"})
     */
     public function jsonIndexAction(Request $request)
     {
        $all=$request->query->get('all');
        $start=$request->query->get('start');
         $em = $this->getDoctrine()->getManager();
          $resultats =$em->getRepository('AppBundle:Resultat')->findList($start,$all);
         return  $resultats;
     }

    /**
     * Creates a new resultat entity.
     *
     */
    public function newAction(Request $request)
    {
        $resultat = new Resultat();
        $form = $this->createForm('AppBundle\Form\ResultatType', $resultat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resultat);
            $em->flush();
           $registrations = $em->getRepository('MessagerBundle:Registration')->findAll(); 
            $registrationIds=array();
            foreach ($registrations as $registration) {
                $registrationIds[]=$registration->getRegistrationId();
                }
            return return $this->firebaseSend($registrationIds, $resultat); //$this->redirectToRoute('resultat_show', array('id' => $resultat->getId()));
        }
        return $this->render('resultat/new.html.twig', array(
            'resultat' => $resultat,
            'form' => $form->createView(),
        ));
    }


public function firebaseSend($registrationIds,Resultat $resultat ){

$data=array(
        'registration_ids' => array_values($registrationIds),
        'title' => 'Resultat disponible',
        'body' => $resultat->getDescription(),
        'badge' => 1,
        'tag' => 'confirm',
        'priority' => 'high',
        'data' => array(
               'action' => "new_message"
        )
    );

     $fmc_response= $this->get('fmc_manager')->sendMessage($data,false);
  return new Response($fmc_response);
}

    /**
     * Finds and displays a resultat entity.
     *
     */
    public function showAction(Resultat $resultat)
    {
        $deleteForm = $this->createDeleteForm($resultat);

        return $this->render('resultat/show.html.twig', array(
            'resultat' => $resultat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

        /**
     * Finds and displays a resultat entity.
     *
     */
    public function getAction(Resultat $resultat)
    {
        $deleteForm = $this->createDeleteForm($resultat);

        return $this->redirect($resultat->getUrl());
    }

    /**
     * Displays a form to edit an existing resultat entity.
     *
     */
    public function editAction(Request $request, Resultat $resultat)
    {
        $deleteForm = $this->createDeleteForm($resultat);
        $editForm = $this->createForm('AppBundle\Form\ResultatType', $resultat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resultat_edit', array('id' => $resultat->getId()));
        }

        return $this->render('resultat/edit.html.twig', array(
            'resultat' => $resultat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a resultat entity.
     *
     */
    public function deleteAction(Request $request, Resultat $resultat)
    {
        $form = $this->createDeleteForm($resultat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($resultat);
            $em->flush();
        }

        return $this->redirectToRoute('resultat_index');
    }

    /**
     * Creates a form to delete a resultat entity.
     *
     * @param Resultat $resultat The resultat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Resultat $resultat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('resultat_delete', array('id' => $resultat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
