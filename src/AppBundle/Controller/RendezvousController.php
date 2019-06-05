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
         $em = $this->getDoctrine()->getManager();
         $user=$this->getUser();
         $pointVentes = $em->getRepository('AppBundle:PointVente')->findByUser($user, $start,true,null,null,$keys);
         $rendezvous=[];
         foreach ($pointVentes as $key => $pointVente) {
          $rendezvous[]= $this->get('previsonal_client')
          ->dateProchaineCommende($pointVente)->setUser($user);
          //$pointVente->setRendezvous($rendezvous);
         }
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
        $user=$this->getUser();
        $rendezvous = new Rendezvous(null,null,$user);
        $form = $this->createForm('AppBundle\Form\RendezvousType', $rendezvous);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($rendezvous);
            $em->flush();
            return $rendezvous;
        }

        return  array('error' => true );
    }

    /**
     * @Rest\View(serializerGroups={"rendezvous"})
     * 
     */
    public function editJsonAction(Request $request, PointVente $pointVente)
    {
        $user=$this->getUser();
        $rendezvous=$pointVente->getRendezvous()==null?new Rendezvous(null,$pointVente,$user):$pointVente->getRendezvous();
        $editForm = $this->createForm('AppBundle\Form\RendezvousType', $rendezvous);
        $editForm->submit($request->request->all(),false);
        if ( $editForm->isValid()) {
            $pointVente->setRendezvous($rendezvous);
            $this->getDoctrine()->getManager()->flush();
            return $pointVente->getRendezvous();
        }
        return $editForm;//array('error' => true );
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
    public function deleteJsonAction(Request $request, PointVente $pointVente)
    {
           $id=$pointVente->getId();
       try {
            $em = $this->getDoctrine()->getManager();
            $pointVente->setRendezvous(null);        
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
