<?php

namespace AppBundle\Controller;
use AppBundle\Entity\PointVente;
use AppBundle\Entity\Rendezvous;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Rendezvous controller.
 *
 */
class RendezvousController extends Controller
{


    /**
     * @Rest\View(serializerGroups={"rendezvous"})
     */
    public function indexJsonAction(Request $request)
    {   
        $alls=$request->query->all();
        $keys=$request->query->has('keys')?$request->query->get('keys'):'';
         if (count_chars($keys)>0) {
              $keys=explode(".", $keys);
         }else $keys=[""]; 
          $previsioner=$this->get('previsonal_client');
         $lesrendezvous=[];    
         ( new ArrayCollection($this->getDoctrine()->getManager()->getRepository('AppBundle:PointVente')->findByUser($this->getUser(),$alls,$keys,true)))->map(function($pointVente) use (&$lesrendezvous,$previsioner,$alls){
             $rendezvous=$previsioner->findLastRendevous($pointVente,null,$alls);
              if($rendezvous)
                $lesrendezvous[]=$previsioner->addPrevisions($rendezvous,false); 
         });      
        return $lesrendezvous;
    }



    /**
     * @Rest\View(serializerGroups={"rendezvous"})
     */
    public function newJsonAction(Request $request)
    {
        $rendezvous = new Rendezvous();
        $form = $this->createForm('AppBundle\Form\RendezvousType', $rendezvous);
        $form->submit($this->makeUp($request),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $rendezvous->setPersist(true);
            if($rendezvous->getUser()==null)
                  $rendezvous->setUser($this->getUser());
            if ($em->getRepository('AppBundle:Rendezvous')->find($rendezvous->getId())==null) {
                 $em->persist($rendezvous);
            }          
            $em->flush();
            return $this->get('previsonal_client')->addPrevisions($rendezvous);
        }

        return  $form;
    }


public function makeUp(Request $request,$setId=true){
    $rendezvous= $request->request->all();
    if (array_key_exists('user', $rendezvous)&&is_array($rendezvous['user']))
        $rendezvous['user']=$rendezvous['user']['id'];
      if (array_key_exists('pointVente', $rendezvous)&&is_array($rendezvous['pointVente']))
        $rendezvous['pointVente']=$rendezvous['pointVente']['id'];
      if (!$setId) {
         unset ($rendezvous['id']);
      }
    return $rendezvous;
}
    /**
     * @Rest\View(serializerGroups={"rendezvous"})
     * 
     */
    public function editJsonAction(Request $request, Rendezvous $rendezvous)
    {
        $editForm = $this->createForm('AppBundle\Form\RendezvousType', $rendezvous);
        $editForm->submit($this->makeUp($request,false),false);
        if ( $editForm->isValid()) {
            if($rendezvous->getUser()==null)
                  $rendezvous->setUser($this->getUser());
            $this->getDoctrine()->getManager()->flush();
            return $this->get('previsonal_client')->addPrevisions($rendezvous);
        }
        return $editForm;
    }

    /**
     * @Rest\View(serializerGroups={"rendezvous"})
     * 
     */
    public function showJsonAction(PointVente $pointVente)
    {
      return $this->get('previsonal_client')->findNextRendevous($pointVente);
    }




    /**
     * @Rest\View()
     */
    public function deleteJsonAction(Request $request, Rendezvous $rendezvous)
    {
         $id=$rendezvous->getId();
         $em = $this->getDoctrine()->getManager();    
       try {
          $em->remove($rendezvous);
          $em->flush();
        } catch (\Exception $e) {
       return array('error' => true );
     }
        return array('ok' => true,'deletedId' => $id );
    }



}
