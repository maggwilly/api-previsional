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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
// Utilisation de la vue de FOSRestBundle

/**
 * Partie controller.
 */
class PartieController extends Controller
{

 /**
 * @Security("is_granted('ROLE_SAISIE')")
*/
    public function indexAction(Matiere $matiere=null)
    {      $parties=array();//$this->getUser()->getParties();
         $em = $this->getDoctrine()->getManager();
        if(!is_null($matiere))
                $parties=$matiere->getUnites();
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
         $parties=$matiere->getUnites();//->getParties();
       foreach ($parties as $key => $partie) {
             $partie->setIsAvalable(!empty($em->getRepository('AppBundle:Partie')->findAvalability($partie->getId(),$session->getId())));
            // $partie->setIsAvalable(true);
             $partie->setAnalyse($em->getRepository('AdminBundle:Analyse')->findOneOrNull( $info,$session,$mat,$partie)); 
         };
        return  $parties;
    }
    
 /**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function enableAction(Request $request,Partie $partie)
    {   

         $editForm = $this->createForm('AppBundle\Form\PartieEditType', $partie);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
             $this->addFlash('success', 'Modifications  enrégistrées avec succès.');
             if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPERVISEUR'))
                return $this->redirectToRoute('partie_index', array('id' => $partie->getMmatiere()->getId()));
              return $this->redirectToRoute('partie_index');
        }elseif($editForm->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');
        return $this->render('partie/edit.html.twig', array(
            'partie' => $partie,
            'edit_form' => $editForm->createView(),
        ));
        return $this->redirectToRoute('partie_index', array('id' => $partie->getMatiere()->getId()));
    }

    /**
     * Lists all Produit entities.
    
     */
    public function isAvalableAction(Request $request,Partie $partie)
    {
        
           $em = $this->getDoctrine()->getManager();
           $session  = $this->get("session")->get('current_session_id');
           if(!is_null($session))
         return new Response(''.empty($em->getRepository('AppBundle:Partie')->findAvalability( $partie->getId(),$session))); 
      return new Response('false'); 
    }


    public function sortCollection($collection){
    $iterator = $collection->getIterator();
    $iterator->uasort(function ($a, $b) {
    return ($a->getId() < $b->getId()) ? -1 : 1;
    });
   return  iterator_to_array($iterator);
 }

 /**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function newAction(Matiere $matiere,Request $request)
    {
        $partie = new Partie();
        $form = $this->createForm('AppBundle\Form\PartieType', $partie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $partie->setMatiere($matiere);
            $matiere->addUnite($partie);
            $em->persist($partie);
            $em->flush();
             $this->addFlash('success', 'Enrégistrement effectué');
            return $this->redirectToRoute('partie_index', array('id' => $partie->getMatiere()->getId()));
        }elseif($form->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');

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
         $url="https://trainings-fa73e.firebaseio.com/question/".$partie->getId()."/.json";
         $res =!is_null($this->get('fmc_manager')->sendOrGetData($url,null,'GET')) ? $this->get('fmc_manager')->sendOrGetData($url,null,'GET'):array(); 
        return  new Response(''.count($res));
    }


 /**
 * @Security("is_granted('ROLE_SAISIE')")
*/
    public function editAction(Request $request, Partie $partie, Matiere $matiere)
    {
        $deleteForm = $this->createDeleteForm($partie,$matiere);
        $editForm = $this->createForm('AppBundle\Form\PartieType', $partie);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
             $this->addFlash('success', 'Modifications  enrégistrées avec succès.');
             if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPERVISEUR'))
                return $this->redirectToRoute('partie_index', array('id' => $matiere->getId()));
              return $this->redirectToRoute('partie_index');
        }elseif($editForm->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');
        return $this->render('partie/edit.html.twig', array(
            'partie' => $partie,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

 /**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function deleteAction(Request $request, Partie $partie, Matiere $matiere)
    {
        $form = $this->createDeleteForm($partie,$matiere);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $matiere->removeUnite($partie);
             $matiere->removeParty($partie);
           // $em->remove($partie);
            $em->flush();
            $this->addFlash('success', 'Supprimé.');
        }
              if ($this->get('security.authorization_checker')->isGranted('ROLE_SUPERVISEUR'))
                return $this->redirectToRoute('partie_index', array('id' => $matiere->getId()));
         return $this->redirectToRoute('partie_index');
    }

    /**
     * Creates a form to delete a partie entity.
     * @param Partie $partie The partie entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Partie $partie,Matiere $matiere)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partie_delete', array('id' => $partie->getId(),'matiere' => $matiere->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


 /**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function attrAction(Request $request, Partie $partie)
    {
         $referer = $this->getRequest()->headers->get('referer');   
        $form = $this->createAttForm($partie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             $em = $this->getDoctrine()->getManager();
              $formData=$form->getData();
              $superviseur=$em->getRepository('AppBundle:User')->findOneByUsername($formData['user']);
              if($superviseur!=null){
                   $partie->setUser( $superviseur);
                   $em->flush();
                    $this->addFlash('success', 'Attribution de responsabilité à '.$partie->getUser()->getNom());
              return $this->redirectToRoute('partie_attr', array('id' => $partie->getId()));
              }
              $this->addFlash('error', "Le numéro de téléphone ne corresponds à celui d'aucun utilisateur enrégistré. Veillez saisir un numéro de 09 chiffres.");
        
        }elseif($form->isSubmitted())
               $this->addFlash('error', 'Certains champs ne sont pas corrects.');
       return $this->render('partie/attr.html.twig', array(
            'partie' => $partie,
            'form' => $form->createView(),
        ));
    }

     /**
     * Creates a form to delete a partie entity.
     * @param Partie $partie The partie entity
     * @return \Symfony\Component\Form\Form The form
     */
     
    private function createAttForm()
    {
        return $this->createFormBuilder()
               ->add('user','text',array('label'=>'Telephone editeur'))
             //->setAction($this->generateUrl('session_attr', array('id' => $session->getId())))
             ->setMethod('GET')
            ->getForm()
        ;
    } 



}
