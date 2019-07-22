<?php

namespace AppBundle\Controller;
use AppBundle\Entity\PointVente;
use AppBundle\Entity\Rendezvous;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
/**
 * Rendezvous controller.
 *
 */
class RendezvousController extends Controller
{
    /**
     * Lists all rendezvous entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rendezvouses = $em->getRepository('AppBundle:Rendezvous')->findAll();

        return $this->render('rendezvous/index.html.twig', array(
            'rendezvouses' => $rendezvouses,
        ));
    }


    /**
     * @Rest\View(serializerGroups={"rendezvous"})
     */
    public function indexJsonAction(Request $request)
    {
            $start=$request->query->get('start');
            $keys=$request->query->get('keys');
        if (count_chars($keys)>0) {
             $keys=explode(".", $keys);
         }else $keys=[0];     
         $user=$this->getUser();
          $rendezvous = $this->getDoctrine()->getManager()->getRepository('AppBundle:Rendezvous')->findByUser($user,$keys);
        return  $rendezvous;
    }

    /**
     * Creates a new rendezvous entity.
     *
     */
    public function newAction(Request $request)
    {
        $rendezvous = new Rendezvous();
        $form = $this->createForm('AppBundle\Form\RendezvousType', $rendezvous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rendezvous);
            $em->flush();

            return $this->redirectToRoute('rendezvous_show', array('id' => $rendezvous->getId()));
        }

        return $this->render('rendezvous/new.html.twig', array(
            'rendezvous' => $rendezvous,
            'form' => $form->createView(),
        ));
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
            if($rendezvous->getUser()==null)
                  $rendezvous->setUser($this->getUser());
            if ($em->getRepository('AppBundle:Rendezvous')->find($rendezvous->getId())==null) {
                 $em->persist($rendezvous);
            }          
            $em->flush();
            return $rendezvous;
        }

        return  $form;
    }

public function makeUp(Request $request,$setId=true){
    $rendezvous= $request->request->all();
    if (array_key_exists('user', $rendezvous)&&is_array($rendezvous['user']))
        $rendezvous['user']=$rendezvous['user']['id'];
      if (array_key_exists('pointVente', $rendezvous)&&is_array($rendezvous['pointVente']))
        $rendezvous['pointVente']=$rendezvous['pointVente']['id'];
      else $rendezvous['pointVente']=$rendezvous['id'];
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
            return $rendezvous;
        }
        return $editForm;
    }
    /**
     * Finds and displays a rendezvous entity.
     *
     */
    public function showAction(Rendezvous $rendezvous)
    {
        $deleteForm = $this->createDeleteForm($rendezvous);

        return $this->render('rendezvous/show.html.twig', array(
            'rendezvous' => $rendezvous,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing rendezvous entity.
     *
     */
    public function editAction(Request $request, Rendezvous $rendezvous)
    {
        $deleteForm = $this->createDeleteForm($rendezvous);
        $editForm = $this->createForm('AppBundle\Form\RendezvousType', $rendezvous);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rendezvous_edit', array('id' => $rendezvous->getId()));
        }

        return $this->render('rendezvous/edit.html.twig', array(
            'rendezvous' => $rendezvous,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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

    /**
     * Deletes a rendezvous entity.
     *
     */
    public function deleteAction(Request $request, PointVente $pointVente)
    {
        $form = $this->createDeleteForm($rendezvous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rendezvous);
            $em->flush();
        }

        return $this->redirectToRoute('rendezvous_index');
    }

    /**
     * Creates a form to delete a rendezvous entity.

     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Rendezvous $rendezvous)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rendezvous_delete', array('id' => $rendezvous->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}
