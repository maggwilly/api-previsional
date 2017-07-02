<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Candidat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
/**
 * Candidat controller.
 *
 */
class CandidatController extends Controller
{
    /**
     * Lists all candidat entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $candidats = $em->getRepository('AppBundle:Candidat')->findAll();

        return $this->render('candidat/index.html.twig', array(
            'candidats' => $candidats,
        ));
    }

    /**
     * Creates a new candidat entity.
     *
     */
    public function newAction(Request $request)
    {
        $candidat = new Candidat();
        $form = $this->createForm('AppBundle\Form\CandidatType', $candidat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($candidat);
            $em->flush();
            return $this->redirectToRoute('candidat_show', array('id' => $candidat->getId()));
        }

        return $this->render('candidat/new.html.twig', array(
            'candidat' => $candidat,
            'form' => $form->createView(),
        ));
    }


    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"candidat"})
     */
    public function newJsonAction(Request $request, $studentId)
    {    $em = $this->getDoctrine()->getManager();
         $candidat = $em->getRepository('AppBundle:Candidat')->findOneByUid($studentId);
        if($candidat!=null)
            return $this->editAction($request, $candidat);
            $candidat = new Candidat($studentId);
            $form = $this->createForm('AppBundle\Form\CandidatType', $candidat);
            $form->submit($request->request->all(),false);
        if ($form->isValid()) {
              $info = $em->getRepository('AppBundle:Info')->findOneByUid($studentId);
              if($info!=null){
                $info->setCandidat($candidat);
                 }else
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
    public function editAction(Request $request, Candidat $candidat)
    {
        $form = $this->createForm('AppBundle\Form\CandidatType', $candidat);
         $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
             $info = $em->getRepository('AppBundle:Info')->findOneByUid($studentId);
              if($info!=null&&$info->getCandidat()==null){
                  $info->setCandidat($candidat);
                }
              $em->flush();
            return $candidat;
        }
        return $form;
    }


    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"candidat"})
     */
    public function showJsonAction($studentId){
        $em = $this->getDoctrine()->getManager();
         $candidat = $em->getRepository('AppBundle:Candidat')->findOneByUid($studentId);
        return $candidat;
    }

    /**
     * Finds and displays a candidat entity.
     *
     */
    public function showAction(Candidat $candidat)
    {
        $deleteForm = $this->createDeleteForm($candidat);
        return $this->render('candidat/show.html.twig', array(
            'candidat' => $candidat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a candidat entity.
     *
     */
    public function deleteAction(Request $request, Candidat $candidat)
    {
        $form = $this->createDeleteForm($candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($candidat);
            $em->flush();
        }

        return $this->redirectToRoute('candidat_index');
    }

    /**
     * Creates a form to delete a candidat entity.
     *
     * @param Candidat $candidat The candidat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Candidat $candidat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('candidat_delete', array('id' => $candidat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
