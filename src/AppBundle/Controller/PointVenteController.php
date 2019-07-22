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
    public function indexAction(User $user=null )
    {
        $em = $this->getDoctrine()->getManager();
        $pointVentes =is_null($user)?$em->getRepository('AppBundle:PointVente')->findAll():$em->getRepository('AppBundle:PointVente')->findByUser($user);
        return $this->render('pointvente/index.html.twig', array(
            'pointVentes' => $pointVentes,
        ));
    }

    /**
     * @Rest\View(serializerGroups={"rendezvous"})
     */
    public function indexJsonAction(Request $request)
    {
        $alls=$request->query->all();
        $keys=$request->query->has('keys')?$request->query->get('keys'):'';
         if (count_chars($keys)>0) {
              $keys=explode(".", $keys);
         }else $keys=[0];
         $pointVentes = $this->getDoctrine()->getManager()
                             ->getRepository('AppBundle:PointVente')
                             ->findByUser($this->getUser(),0,true,$keys,$alls);
        foreach ($pointVentes as $key => &$pointVente) {
          $rendezvous= $this->get('previsonal_client')
          ->dateProchaineCommende($pointVente)
          ->setUser($this->getUser());
          $pointVente->setRendezvous($rendezvous)
               ->setLastCommende($this->get('previsonal_client')
               ->findLastCommende($this->getUser(),$pointVente));
         }
         $pointVentes =new \Doctrine\Common\Collections\ArrayCollection($pointVentes);
         $pointVentes= $pointVentes->filter(
             function($entry) use ($alls) {   
                if(array_key_exists('afterlastvisitedate',$alls)&&array_key_exists('beforelastvisitedate',$alls))
                    return !is_null($entry->getLastCommende())&&($entry->getLastCommende()->getDate()>=new \DateTime($alls['afterlastvisitedate']))&&
                           ($entry->getLastCommende()->getDate()<=new \DateTime($alls['beforelastvisitedate']));
                elseif (array_key_exists('afterlastvisitedate',$alls)) {
                    return !is_null($entry->getLastCommende())&&($entry->getLastCommende()->getDate()>=new \DateTime($alls['afterlastvisitedate']));
                }elseif (array_key_exists('beforelastvisitedate',$alls)) {
                   return !is_null($entry->getLastCommende())&&$entry->getLastCommende()->getDate()<=new \DateTime($alls['beforelastvisitedate']);
                }
                 return true;
             }
          ); 
        return $pointVentes;
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
            return  $form;
        }

        return  array('error' => true );
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
    public function showJsonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pointVente=$em->getRepository('AppBundle:PointVente')->find($request->request->get('id'));
        return $pointVente;
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
