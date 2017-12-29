<?php

namespace Pwm\AdminBundle\Controller;

use Pwm\AdminBundle\Entity\Analyse;
use AppBundle\Entity\Matiere;
use AppBundle\Entity\Partie;
use AppBundle\Entity\Session;
use Pwm\AdminBundle\Entity\Info;
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

        $analyses = $em->getRepository('AdminBundle:Analyse')->findAll();

        return $this->render('AdminBundle:analyse:index.html.twig', array(
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
        $form = $this->createForm('Pwm\AdminBundle\Form\AnalyseType', $analyse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($analyse);
            $em->flush();
            return $this->redirectToRoute('analyse_show', array('id' => $analyse->getId()));
        }

        return $this->render('AdminBundle:analyse:new.html.twig', array(
            'analyse' => $analyse,
            'form' => $form->createView(),
        ));
    }

    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"analyse"})
     */
    public function newJsonAction(Request $request,Info $studentId, Session $session, Matiere $matiere, Partie $partie)
    {   $em = $this->getDoctrine()->getManager();
         $analyse = $em->getRepository('AdminBundle:Analyse')->findOneOrNull($studentId,$session,$matiere,$partie);
         if($analyse!=null)
             return $this->editAction($request, $analyse,$studentId,$session,$matiere,$partie);
        $analyse = new Analyse($studentId, $session, $matiere, $partie);
        $form = $this->createForm('Pwm\AdminBundle\Form\AnalyseType', $analyse);
         $form->submit($request->request->all(),false);
        if ($form->isValid()) {
              $em = $this->getDoctrine()->getManager();
              $em->persist($analyse);
              $em->flush();
            return  array('partie'=>$this->showJsonAction($studentId, $session, $matiere, $partie), 'parents'=>$this->newParent($studentId,$session,$matiere));
        }
        return $form;
    }

    
    public function newParent(Info $studentId,Session $session, Matiere $matiere=null){
        $em = $this->getDoctrine()->getManager();
        $analyse = $em->getRepository('AdminBundle:Analyse')->findOneOrNull($studentId,$session,$matiere);
            if($analyse==null){
                 $analyse = new Analyse($studentId, $session, $matiere);
                 $em->persist($analyse);
              //   $em->flush();
            }
          $analyses = $em->getRepository('AdminBundle:Analyse')->findOllFor($studentId,$session,$matiere);
          $nombre= count($analyses);
          $note=0; $programme=0; $objectif=0; 
          $poids=0;
         foreach ($analyses as $key => $value) {
             $note+= $value->getNote()?$value->getNote()*$value->getMatiere()->getPoids():0;
             $poids+=$value->getMatiere()->getPoids();
             $programme+=($value->getProgramme())?$value->getProgramme():0;
             $objectif+=$value->getObjectif()?$value->getObjectif():0;
            }
               $analyse->setNote($nombre>0?$note/$poids:$note);
              $analyse->setObjectif($nombre>0?$objectif/$nombre:null);
              if($matiere!=null){
                 $analyse->setProgramme($nombre*100/$matiere->getParties()->count());
                 $em->flush();
                 return array('matiere'=>$this->showJsonAction($studentId,$session,$matiere),'concours'=> $this->newParent($studentId, $session));
              }
               else
                 $analyse->setProgramme($nombre>0?$programme/$nombre:null);
                 $em->flush();
               return $this->showJsonAction($studentId,$session); 
          
      }


    /**
     * Displays a form to edit an existing analyse entity.
     *
     */
    public function editAction(Request $request, Analyse $analyse,Info $studentId, Session $session, Matiere $matiere=null, Partie $partie=null)
    {
        $form = $this->createForm('Pwm\AdminBundle\Form\AnalyseType', $analyse);
         $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return array('partie'=>$this->showJsonAction($studentId, $session, $matiere, $partie), 'parents'=>$this->newParent($studentId,$session,$matiere));
        }
        return $form;
    }

    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"analyse"})
     */
    public function showJsonAction(Info $studentId, Session $session, Matiere $matiere=null, Partie $partie=null){
        $em = $this->getDoctrine()->getManager();
        $analyse = $em->getRepository('AdminBundle:Analyse')->findOneOrNull($studentId,$session,$matiere,$partie); 
         if($analyse!=null){
             $sup10=$em->getRepository('AdminBundle:Analyse')->noteSuperieur10($session,$matiere,$partie)[0]['sup10']+125;
              $nombre=$em->getRepository('AdminBundle:Analyse')->noteSuperieur10($session,$matiere,$partie)[0]['nombre']+1200;
              $analyse->setSup10($nombre>0?$sup10*100/$nombre:'--');
              $analyse->setEvalues($nombre);
              $analyseData = $em->getRepository('AdminBundle:Analyse')->getIndex($session,$matiere,$partie);
        foreach ($analyseData as $key => $value) {
            if($value['note']==$analyse->getNote()){
                $analyse->setDememe($value['dememe']+3);
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
        return $this->render('AdminBundle:analyse/show.html.twig', array(
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
