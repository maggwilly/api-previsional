<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Analyse;
use AppBundle\Entity\Matiere;
use AppBundle\Entity\Partie;
use AppBundle\Entity\Programme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
/**
 * Analyse controller.
 *
 */
class AnalyseController extends Controller
{
    /**
     * Lists all analyse entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $analyses = $em->getRepository('AppBundle:Analyse')->findAll();

        return $this->render('analyse/index.html.twig', array(
            'analyses' => $analyses,
        ));
    }

    /**
     * Creates a new analyse entity.
     *
     */
    public function newAction(Request $request)
    {
        $analyse = new Analyse();
        $form = $this->createForm('AppBundle\Form\AnalyseType', $analyse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($analyse);
            $em->flush();
            return $this->redirectToRoute('analyse_show', array('id' => $analyse->getId()));
        }

        return $this->render('analyse/new.html.twig', array(
            'analyse' => $analyse,
            'form' => $form->createView(),
        ));
    }

    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"analyse"})
     */
    public function newJsonAction(Request $request,$studentId, Programme $concours, Matiere $matiere=null, Partie $partie=null)
    {   $em = $this->getDoctrine()->getManager();
         $analyse = $em->getRepository('AppBundle:Analyse')->findOneOrNull($studentId,$concours,$matiere,$partie);
         if($analyse!=null)
             return $this->editAction($request, $analyse,$studentId,$concours,$matiere,$partie);
        $analyse = new Analyse($studentId, $concours, $matiere, $partie);
        $form = $this->createForm('AppBundle\Form\AnalyseType', $analyse);
         $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
              $em->persist($analyse);
            $em->flush();
            return  $this->showJsonAction($studentId,$concours,$matiere,$partie);
        }
        return $form;
    }

    /**
     * Displays a form to edit an existing analyse entity.
     *
     */
    public function editAction(Request $request, Analyse $analyse,$studentId, Programme $concours, Matiere $matiere=null, Partie $partie=null)
    {
        $form = $this->createForm('AppBundle\Form\AnalyseType', $analyse);
         $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->showJsonAction($studentId,$concours,$matiere,$partie);
        }
        return $form;
    }

    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"analyse"})
     */
    public function showJsonAction($studentId, Programme $concours, Matiere $matiere=null, Partie $partie=null){
        $em = $this->getDoctrine()->getManager();
        $analyse = $em->getRepository('AppBundle:Analyse')->findOneOrNull($studentId,$concours,$matiere,$partie); 
        if($analyse!=null){
              $sup10=$em->getRepository('AppBundle:Analyse')->noteSuperieur10($concours,$matiere,$partie)[0]['sup10'];
              $nombre=$em->getRepository('AppBundle:Analyse')->noteSuperieur10($concours,$matiere,$partie)[0]['nombre'];
             $analyse->setSup10($nombre>0?$sup10*100/$nombre:'--');
             $analyse->setEvalues($nombre);
             $analyseData = $em->getRepository('AppBundle:Analyse')->getIndex($concours,$matiere,$partie);
        foreach ($analyseData as $key => $value) {
            if($value['note']==$analyse->getNote()){
                $analyse->setDememe($value['dememe']);
                $analyse->setRang($key+1);
          }
        } 
    }
        return  $analyse;
           
    }

    /**
     * Finds and displays a analyse entity.
     *
     */
    public function showAction(Analyse $analyse)
    {
        $deleteForm = $this->createDeleteForm($analyse);
        return $this->render('analyse/show.html.twig', array(
            'analyse' => $analyse,
            'delete_form' => $deleteForm->createView(),
        ));
    }



    /**
     * Deletes a analyse entity.
     *
     */
    public function deleteAction(Request $request, Analyse $analyse)
    {
        $form = $this->createDeleteForm($analyse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($analyse);
            $em->flush();
        }

        return $this->redirectToRoute('analyse_index');
    }

    /**
     * Creates a form to delete a analyse entity.
     *
     * @param Analyse $analyse The analyse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Analyse $analyse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('analyse_delete', array('id' => $analyse->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
