<?php

namespace AppBundle\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

/**
 * class AuthenticationFailureHandler
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class AuthenticationFailureHandler implements AuthenticationFailureHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure( Request $request, AuthenticationException $exception )
    {
        $response = new JsonResponse(['success' => false], 401);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}