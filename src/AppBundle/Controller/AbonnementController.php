<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Commande;
use AppBundle\Entity\Abonnement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Abonnement controller.
 *
 */
class AbonnementController extends Controller
{

  /**
   * @Security("is_granted('ROLE_DELEGUE')")
  */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $abonnements = $em->getRepository('AdminBundle:Abonnement')->findList();
         $extrats = $em->getRepository('AdminBundle:Abonnement')->findSinceDate();
        $concours = $em->getRepository('AppBundle:Session')->findList();
        return $this->render('AdminBundle:abonnement:index.html.twig', array(
            'abonnements' => $abonnements, 'concours' => $concours,
        ));
    }


 
    
    /**
     * Lists all Produit entities.
     *@Rest\View()
     */
    public function tokenAction()
    {
    $res=$this->get('payment_service')->getToken();
     return  $res;
}


    /**
     * @Rest\View()
     * 
     */
    public function initAction(Request $request)
    {
              $user=$this->getUser();
              $em = $this->getDoctrine()->getManager();
               $commande= new Commande($user);
              $form = $this->createForm('AppBundle\Form\CommandeType', $commande);
              $form->submit($request->request->all());              
                if ($form->isValid()) {
                   $em->persist($commande);
                   $em->flush(); 
                   $res=$this->get('payment_service')->getPaimentCredentials($commande);
                   $res['duree']=$commande->getDuree();
                    $res['cmd']=$commande->getId();
                 return $res; // $this->redirect($res['payment_url']);
              }
         return array('error' => true );
    }






    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"abonnement"})
     */
    public function confirmAction(Request $request,Commande $commande)
    {
         $form = $this->createForm('AppBundle\Form\CommandeType', $commande);
         $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $abonnement=$commande->getUser()->getAbonnement();
            if($abonnement==null){
                 $abonnement=new Abonnement($commande->getUser(),$commande->getDuree()); 
                 $em->persist($abonnement);
                }
              $abonnement->setUser($commande->getUser())
                        ->setDuree($commande->getDuree())
                        ->setNombreusers($commande->getPrice()->getNombreusers());
              $commande->setAbonnement($abonnement); 
              $em->flush();
            return $abonnement;
        }
        return $form;
    }


    /**
     * Lists all Produit entities.
     *@Rest\View()
     */
    public function cancelAction(Request $request,Commande $commande)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush($commande);
        return  array('success'=>true);
    }



        /**
     * Displays a form to edit an existing analyse entity.
     *
     */
    public function editAction(Request $request, Abonnement $abonnement)
    {
        $form = $this->createForm('Pwm\AdminBundle\Form\AbonnementType', $abonnement);
         $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $abonnement;
        }
        return $form;
    }



        /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"commande"})
     */
    public function showJsonAction(Commande $commande){
        return $commande;
    }



    public function showAction(Abonnement $abonnement)
    {
        $deleteForm = $this->createDeleteForm($abonnement);
        return $this->render('AdminBundle:abonnement:show.html.twig', array(
            'abonnement' => $abonnement,
            'delete_form' => $deleteForm->createView(),
        ));
    }



    public function deleteAction(Request $request, Abonnement $abonnement)
    {
        $form = $this->createDeleteForm($abonnement);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($abonnement);
            $em->flush($abonnement);
        }

        return $this->redirectToRoute('abonnement_index');
    }

    /**
     * Creates a form to delete a abonnement entity.
     *
     * @param Abonnement $abonnement The abonnement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Abonnement $abonnement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('abonnement_delete', array('id' => $abonnement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

public function getMobileUser(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
          $user = $em->getRepository('AppBundle:User')->findOneById($request->headers->get('X-User-Id'));
        return $user;
    } 
   
}
