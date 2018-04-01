<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
/**
 * @Security("is_granted('ROLE_ADMIN')")
*/
class UserController extends Controller
{


     /**
     * Lists all article entities.
     *
     */
    public function indexAction()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
         $users = $em->getRepository('AppBundle:User')->findAll();
        return $this->container->get('templating')->renderResponse('user/index.html.twig', array(
            'users' => $users,
        ));
    }


    /**
     * Displays a form to edit an existing partie entity.
     */
    public function toggleUserAction( User $user)
    {
           $em = $this->container->get('doctrine.orm.entity_manager');
           $locked=is_null($user->getLocked())?false:$user->getLocked();
           $user->setLocked(!$locked);
           $em->flush();
        return $this->redirectToRoute('user_index');
    }





    /**
     * Displays a form to edit an existing objectif entity.
     *
     */
    public function editAction(Request $request, User $user)
    {
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);
        $em = $this->container->get('doctrine.orm.entity_manager');
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em ->flush();
         return $this->redirectToRoute('user_index');
        }
        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
        ));
    }

}