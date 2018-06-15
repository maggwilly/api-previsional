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
use Pwm\MessagerBundle\Entity\Notification;
use AppBundle\Event\NotificationEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
          $note=0; $programme=0; 
          $objectif=0; 
          $poids=0;
          if($matiere!=null){
               foreach ($analyses as $key => $value) {
                  $note+=$value->getNote()?$value->getNote():0;
                  $objectif+=$value->getObjectif()?$value->getObjectif():0;
                  }          
                 $analyse->setNote(round($nombre>0?$note/$nombre:$note,1));
                 $analyse->setObjectif($nombre>0?$objectif/$nombre:null);
                 $analyse->setProgramme($nombre*100/$matiere->getUnites()->count()); //unites
                 $em->flush();
                 return array('matiere'=>$this->showJsonAction($studentId,$session,$matiere),'concours'=> $this->newParent($studentId, $session));
            }
            else{
                  foreach ($analyses as $key => $value) {
                    $note+= $value->getNote()?$value->getNote()*$value->getMatiere()->getPoids():0;
                    $poids+=$value->getMatiere()->getPoids();
                    $programme+=($value->getProgramme())?$value->getProgramme():0;
                    $objectif+=$value->getObjectif()?$value->getObjectif():0;
                   }          
                  $analyse->setNote(round($nombre>0?$note/$poids:$note,1));
                  $analyse->setObjectif($nombre>0?$objectif/$nombre:null);               
                  $analyse->setProgramme($nombre>0?$programme/$nombre:null);
               }
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
           }
         }
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
        return $this->render('AdminBundle:analyse:show.html.twig', array(
            'analyse' => $analyse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

/**
 * @Security("is_granted('ROLE_SUPERVISEUR')")
*/
    public function analyseAction(Session $session)
    {
          $em = $this->getDoctrine()->getManager();
          $abonnements=$session->getAbonnements();
          
        foreach ($abonnements as $key => $abonnement) {
             $analyse=$this->showJsonAction($abonnement->getInfo(),$session);
             $body=$this->renderView('AdminBundle:analyse:analyse.html.twig', array('abonnement' => $abonnement,'analyseSession' => $analyse));
           $notification=new Notification('private');
           $notification->setTitre("Resultats-".$session->getNomConcours())
               ->setSousTitre("Celà fait déjà un moment que vous avez installé notre application et commencé la préparation au concours de ".$session->getNomConcours().". Voici votre bilan.")            
              ->setSendDate(new \DateTime())
             ->setIncludeMail(true)
             ->setUser($this->getUser())
             ->setSendNow(true)             
             ->setText($body);
            $em->persist($notification);
             $em->flush();             
             $data=array('page'=>'notification','id'=>$notification->getId());
             $event=new NotificationEvent($abonnement->getInfo()->getRegistrations()->toArray(),$notification,$data);
            $this->get('event_dispatcher')->dispatch('notification.shedule.to.send', $event);  

        }
        $this->addFlash('success', 'Rresultat envoyé à . '.count($abonnement->getInfo()->getRegistrations()->toArray()).' personnes'); 
        return $this->redirectToRoute('session_show', array('id' => $session->getId()));
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
