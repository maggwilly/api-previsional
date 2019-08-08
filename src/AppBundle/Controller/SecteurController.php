<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Secteur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View;
/**
 * Secteur controller.
 *
 */
class SecteurController extends Controller
{
    /**
     * Lists all secteur entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $secteurs = $em->getRepository('AppBundle:Secteur')->findAll();

        return $this->render('secteur/index.html.twig', array(
            'secteurs' => $secteurs,
        ));
    }


    /**
     * @Rest\View(serializerGroups={"secteur"})
     * 
     */
    public function indexJsonAction(Request $request)
    {
         $keys=$request->request->get('keys');
         if (count_chars($keys)>0) {
            $keys=explode(".", $keys);
         }else $keys=[];
          $user=$this->getUser();
          $em = $this->getDoctrine()->getManager();
        $secteurs = $em->getRepository('AppBundle:Secteur')->findByUser($user->getParent(),null,null,$keys);
        return $secteurs;
    }


    /**
     * Creates a new secteur entity.
     *
     */
    public function newAction(Request $request)
    {
        $user=$this->getUser();
        $secteur = new Secteur($user);
        $form = $this->createForm('AppBundle\Form\SecteurType', $secteur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($secteur);
            $em->flush();
            return $this->redirectToRoute('secteur_show', array('id' => $secteur->getId()));
        }

        return $this->render('secteur/new.html.twig', array(
            'secteur' => $secteur,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Rest\View(serializerGroups={"secteur"})
     * 
     */
     public function newJsonAction(Request $request)
    {
        $user=$this->getUser();
        $secteur = new Secteur($user);
        $form = $this->createForm('AppBundle\Form\SecteurType', $secteur);
        $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($em->getRepository('AppBundle:Secteur')->find($secteur->getId())==null) {
                 $em->persist($secteur);
            }            

            $em->flush();

            return $secteur;
        }

        return array('error' => true );
    }
    

    /**
     * Finds and displays a secteur entity.
     *
     */
    public function showAction(Secteur $secteur)
    {
        $deleteForm = $this->createDeleteForm($secteur);

        return $this->render('secteur/show.html.twig', array(
            'secteur' => $secteur,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * @Rest\View(serializerGroups={"secteur"})
     * 
     */
    public function editJsonAction(Request $request, Secteur $secteur)
    {
        $editForm = $this->createForm('AppBundle\Form\SecteurType', $secteur);
        $alls=$request->request->all();
        unset($alls['id']);
        $editForm->submit($alls,false);
        if ( $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $secteur;
        }
        return array( 'status' => 'error');
    }
    

    /**
     * Displays a form to edit an existing secteur entity.
     *
     */
    public function editAction(Request $request, Secteur $secteur)
    {
        $deleteForm = $this->createDeleteForm($secteur);
        $editForm = $this->createForm('AppBundle\Form\SecteurType', $secteur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('secteur_edit', array('id' => $secteur->getId()));
        }
        return $this->render('secteur/edit.html.twig', array(
            'secteur' => $secteur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a secteur entity.
     *
     */
    public function deleteAction(Request $request, Secteur $secteur)
    {
        $form = $this->createDeleteForm($secteur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($secteur);
            $em->flush();
        }
        return $this->redirectToRoute('secteur_index');
    }

    /**
     * @Rest\View()
     * 
     */
    public function deleteJsonAction(Request $request, Secteur $secteur)
    {
         $id=$secteur->getId();
         $em = $this->getDoctrine()->getManager();    
       try {
          $em->remove($secteur);
          $em->flush();
        } catch (\Exception $e) {
       return array('error' => true );
     }

        return array('ok' => true,'deletedId' => $id );
    }

    /**
     * Creates a form to delete a secteur entity.
     *
     * @param Secteur $secteur The secteur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Secteur $secteur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('secteur_delete', array('id' => $secteur->getId())))
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
