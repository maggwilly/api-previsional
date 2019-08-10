<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Secteur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View;
/**
 * Secteur controller.
 *
 */
class SecteurController extends Controller
{


    /**
     * @Rest\View(serializerGroups={"secteur"})
     * 
     */
    public function indexJsonAction(Request $request)
    {
         $keys=$request->request->get('keys');
         if (count_chars($keys)>0) {
            $keys=explode(".", $keys);
         }else $keys=[];
          $user=$this->getUser();
          $em = $this->getDoctrine()->getManager();
        $secteurs = $em->getRepository('AppBundle:Secteur')->findByUser($user->getParent(),null,null,$keys);
        return $secteurs;
    }


    /**
     * @Rest\View(serializerGroups={"secteur"})
     * 
     */
     public function newJsonAction(Request $request)
    {
        $user=$this->getUser();
        $secteur = new Secteur($user);
        $form = $this->createForm('AppBundle\Form\SecteurType', $secteur);
        $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($em->getRepository('AppBundle:Secteur')->find($secteur->getId())==null) {
                 $em->persist($secteur);
            }            

            $em->flush();

            return $secteur;
        }

        return array('error' => true );
    }
    

    /**
     * @Rest\View(serializerGroups={"secteur"})
     * 
     */
    public function editJsonAction(Request $request, Secteur $secteur)
    {
        $editForm = $this->createForm('AppBundle\Form\SecteurType', $secteur);
        $alls=$request->request->all();
        unset($alls['id']);
        $editForm->submit($alls,false);
        if ( $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $secteur;
        }
        return array( 'status' => 'error');
    }
    



    /**
     * @Rest\View()
     * 
     */
    public function deleteJsonAction(Request $request, Secteur $secteur)
    {
         $id=$secteur->getId();
         $em = $this->getDoctrine()->getManager();    
       try {
          $em->remove($secteur);
          $em->flush();
        } catch (\Exception $e) {
       return array('error' => true );
     }

        return array('ok' => true,'deletedId' => $id );
    }
 
}
