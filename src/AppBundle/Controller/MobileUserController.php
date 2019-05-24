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
    public function register(User $user)
    {
        if(is_null($user->getUsername())||
            !is_string($user->getUsername())||
            count_chars($user->getUsername())<9)
               return null;
            $userManager = $this->get('fos_user.user_manager');
            $user->setEnabled(true);
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($encoded);
            $userManager->updateUser($user);
         return $user;
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
     * @Rest\View(serializerGroups={"user"})
     * 
     */
    public function newJsonAction(Request $request)
    {
        $user=$this->getUser();
        $invite= new UserInvite($user);
        $form = $this->createForm(RequestType::class,$invite);
         $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $touser = $em->getRepository('AppBundle:User')->findOneByUsername($invite->getUsername());
         if ($touser) {
            if($user->getId()==$touser->getId())
               return array( ); 
            $tmp=$em->getRepository('AppBundle:Request')->findByUserParent($user,$touser);
            if(is_null($tmp)){
               $invite->setUser($touser);
                $em->persist($invite);
                $em->flush();
               return $invite;
            }
            return $tmp;
          }
          $touser= new User();
          $touser->setUsername($invite->getUsername())
          ->setEmail($invite->getUsername())
          ->setNom($invite->getNom())
          ->setPlainPassword('provisional')
          ->setParent($touser);
          $touser=$this->register($touser);
          if(is_null($touser))
             return array( );
          $invite->setUser($touser);
           $em->persist($invite);
           $em->flush();
         return $invite;
        }
        return $form;
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
    public function indexJsonAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
         $user=$this->getUser();
         $users = $em->getRepository('AppBundle:User')->findByUser($user);
        return array('users' =>$users ,'requests' =>$user->getSendRequests() );
    }


    /**
     * @Rest\View(serializerGroups={"user"})
     * 
     */
    public function showJsonAction(User $user)
    {
      return  array('parent' =>$user->getParent() ,'receiveRequests' =>$user->getReceiveRequests());;  
    }


   /**
     * @Rest\View()
     * 
     */
public function deleteRequestJsonAction(Request $request, UserInvite $invite)
{
   $id=$invite->getId();
   $em = $this->getDoctrine()->getManager();    
       try {
          $em->remove($invite);
          $em->flush();
        } catch (\Exception $e) {
       return array('error' => true );
     }

      return array('ok' => true,'deletedId' => $id );
    }


   /**
     * @Rest\View()
     * 
     */
    public function acceptRequestJsonAction(Request $request, UserInvite $invite)
    {
         $id=$invite->getId();
        $user=$this->getUser();
         $user->setParent($invite->getParent());
         $em= $this->getDoctrine()->getManer();
          try {
         foreach ($user->getReceiveRequests() as $key => $value) {
            $em->remove($value);
             }
           $em->flush();  
       } catch (\Exception $e) {
       return array('error' => true );
     }
      return array('ok' => true,'deletedId' => $id );
      }

   /**
     * @Rest\View()
     * 
     **/
public function deleteUserJsonAction(Request $request, User $user)
{
     $user->setParent($user);
     $em = $this->getDoctrine()->getManager()->flush();    
      return array('ok' => true,'deletedId' => $user->getId() );
    }

}