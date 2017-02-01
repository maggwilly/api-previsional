<?php

namespace AppBundle\Handler;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
 use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
 use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;
 use Symfony\Component\HttpFoundation\RedirectResponse;
 use Doctrine\DBAL\Connection;

/**
 * class AuthenticationFailureHandler
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class LogoutSuccessHandler implements LogoutHandlerInterface, LogoutSuccessHandlerInterface
{

     private $conn;
     private $logoutTarget;
	  public function __construct(Connection $conn,$logoutTarget='/')
    {
        $this->conn = $conn;
        $this->logoutTarget=$logoutTarget;
       
    }

 /**
     * {@inheritdoc}
     */
    public function onLogoutSuccess(Request $request)
    {
   	
       // return new RedirectResponse($this->logoutTarget);
    }

 /**
     * Implementation for the LogoutHandlerInterface. Deletes all requested cookies.
     *
     * @param Request        $request
     * @param Response       $response
     * @param TokenInterface $token
     */
    public function logout(Request $request, Response $response, TokenInterface $token)
    {
         $user=$token->getUser();
         $this->deleteTokenByUsername($user->getUsername());
          $request->getSession()->invalidate();
    }

    public function deleteTokenByUsername($username)
    {
        $sql = 'DELETE FROM rememberme_token WHERE username=:username';
        $paramValues = array('username' => $username);
        $this->conn->executeUpdate($sql, $paramValues);
    }

}