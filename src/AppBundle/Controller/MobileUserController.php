<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use AppBundle\Form\RequestType;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\AuthToken;
use AppBundle\Entity\Request as UserInvite;
class MobileUserController extends Controller
{
 
     /**
     * @Rest\View(serializerGroups={"auth-token"})
     * 
     */
    public function registerJsonAction(Request $request)
    {
        // 1) build the form
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();
        $form = $this->createForm(UserType::class, $user);
        // 2) handle the submit (will only happen on POST)
         $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
              if($em->getRepository('AppBundle:User')->findOneByEmail($user->getEmail()))
                return  array('error_code' =>'email_alredy_in_use');
        $user->setPlainPassword('provisional');
        $user=$this->register($user);
        $authToken=$this->postAuthToken($user);
        $em->persist($authToken);
        $em->flush();
        return  $authToken;  
        }
        return $form;
    }


   public function postAuthToken(User $user)
    {
        $authToken=AuthToken::create($user);
        $numero='+237'.$user->getUsername();
        $contacts=urlencode($numero);
       $url='https://api-public.mtarget.fr/api-sms.json?username=omegatelecombuilding&password=79sawbfF&msisdn='.$contacts.'&sender=Provisional&msg='.$authToken->getValue();  
        // $res = $this->get('http_request_maker')->sendOrGetData($url,null,'GET',false); 
        return  $authToken;
    }

    /**
     * @Rest\View(serializerGroups={"request"})
     * 
     */
    public function newJsonAction(Request $request)
    {
        $invite= new UserInvite($this->getMobileUser($request));
        $form = $this->createForm(RequestType::class,$invite);
         $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')->findOneByUsername($invite->getUsername());
         if ($user) {
            $tmp=$em->getRepository('AppBundle:Request')->findByUserParent($this->getMobileUser($request),$user);
            if(is_null($tmp)){
               $invite->setUser($user);
                $em->persist($invite);
                $em->flush();
               return $invite;
            }
            return $tmp;
          }
          $user= new User();
          $user->setUsername($invite->getUsername())
          ->setEmail($invite->getUsername())
          ->setPlainPassword('provisional')
          ->setParent($this->getMobileUser($request));
          $invite->setUser($this->register($user));
           $em->persist($invite);
           $em->flush();
         return $invite;
        }
        return $form;
    }



    /**
     * @Rest\View(serializerGroups={"request"})
     * 
     */
    public function acceptRefuseJsonAction(Request $request, UserInvite $invite)
    {
         $editForm = $this->createForm('AppBundle\Form\RequestType',$invite);
         $editForm ->submit($request->request->all());
        if ($editForm->isSubmitted() && $editForm->isValid()) {
           $em=$this->getDoctrine()->getManager();
           if ($invite->getStatus()=='REFUSED') {
               $invite->getUser()->setParent($invite->getUser());
               $em->remove($invite);
               $em->flush();
           }elseif ($invite->getStatus()=='ACCEPTED') {
               $invite->getUser()->setParent($invite->getParent());
               $em->flush();
           }
            return ['success'=>true];
        }         
        return $editForm;
    }




    public function register(User $user)
    {
        // 1) build the form
            $userManager = $this->get('fos_user.user_manager');
            $user->setEnabled(true);
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encoded);
            $userManager->updateUser($user);
         return $user;
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * 
     */
    public function editJsonAction(Request $request, User $user)
    {
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $user;
        }
        return $form;
    }

    /**
     * @Rest\View(serializerGroups={"user"})
     * 
     */
    public function showJsonAction(User $user)
    {
            return $user->getParent();
        
      
    }

    public function getMobileUser(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
         $user = $em->getRepository('AppBundle:User')->findOneById($request->headers->get('X-User-Id'));
        return $user;
    } 
}