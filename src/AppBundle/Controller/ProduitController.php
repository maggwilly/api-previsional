<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View;
use AppBundle\Entity\PointVente; 
/**
 * Produit controller.
 *
 */
class ProduitController extends Controller
{


    /**
     * @Rest\View(serializerGroups={"produit"})
     * 
     */
    public function indexJsonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $start=$request->request->get('start');
        $keys=$request->query->get('keys');
         if (count_chars($keys)>0) {
              $keys=explode(".", $keys);
         }else $keys=[0];
         $user=$this->getUser();
        $produits = $em->getRepository('AppBundle:Produit')->findByUser($user->getParent(),$start,$keys);
        return $produits;
    }





    /**
     * @Rest\View(serializerGroups={"produit"})
     * 
     */
    public function newJsonAction(Request $request)
    {
        $user=$this->getUser();
        $produit = new Produit($user);
        $form = $this->createForm('AppBundle\Form\ProduitType', $produit);
        $form->submit($request->request->all(),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
           if ($em->getRepository('AppBundle:Produit')->find($produit->getId())==null) {
               $em->persist($produit);
            }
           
            $em->flush();
            return $produit;
        }

        return array('error' => true );
    }



        /**
     * @Rest\View(serializerGroups={"produit"})
     * 
     */
    public function editJsonAction(Request $request, Produit $produit)
    {
       $user=$this->getUser();
        $form = $this->createForm('AppBundle\Form\ProduitType', $produit);
       $alls=$request->request->all();
        unset($alls['id']);
        $form->submit($alls,false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $produit;
        }

        return  array(
            'status' => 'error');
    }


    /**
     * @Rest\View()
     * 
     */
    public function deleteJsonAction(Request $request, Produit $produit)
    {
         $id=$produit->getId();
         $em = $this->getDoctrine()->getManager();    
       try {
          $em->remove($produit);
          $em->flush();
        } catch (\Exception $e) {
       return array('error' => true );
     }

      return array('ok' => true,'deletedId' => $id );
    }

 
}
