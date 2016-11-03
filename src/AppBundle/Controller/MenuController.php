<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Menu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * Menu controller.
 *
 */
class MenuController extends Controller
{
    /**
     * Lists all menu entities.
     *
     */
      /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $menus = $em->getRepository('AppBundle:Menu')->findLastMenus();
        $response = new JsonResponse($menus , 200);
         $response->headers->set('Content-Type', 'application/json');
        return $response;         
    }

    /**
     * Finds and displays a menu entity.
     *
     */
      /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function showAction(Menu $menu=null)
    {

       $em = $this->getDoctrine()->getManager();
        if (is_null($menu)) {
          $menu= $em->getRepository('AppBundle:Menu')->findTodayMenu();
        }
        $plats = $em->getRepository('AppBundle:Plat')->findAllPlats($menu);
         $response = new JsonResponse(array('menu' => $menu ,'menus'=>$plats), 200);
         $response->headers->set('Content-Type', 'application/json');
        return $response;  
    }

  
      /**
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function remettreAction(Menu $menu)
    {
       $em = $this->getDoctrine()->getManager();
       $dateObject = new \DateTime();
       $date = $dateObject->format('Y-m-d');  
       $newMenu= new Menu();
      $newMenu ->setDateSave(\DateTime::createFromFormat('Y-m-d',$date));
       try{  
        foreach ($menu->getPlats() as $plat) {
               $copy = clone $plat;
               $newMenu->addPlat( $copy);
         }        
         $em->persist($newMenu);
         $em->flush($newMenu);        
         } catch(Exception $e){
            $response = new JsonResponse(['success' => false], 500);
            $response->headers->set('Content-Type', 'application/json');
        return $response;     
      }  
         $plats = $em->getRepository('AppBundle:Plat')->findAllPlats($newMenu);
         $response = new JsonResponse(array('menu' => $newMenu ,'menus'=>$plats), 200);
         $response->headers->set('Content-Type', 'application/json');
          return $response;    
    }
}
