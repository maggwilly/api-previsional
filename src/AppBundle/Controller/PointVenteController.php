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
     * @Rest\View(serializerGroups={"pointvente"})
     */
    public function indexJsonAction(Request $request)
    {
        $order=$request->query->get('order');
        $start=$request->query->get('start');
         $em = $this->getDoctrine()->getManager();
         $user=$this->getMobileUser($request);
         $pointVentes = $em->getRepository('AppBundle:PointVente')->findByUser($user,$start);
        return  $pointVentes ;
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
     * @Rest\View(serializerGroups={"full"})
     * 
     */
    public function newAJsonction(Request $request)
    {
        $user=$this->getMobileUser($request);
        $pointVente = new PointVente($user);
        $form = $this->createForm('AppBundle\Form\PointVenteType', $pointVente);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pointVente);
            $em->flush();
            return $pointVente;
        }

        return  array(
            'status' => 'error');
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
     * @Rest\View(serializerGroups={"full"})
     * 
     */
    public function showJsonAction(Request $request,PointVente $pointVente)
    {
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

    public function deleteJsonAction(Request $request, PointVente $pointVente)
    {
            $em = $this->getDoctrine()->getManager();
       try {
          $em->remove($pointVente);
          $em->flush();
        } catch (\Exception $e) {
       return array('status' => "error" );
     }

        return array('status' => "ok" );
    }
    
    /**
     * Creates a form to delete a pointVente entity.
     *
     * @param PointVente $pointVente The pointVente entity
     *
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

        public function getMobileUser(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
          $user = $em->getRepository('AppBundle:User')->findOneById($request->headers->get('X-User-Id'));
        return $user;
    }  
}
