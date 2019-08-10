<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commende;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View;
use AppBundle\Entity\PointVente; 
use AppBundle\Entity\User; 
/**
 * Commende controller.
 *
 */
class CommendeController extends Controller
{


    /**
     * @Rest\View(serializerGroups={"full"})
     */
    public function indexJsonAction(Request $request)
    {    
      $alls=$request->query->all();
      $keys=$request->query->has('keys')?$request->query->get('keys'):'';
         if (count_chars($keys)>0) {
              $keys=explode(".", $keys);
         }else $keys=[""];
         if($request->query->get('pointVente')!=null){
            return $this->redirectToRoute('ligne_index_json', array('id' => $request->query->get('pointVente')));
         }
    $commendes =$this->getDoctrine()->getManager()->getRepository('AppBundle:Commende')->findCommendes($this->getUser(),null,$alls,$keys);
        return $commendes;
    }

    /**
     * @Rest\View(serializerGroups={"full"})
     */
    public function indexLigneJsonAction(PointVente $pointVente)
    {    $em = $this->getDoctrine()->getManager();
        $commendes = $em->getRepository('AppBundle:Commende')->findCommendes(null,$pointVente,null,null,'desc',[0],5);
        return  $commendes;
    }
  
    /**
     * @Rest\View(serializerGroups={"full"})
     * 
     */
    public function newJsonAction(Request $request)
    {
         $user=$this->getUser();
        $commende = new Commende($user);
        $form = $this->createForm('AppBundle\Form\CommendeType', $commende);
        $form->submit($this->makeUp($request),false);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($em->getRepository('AppBundle:Commende')->find($commende->getId())==null) {
               $em->persist($commende);
            }
              $em->flush();
           $this->get('previsonal_client')->findFirstCommende($commende->getPointVente());
            return $commende;
        }
        return $form;
    }


public function makeUp(Request $request,$setId=true){
    $commende= $request->request->all();
    foreach ( $commende['lignes']  as $key => &$ligne){
        if (array_key_exists('produit', $ligne)&&is_array($ligne['produit'])) {
             $ligne['produit']=$ligne['produit']['id'];  
        }
            
      } 
      if (array_key_exists('pointVente', $commende)&&is_array($commende['pointVente'])) {
        $commende['pointVente']=$commende['pointVente']['id'];
      }
      if (!$setId) {
         unset ($commende['id']);
      }
    
    return $commende;
}


    /**
     * @Rest\View(serializerGroups={"full"})
     * 
     */
    public function editJsonAction(Request $request, Commende $commende)
    {
        $editForm = $this->createForm('AppBundle\Form\CommendeType', $commende);
        $editForm->submit($this->makeUp($request,false),false);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $commende;
        }
        return $editForm;//array('error' => true );
    }
    

    /**
     * @Rest\View()
     * 
     */
    public function deleteJsonAction(Request $request, Commende $commende)
    {
         $id=$commende->getId();
            $em = $this->getDoctrine()->getManager();
       try {
          $em->remove($commende);
          $em->flush();
        } catch (\Exception $e) {
       return array('error' => true );
     }
        return array('ok' => true,'deletedId' => $id );
    }

 
}
