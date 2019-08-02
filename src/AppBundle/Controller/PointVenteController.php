<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PointVente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View;
use AppBundle\Entity\User; 
/**
 * Pointvente controller.
 *
 */
class PointVenteController extends Controller
{
    /**
     * Lists all pointVente entities.
     *
     */
    public function indexAction( )
    {
        $em = $this->getDoctrine()->getManager();
        $pointVentes =$em->getRepository('AppBundle:PointVente')->findByUser($this->getUser());
        return $this->render('pointvente/index.html.twig', array(
            'pointVentes' => $pointVentes,
        ));
    }

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
         $pointVentes = $this->getDoctrine()->getManager()
                             ->getRepository('AppBundle:PointVente')
                             ->findByUser($this->getUser(),$alls,$keys);
         
        foreach ($pointVentes as $key => &$pointVente) {
              $pointVente
              ->setRendezvous($this->get('previsonal_client')->findNextRendevous($pointVente))
              ->setLastCommende($this->get('previsonal_client')->findLastCommende($pointVente))
              ->setFirstCommende($this->get('previsonal_client')->findFirstCommende($pointVente));
         }
         $pointVentes =new \Doctrine\Common\Collections\ArrayCollection($pointVentes);
         $pointVentes= $pointVentes->filter(
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
     * Creates a new pointVente entity.
     *
     */
    public function newAction(Request $request)
    {
        $user=$this->getUser();
        $pointVente = new Pointvente($user);
        $form = $this->createForm('AppBundle\Form\PointVenteType', $pointVente);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pointVente);
            $em->flush();
            return $this->redirectToRoute('pointvente_show', array('id' => $pointVente->getId()));
        }
        return $this->render('pointvente/new.html.twig', array(
            'pointVente' => $pointVente,
            'form' => $form->createView(),
        ));
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
        $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
             if ($em->getRepository('AppBundle:PointVente')->find($pointVente->getId())==null) {
               $em->persist($pointVente);
            }
           
            $em->flush();
            return $pointVente->setRendezvous($this->get('previsonal_client')
          ->findNextRendevous($pointVente)
          ->setUser($this->getUser()));
        }

        return  $form;
    }
    /**
     * Finds and displays a pointVente entity.
     *
     */
    public function showAction(PointVente $pointVente)
    {
        $deleteForm = $this->createDeleteForm($pointVente);
        return $this->render('pointvente/show.html.twig', array(
            'pointVente' => $pointVente,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * @Rest\View(serializerGroups={"pointvente"})
     * 
     */
    public function showJsonAction(PointVente $pointVente)
    {

        return $pointVente->setRendezvous($this->get('previsonal_client')
          ->findNextRendevous($pointVente)
          ->setUser($this->getUser()));
    }
    /**
     * Displays a form to edit an existing pointVente entity.
     *
     */
    public function editAction(Request $request, PointVente $pointVente)
    {
        $deleteForm = $this->createDeleteForm($pointVente);
        $editForm = $this->createForm('AppBundle\Form\PointVenteType', $pointVente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('pointvente_edit', array('id' => $pointVente->getId()));
        }

        return $this->render('pointvente/edit.html.twig', array(
            'pointVente' => $pointVente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * @Rest\View(serializerGroups={"pointvente"})
     * 
     */
    public function editJsonAction(Request $request, PointVente $pointVente)
    {
        
        $editForm = $this->createForm('AppBundle\Form\PointVenteType', $pointVente);
        $editForm->submit($request->request->all(),false);
        if ( $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $pointVente;
        }
        return array('error' => true );
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
    
    /**
     * Creates a form to delete a pointVente entity.
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PointVente $pointVente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pointvente_delete', array('id' => $pointVente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
 
}
