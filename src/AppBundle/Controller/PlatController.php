<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Plat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use AppBundle\Entity\Menu;
/**
 * Plat controller.
 *
 */
class PlatController extends Controller
{
    /**
     * Lists all plat entities.
     *
     */

    public function indexAction(Menu $menu=null)
    {
        $em = $this->getDoctrine()->getManager();
        if (is_null($menu)) {
          $menu= $em->getRepository('AppBundle:Menu')->findTodayMenu();
        }
        $plats = $em->getRepository('AppBundle:Plat')->findAllPlats($menu);
         $response = new JsonResponse($plats, 200);
         $response->headers->set('Content-Type', 'application/json');
        return $response;           
    }

     /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $plat = new Plat();
       $normalizer = new ObjectNormalizer();       
      if ( $request->getMethod()=="POST" ) {
         $data = $request->query->all();  
         $em = $this->getDoctrine()->getManager();                  
          $plat= $normalizer->denormalize($data, 'AppBundle\Entity\Plat');
          $dateObject = new \DateTime();
          $date = $dateObject->format('d-m-Y');          
           $menu= $em->getRepository('AppBundle:Menu')->findTodayMenu();
          if (is_null($menu)) {
            $menu= new Menu();
            $menu->addPlat( $plat)->setDateSave(\DateTime::createFromFormat('d-m-Y',$date));
            $em->persist($menu);
           }
          $plat->setMenu($menu->setDateSave(\DateTime::createFromFormat('d-m-Y',$date)));
          $em->persist($plat);
          $em->flush($plat);
           $response = new JsonResponse(['success' => true], 200);
           $response->headers->set('Content-Type', 'application/json');
        return $response;         
        }
   
        $response = new JsonResponse(array('action' => 'goToNewPage' ), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * Finds and displays a plat entity.
     *
     */
    public function showAction(Plat $plat)
    {
        $deleteForm = $this->createDeleteForm($plat);
         $response = new JsonResponse($plat, 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;   

       // return $this->render('plat/show.html.twig', array(
       //     'plat' => $plat,
       //     'delete_form' => $deleteForm->createView(),
        //));
    }

    /**
     * Displays a form to edit an existing plat entity.
     *
     */
     /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Plat $plat)
    {
          $normalizer = new ObjectNormalizer();       
      if ( $request->getMethod()=="PUT" ) {
         $data = $request->query->all(); 
         $file = $this->getRequest()->files->get('image');                   
         $plat= $normalizer->denormalize($data, 'AppBundle\Entity\Plat');
         $image= $plat->getImage();
         $image->setFile($file);
         $em = $this->getDoctrine()->getManager();
         $em->persist($plat);
         $em->flush($plat);
           $response = new JsonResponse(['success' => true, array('id' => $plat->getId())], 200);
           $response->headers->set('Content-Type', 'application/json');
          return $response;         
        }    
        $response = new JsonResponse(array('action' => 'goToEditPage','plat' => $plat), 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;  
    }

    /**
     * Deletes a plat entity.
     *
     */
     /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Plat $plat)
    {
      if ($request->getMethod()=="DELETE"&&$plat->getCommande()->isEmpty()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($plat);
            $em->flush($plat);
            $response = new JsonResponse(['success' => true], 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;  
        }  
            $response = new JsonResponse(['success' => false], 401);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
    }

    /**
     * Creates a form to delete a plat entity.
     *
     * @param Plat $plat The plat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Plat $plat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_plat_delete', array('id' => $plat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
