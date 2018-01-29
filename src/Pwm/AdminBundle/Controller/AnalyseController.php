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
                 $em->flush();
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
               $analyse->setNote(round($nombre>0?$note/$poids:$note,1));
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

    public function compare(Analyse $analyse=null)
    {
         $analyseData =array();
        if($analyse!=null){
        $em = $this->getDoctrine()->getManager();
        $analyseData = $em->getRepository('AdminBundle:Analyse')->getIndex($analyse->getSession(),$analyse->getMatiere(),$analyse->getPartie());
          foreach ($analyseData as $key => $value) {
            if(round($value['note'],1)==round($analyse->getNote(),1)){
                $analyse->setDememe($value['dememe']);
                $analyse->setRang($key+1);     
              }
        } }
        return $analyse;
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
              $sup10=$em->getRepository('AdminBundle:Analyse')->noteSuperieur10($session,$matiere,$partie)[0]['sup10'];
              $nombre=$em->getRepository('AdminBundle:Analyse')->noteSuperieur10($session,$matiere,$partie)[0]['nombre'];
              $analyse->setSup10($nombre>0?$sup10*100/$nombre:'--');
              $analyse->setEvalues($nombre);

         if($session->getId()==69||$session->getId()==70||$session->getId()==71){
             $sup10=$em->getRepository('AppBundle:Analyse')->noteSuperieur10($session,$matiere,$partie)[0]['sup10']+300;
              $nombre=$em->getRepository('AppBundle:Analyse')->noteSuperieur10($session,$matiere,$partie)[0]['nombre']+1454;
              $analyse->setSup10($nombre>0?$sup10*100/$nombre:'--');
              $analyse->setEvalues($nombre);
              $analyseData = $em->getRepository('AppBundle:Analyse')->getIndex($session,$matiere,$partie);
        foreach ($analyseData as $key => $value) {
            if($value['note']==$analyse->getNote()){
                $analyse->setDememe($value['dememe']+11);
                if($analyse->getNote()<=1)
                   $analyse->setRang($key+1+1310);
               elseif($analyse->getNote()<2)
                   $analyse->setRang($key+1+1210);
               elseif($analyse->getNote()<3)
                   $analyse->setRang($key+1+1180);               
               elseif($analyse->getNote()<5)
                   $analyse->setRang($key+1+1160);
               elseif($analyse->getNote()<7)
                   $analyse->setRang($key+1+1140);
               elseif($analyse->getNote()<8)
                   $analyse->setRang($key+1+1090);
               elseif($analyse->getNote()<9)
                   $analyse->setRang($key+1+1060);
               elseif($analyse->getNote()<10)
                   $analyse->setRang($key+1+945);
                elseif($analyse->getNote()<11)
                   $analyse->setRang($key+1+730);
                elseif($analyse->getNote()<12)
                   $analyse->setRang($key+1+700);                
                elseif($analyse->getNote()<13)
                   $analyse->setRang($key+1+660);
                elseif($analyse->getNote()<14)
                   $analyse->setRang($key+1+610);
                elseif($analyse->getNote()<15)
                   $analyse->setRang($key+1+510);
                elseif($analyse->getNote()<16)
                   $analyse->setRang($key+1+310);
                elseif($analyse->getNote()<17)
                   $analyse->setRang($key+1+210);
                elseif($analyse->getNote()<18)
                   $analyse->setRang($key+1+100); 
                 elseif($analyse->getNote()<19)
                   $analyse->setRang($key+1+60);                
                 elseif($analyse->getNote()<=20)
                   $analyse->setRang($key+1+3);
          }
        }
      }

    }
        return  $this->compare($analyse);
           
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
