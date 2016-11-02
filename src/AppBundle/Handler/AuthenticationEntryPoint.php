<?php

namespace AppBundle\Handler;

/* Imports */
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Class AuthenticationEntryPoint
 * Returns a 401 if the user is not logged in instead of redirecting to the login page
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
       // $response = new Response('', 401);
        $response = new JsonResponse(array('action' => 'goLogin'), 401);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}