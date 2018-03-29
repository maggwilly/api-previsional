<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Matiere;
use AppBundle\Entity\Partie;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
// Utilisation de la vue de FOSRestBundle

/**
 * Partie controller.
 */
class PartieController extends Controller
{

    /**
     * Lists all partie entities.
     */
    public function indexAction(Matiere $matiere=null)
    {      $parties=array();//$this->getUser()->getParties();
         $em = $this->getDoctrine()->getManager();
        if(!is_null($matiere))
                $parties=$matiere->getParties();
           else
              $parties= $em->getRepository('AppBundle:Partie')->findByUser($this->getUser());
        return $this->render('partie/index.html.twig', array(
              'parties' => $parties,'matiere' => $matiere,
        ));
    }

    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"partie"})
     */
    public function jsonIndexAction(Request $request,Matiere $matiere=null)
    {
         if(is_null($matiere))
              return array();
        $em = $this->getDoctrine()->getManager();
         $session=$em->getRepository('AppBundle:Session')->findOneById($request->query->get('session'));
         $info = $em->getRepository('AdminBundle:Info')->findOneByUid($request->query->get('uid'));
         $mat = $em->getRepository('AppBundle:Matiere')->findOneById($request->query->get('matiere'));
         $parties=$matiere->getParties();
       foreach ($parties as $key => $partie) {
             $partie->setIsAvalable(!empty($em->getRepository('AppBundle:Partie')->findAvalability($partie->getId(),$session->getId())));
            // $partie->setIsAvalable(true);
             $partie->setAnalyse($em->getRepository('AdminBundle:Analyse')->findOneOrNull( $info,$session,$mat,$partie)); 
         };
        return  $parties;
    }
    
    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"partie"})
     */
    public function isAvalableAction(Request $request)
    {
         $partie=$request->query->get('partie');
          $session=$request->query->get('session');
         return true;//!empty($this->getDoctrine()->getManager()->getRepository('AppBundle:Partie')->findAvalability( $partie,$session)); 
    }


    public function sortCollection($collection){
    $iterator = $collection->getIterator();
    $iterator->uasort(function ($a, $b) {
    return ($a->getId() < $b->getId()) ? -1 : 1;
    });
   return  iterator_to_array($iterator);
 }
    /**
     * Creates a new partie entity.
     */
    public function newAction(Matiere $matiere,Request $request)
    {
        $partie = new Partie();
        $form = $this->createForm('AppBundle\Form\PartieType', $partie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $partie->setMatiere($matiere);
            $em->persist($partie);
            $em->flush($partie);
            return $this->redirectToRoute('partie_show', array('id' => $partie->getId()));
        }

        return $this->render('partie/new.html.twig', array(
            'partie' => $partie, 'matiere' => $matiere,
            'form' => $form->createView(),
        ));
    }



    /**
     * Finds and displays a partie entity.
     *
     */
    public function getDificultQuestionsAction(Partie $partie)
    {
         $url="https://trainings-fa73e.firebaseio.com/status/question/".$partie->getId()."/.json";
         $res =!is_null($this->get('fmc_manager')->sendOrGetData($url,null,'GET')) ? $this->get('fmc_manager')->sendOrGetData($url,null,'GET'):array(); 
        return  new Response(''.count($res));
    }


    /**
     * Displays a form to edit an existing partie entity.
     */
    public function editAction(Request $request, Partie $partie)
    {
        $deleteForm = $this->createDeleteForm($partie);
        $editForm = $this->createForm('AppBundle\Form\PartieEditType', $partie);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('partie_edit', array('id' => $partie->getId()));
        }
        return $this->render('partie/edit.html.twig', array(
            'partie' => $partie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a partie entity.
     *
     */
    public function deleteAction(Request $request, Partie $partie)
    {
        $form = $this->createDeleteForm($partie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($partie);
            $em->flush($partie);
        }
        return $this->redirectToRoute('partie_index');
    }

    /**
     * Creates a form to delete a partie entity.
     * @param Partie $partie The partie entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Partie $partie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partie_delete', array('id' => $partie->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
