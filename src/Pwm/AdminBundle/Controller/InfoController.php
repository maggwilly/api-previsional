<?php

namespace Pwm\AdminBundle\Controller;

use Pwm\AdminBundle\Entity\Info;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
use AppBundle\Event\InfoEvent;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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

        $infos = $em->getRepository('AdminBundle:Info')->findAll();
        foreach ($infos as $key => $info) {
            foreach ($info->getRegistrations() as $key => $registration) {
                 if(!$registration->getIsFake()){
                  $url="https://trainings-fa73e.firebaseio.com/users/".$info->getUid()."/registrationsId/.json";
                  $data = array($registration->getRegistrationId() => true);
                  $fmc_response= $this->get('fmc_manager')->sendOrGetData($url,$data,'PATCH');           
              }
            }

        }
 
        return $this->render('AdminBundle:info:index.html.twig', array(
            'infos' => $infos,
        ));
    }

        /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"info"})
     */
    public function editPictureAction(Request $request,  $email)
    {  $em = $this->getDoctrine()->getManager();
        $info = $em->getRepository('AdminBundle:Info')->findOneByUid($email);
          if($info==null){
          $info = new Info($email);
           $em->persist($info);
            $em->flush();
          }

        $form = $this->createForm('Pwm\AdminBundle\Form\InfoType', $info);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();       
       if( $info->upload()){
         $cloudinaryWrapper=$this ->container-> get('misteio_cloudinary_wrapper');
          $results= $cloudinaryWrapper-> upload($info->getPath(), '_user_'.$info->getUid(),array(), array("crop" => "limit","width" => "150", "height" => "150"))->getResult();
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
    public function editJsonAction(Request $request, Info $info)
    {
        $form = $this->createForm('Pwm\AdminBundle\Form\InfoType', $info);
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
    public function newJsonAction(Request $request, $uid)
    {
        $em = $this->getDoctrine()->getManager();
         $info = $em->getRepository('AdminBundle:Info')->findOneByUid($uid);
        if(is_null($info)){
            $info = new Info($uid);
            $form = $this->createForm('Pwm\AdminBundle\Form\InfoType',$info);
            $form->submit($request->request->all(),false);
            if (!$form->isValid())
                 return $form;
                  $em->persist($info);  
                   $em->flush();   
                   $event= new InfoEvent($info);
                 $this->get('event_dispatcher')->dispatch('user.created', $event); 
             return $info;          
              }

        return  $info;
    }


    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"ambassador"})
     */
    public function getAmbassadorJsonAction( Info $info){

        return  $info->getAmbassador();
    }


    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"info"})
     */
    public function showJsonAction(Request $request,$uid){
         $em = $this->getDoctrine()->getManager();
         $url= "https://trainings-fa73e.firebaseio.com/users/".$uid.".json";
         $res = $this->get('fmc_manager')->sendOrGetData($url,null,'GET');        
         $info = $em->getRepository('AdminBundle:Info')->findOneByUid($uid);
         $registrationId=$request->query->get('registrationId');
         $registration = $em->getRepository('MessagerBundle:Registration')->findOneByRegistrationId($registrationId);
           if(is_null($info)){
            $info = new Info($uid);
            $form = $this->createForm('Pwm\AdminBundle\Form\InfoType',$info);
            $form->submit($res,false);
            if (!$form->isValid())
                 return $form;
                if($registration!=null) 
                $registration->setInfo($info);
                  $em->persist($info);  
                   $em->flush();   
                 $event= new InfoEvent($info);
                 $this->get('event_dispatcher')->dispatch('user.created', $event);           
              }
            if($registration!=null){
                $registration->setInfo($info);
                  $em->flush();
                 $url="https://trainings-fa73e.firebaseio.com/users/".$info->getUid()."/registrationsId/.json";
                 $data = array($registration->getRegistrationId() => true);
                  $fmc_response= $this->get('fmc_manager')->sendOrGetData($url,$data,'PATCH');           
              } 
         
        return $info;
    }
    /**
     * Finds and displays a info entity.
     *
     */
    public function editAction(Request $request,Info $info)
    {
        $em = $this->getDoctrine()->getManager();
        $editForm = $this->createFormBuilder($info)
        ->add('displayName','text', array('label'=>"Nom complet"))
        ->add('email',EmailType::class, array('label'=>"Adresse mail",'required' => false))
        ->add('phone','text', array('label'=>"Numéro de télephone"))
        ->add('ville', ChoiceType::class, array(
                                  'choices'  => array(
                                          '' => 'Choisir une ville',
                                         'Bafoussam' => 'Bafoussam',
                                         'Bamenda' => 'Bamenda',
                                         'Buéa' => 'Buéa', 
                                         'Bertoua' => 'Bertoua', 
                                         'Douala' => 'Douala',
                                         'Dschang' => 'Dschang',
                                         'Garoua' => 'Garoua',
                                         'Ngaoundére' => 'Ngaoundére', 
                                         'Yaoundé' => 'Yaoundé', 
                                         'Maroua' => 'Maroua'),
                                  'label'=>"Ville d'études",'required' => false
                                   ))
        ->add('serie', ChoiceType::class, array(
                                  'choices'  => array(
                                          '' => 'Aucune série',
                                         'science' => 'science',
                                         'Lettres' => 'Lettres',
                                         'economie' => 'economie', 
                                         'droit' => 'droit', 
                                         'technique' => 'technique'),
                                  'label'=>"Branche de formation",'required' => false
                                   ))
        ->add('niveau', ChoiceType::class, array(
                                  'choices'  => array(
                                          '' => 'Aucun niveau',
                                         'CEPE' => 'CEPE',
                                         'BEPC - GCE O/L' => 'BEPC - GCE O/L',
                                         'BAC - GCE A/L' => 'BAC - GCE A/L', 
                                         'Licence & equiv' => 'Licence / equiv', 
                                         'Master & equiv' => 'Master / equiv'),
                                  'label'=>"Niveau d'étude",'required' => false
                                   ))
        ->getForm();
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
             $em->flush();
             $this->addFlash('success', 'Modifications  enrégistrées avec succès.');
            return $this->redirectToRoute('info_edit', array('uid' => $info->getUid()));
        }        
        return $this->render('AdminBundle:info:edit.html.twig', array(
            'info' => $info,
            'edit_form' => $editForm->createView(),
        ));
    }

 
    
    /**
     * Finds and displays a info entity.
     *
     */
    public function showAction(Info $info)
    {
        $deleteForm = $this->createDeleteForm($info);
        return $this->render('AdminBundle:info:show.html.twig', array(
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
