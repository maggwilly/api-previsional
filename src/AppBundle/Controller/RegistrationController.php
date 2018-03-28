<?php

namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends BaseController
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
           $user->setLocked(!$user->getLocked());
           $em->flush();
        return $this->container->get('templating')->renderResponse('user/index.html.twig', array(
            'users' => $users,
        ));
    }

        public function registerAction()
        {
            $em = $this->container->get('doctrine.orm.entity_manager');
          
            $form = $this->container->get('fos_user.registration.form');
            $formHandler = $this->container->get('fos_user.registration.form.handler');
            $confirmationEnabled = $this->container->getParameter('fos_user.registration.confirmation.enabled');

            $process = $formHandler->process($confirmationEnabled);
            if ($process) {
                $user = $form->getData();

                /*****************************************************
                 * Add new functionality (e.g. log the registration) *
                 *****************************************************/
                $this->container->get('logger')->info(
                    sprintf('New user registration: %s', $user)
                );

 /*              if ($confirmationEnabled) {
                    $this->container->get('session')->set('fos_user_send_confirmation_email/email', $user->getEmail());
                    $route = 'fos_user_registration_check_email';
                } else {
                    $this->authenticateUser($user);
                    $route = 'fos_user_registration_confirmed';
                }*/
                $route = 'fos_user_registration_register';
                $this->setFlash('fos_user_success', 'registration.flash.user_created');
                $url = $this->container->get('router')->generate($route);

                return new RedirectResponse($url);
            }

            return $this->container->get('templating')->renderResponse('FOSUserBundle:Registration:register.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }