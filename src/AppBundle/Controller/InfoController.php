<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Info;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
use AppBundle\Event\InfoEvent;
/**
 * Info controller.
 *
 */
class InfoController extends Controller
{
    /**
     * Lists all info entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $infos = $em->getRepository('AppBundle:Info')->findAll();

        return $this->render('info/index.html.twig', array(
            'infos' => $infos,
        ));
    }

        /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"info"})
     */
    public function editPictureAction(Request $request,  $email)
    {  $em = $this->getDoctrine()->getManager();
        $info = $em->getRepository('AppBundle:Info')->findOneByEmail($email);
          if($info==null){
          $info = new Info($email);
           $em->persist($info);
            $em->flush();
          }
        $form = $this->createForm('AppBundle\Form\InfoType', $info);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();       
       if( $info->upload()){
         $cloudinaryWrapper=$this -> container -> get('misteio_cloudinary_wrapper');
          $results= $cloudinaryWrapper-> upload($info->getPath(), '_user_'.$info->getEmail(),array(), array("crop" => "limit","width" => "150", "height" => "150"))->getResult();
          $info->setPhotoURL($results['url']);
          $em->flush();
          $info->remove();
       }
          return $this->showJsonAction($info);
        }
        return $form;
    }

        /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"info"})
     */
    public function newJsonAction(Request $request, $email)
    {     $em = $this->getDoctrine()->getManager();
         $candidat = $em->getRepository('AppBundle:Info')->findOneByEmail($email);
        if($candidat!=null)
            return $this->editAction($request, $candidat);
            $candidat = new Info($email);
            $form = $this->createForm('AppBundle\Form\InfoType', $candidat);
            $form->submit($request->request->all(),false);
        if ($form->isValid()) {
              $em->persist($candidat);
              $em->flush();
            return $candidat;
        }
        return $form;
    }

    /**
     * Displays a form to edit an existing analyse entity.
     *
     */
    public function editAction(Request $request, Info $info)
    {
        $form = $this->createForm('AppBundle\Form\InfoType', $info);
         $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $info;
        }
        return $form;
    }


    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"info"})
     */
    public function showJsonAction( $email){
         $em = $this->getDoctrine()->getManager();
          $info = $em->getRepository('AppBundle:Info')->findOneByEmail($email);
        return $info;
    }

    /**
     * Finds and displays a info entity.
     *
     */
    public function showAction(Info $info)
    {
        $deleteForm = $this->createDeleteForm($info);

        return $this->render('info/show.html.twig', array(
            'info' => $info,
            'delete_form' => $deleteForm->createView(),
        ));
    }

 
    /**
     * Deletes a info entity.
     *
     */
    public function deleteAction(Request $request, Info $info)
    {
        $form = $this->createDeleteForm($info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($info);
            $em->flush();
        }

        return $this->redirectToRoute('info_index');
    }

    /**
     * Creates a form to delete a info entity.
     *
     * @param Info $info The info entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Info $info)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('info_delete', array('id' => $info->getEmail())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
