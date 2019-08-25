<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PointVente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View;
use AppBundle\Entity\User; 
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Pointvente controller.
 *
 */
class PointVenteController extends Controller
{

    /**
     * @Rest\View(serializerGroups={"pointvente"})
     */
    public function indexJsonAction(Request $request)
    {
        $alls=$request->query->all();
        $keys=$request->query->has('keys')?$request->query->get('keys'):'';
         if (count_chars($keys)>0) {
              $keys=explode(".", $keys);
         }else $keys=[""];
         $previsioner=$this->get('previsonal_client');
         $em=$this->getDoctrine()->getManager();
        $pointVentes= (new ArrayCollection($em->getRepository('AppBundle:PointVente')->findByUser($this->getUser(),$alls,$keys)))
            ->map(function($pointVente) use ($previsioner){
                $pointVente
              ->setRendezvous($previsioner->findNextRendevous($pointVente))
              ->setLastCommende($previsioner->findLastCommende($pointVente))
              ->setFirstCommende($previsioner->findFirstCommende($pointVente));
              return $pointVente;
            })
            ->filter(
             function($entry) use ($alls) {   
                if(array_key_exists('afterrendevousdate',$alls)&&array_key_exists('beforrendezvousdate',$alls))
                    return is_null($entry->getRendezvous())
                         ||!$entry->getRendezvous()->getDateat()
                         ||!is_null($entry->getRendezvous())&&($entry->getRendezvous()->getDateat()>=new \DateTime($alls['afterrendevousdate'])) &&($entry->getRendezvous()->getDateat()<=new \DateTime($alls['beforrendezvousdate']));
                elseif (array_key_exists('afterrendevousdate',$alls)) {
                    return  is_null($entry->getRendezvous())
                         ||!$entry->getRendezvous()->getDateat()
                         ||!is_null($entry->getRendezvous())&&($entry->getRendezvous()->getDateat()>=new \DateTime($alls['afterrendevousdate']));
                }elseif (array_key_exists('beforrendezvousdate',$alls)) {
                   return  is_null($entry->getRendezvous())
                         ||!$entry->getRendezvous()->getDateat()
                         ||!is_null($entry->getRendezvous())&&$entry->getRendezvous()->getDateat()<=new \DateTime($alls['beforrendezvousdate']);
                }
                 return true;
             }
          ); 

        return $pointVentes->getValues();
    }




    /**
     * @Rest\View(serializerGroups={"pointvente"})
     * 
     */
    public function newJsonAction(Request $request)
    {
         $user=$this->getUser();
        $pointVente = new PointVente($user);
        $form = $this->createForm('AppBundle\Form\PointVenteType', $pointVente);
        $form->submit($this->makeUp($request),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
             if ($em->getRepository('AppBundle:PointVente')->find($pointVente->getId())==null) {
               $em->persist($pointVente);
            }
            $em->flush();
            return $pointVente->setRendezvous($this->get('previsonal_client')
          ->findNextRendevous($pointVente));
        }

        return  $form;
    }


    /**
     * @Rest\View(serializerGroups={"pointvente"})
     * 
     */
    public function showJsonAction(PointVente $pointVente)
    {

        return $pointVente->setRendezvous($this->get('previsonal_client')
          ->findNextRendevous($pointVente));
    }

        /**
     * @Rest\View(serializerGroups={"pointvente"})
     * 
     */
    public function editJsonAction(Request $request, PointVente $pointVente)
    {
        
        $editForm = $this->createForm('AppBundle\Form\PointVenteType', $pointVente);
        $alls=$request->request->all();
        unset($alls['id']);
        $editForm->submit($this->makeUp($request,false),false);
        if ( $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $pointVente->setRendezvous($this->get('previsonal_client')
          ->findNextRendevous($pointVente));
        }
        return array('error' => true );
    }


public function makeUp(Request $request,$setId=true){
    $pointVente= $request->request->all();
    unset ($pointVente['id']);
      if (!$setId) 
         unset ($pointVente['id']);
     if(array_key_exists('rendezvous', $pointVente))
        unset ($pointVente['rendezvous']);
     if(array_key_exists('lastCommende', $pointVente))
        unset ($pointVente['lastCommende']);
     if(array_key_exists('firstCommende', $pointVente))
        unset ($pointVente['firstCommende']);      
    return $pointVente;
}



    
    /**
     * Deletes a pointVente entity.
     *
     */
    public function deleteAction(Request $request, PointVente $pointVente)
    {
        $form = $this->createDeleteForm($pointVente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pointVente);
            $em->flush();
        }

        return $this->redirectToRoute('pointvente_index');
    }

    /**
     * @Rest\View()
     * 
     */
    public function deleteJsonAction(Request $request, PointVente $pointVente)
    {
        $id=$pointVente->getId();
            $em = $this->getDoctrine()->getManager();
       try {
          $em->remove($pointVente);
          $em->flush();
        } catch (\Exception $e) {
       return array('error' => true );
     }
        return array('ok' => true,'deletedId' => $id );
    }
    

 
}
