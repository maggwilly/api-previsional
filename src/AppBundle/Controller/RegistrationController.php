<?php

namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
/**
 * @Security("is_granted('ROLE_ADMIN')")
*/
class RegistrationController extends BaseController
    {



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

      /*    if ($confirmationEnabled) {
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