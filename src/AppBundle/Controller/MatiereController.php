<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Programme;
use AppBundle\Entity\Matiere;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\Session; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Matiere controller.
 *
 */
class MatiereController extends Controller
{
    
 /**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function indexAction(Programme $concours,Session $session=null)
    {
        $collection=$concours->getMatieres();
        if(!is_null($session))
            $this->get("session")->set('current_session_id', $session->getId());
        return $this->render('matiere/index.html.twig', array(
            'matieres' =>  $collection,'concour' => $concours,
        ));
    }

 public function sortCollection($collection){
    $iterator = $collection->getIterator();
    $iterator->uasort(function ($a, $b) {
    return ($a->getId() < $b->getId()) ? -1 : 1;
    });
   return  iterator_to_array($iterator);
 }
    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"matiere"})
     */
    public function jsonIndexAction(Programme $concours=null)
    {   if(is_null($concours))
              return array();
         $matieres= $concours->getMatieres();
        return   $matieres;
    }
 /**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function newAction(Request $request,Programme $concours,Session $session=null)
    {
        $matiere = new Matiere();
        $form = $this->createForm('AppBundle\Form\MatiereType', $matiere);
        $form->handleRequest($request);
       if(!is_null($session))
         $this->get("session")->set('current_session_id', $session->getId());
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $matiere->setProgramme($concours);
            $em->persist($matiere);
            $em->flush($matiere);
             $this->addFlash('success', 'Enrégistrement effectué');
            return $this->redirectToRoute('matiere_new', array('id' => $concours->getId()));
        }elseif($form->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('matiere/new.html.twig', array(
            'matiere' => $matiere, 'concour' => $concours,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a matiere entity.
     *
     */
    public function showAction(Matiere $matiere)
    {
        $deleteForm = $this->createDeleteForm($matiere);

        return $this->render('matiere/show.html.twig', array(
            'matiere' => $matiere,
            'delete_form' => $deleteForm->createView(),
        ));
    }

 /**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function editAction(Request $request, Matiere $matiere)
    {
        $deleteForm = $this->createDeleteForm($matiere);
        $editForm = $this->createForm('AppBundle\Form\MatiereEditType', $matiere);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
             $this->addFlash('success', 'Modifications  enrégistrées avec succès.');
            return $this->redirectToRoute('matiere_edit', array('id' => $matiere->getId()));
        }elseif($editForm->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('matiere/edit.html.twig', array(
            'matiere' => $matiere,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

 
 /**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function deleteAction(Request $request, Matiere $matiere)
    {
        $form = $this->createDeleteForm($matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($matiere);
            $em->flush($matiere);
            $this->addFlash('success', 'Supprimé.');
        }

        return $this->redirectToRoute('matiere_index');
    }


 /**
 * @Security("is_granted('ROLE_ADMIN')")
*/
    public function reindexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $matieres= $em->getRepository('AppBundle:Matiere')->findAll();
        foreach ($matieres as $key => $matiere) {
            foreach ($matiere->getParties() as $key => $partie) {
                $matiere->removeUnite($partie);
               $matiere->addUnite($partie);
            }
            $em->flush(); 
        }
    $this->addFlash('success', 'Modifications  enrégistrées avec succès.');
       return $this->redirectToRoute('homepage');
    }

    /**
     * Creates a form to delete a matiere entity.
     *
     * @param Matiere $matiere The matiere entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Matiere $matiere)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('matiere_delete', array('id' => $matiere->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

 /**
 * @Security("is_granted('ROLE_CONTROLEUR')")
*/
    public function copyAction(Request $request, Matiere $matiere)
    {
        $createCopyForm = $this->createCopyForm($matiere);
        $createCopyForm->handleRequest($request);
        if ($createCopyForm->isSubmitted() && $createCopyForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
             $this->addFlash('success', 'Copie  terminée avec succès.');
            return $this->redirectToRoute('partie_index', array('id' => $matiere->getId()));
        }elseif($createCopyForm->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

        return $this->render('matiere/copy.html.twig', array(
            'matiere' => $matiere,
            'createCopyForm' => $createCopyForm->createView(),
        ));
    }


        private function createCopyForm(Matiere $matiere)
    {
        return $this->createFormBuilder($matiere)
                 ->add('unites', EntityType::class,
                       array('class' => 'AppBundle:Partie', 
                           'choice_label' => 'titre', 
                           'placeholder' => 'Aucun Programme',
                            'empty_data'  => null,
                            'required' => false,
                            'label'=>'Selectionnez les unités à importer',
                            'group_by' => function($val, $key, $index) {
                                 return $val->getMatiere()->getDisplayName();
                               },      
                            'multiple'=>true,
                            'expanded'=>false,                  
                            'attr'=>array('data-rel'=>'chosen1')))
                 ->setMethod('POST')
            ->getForm()
        ;
    }
}
