<?php

/*
 * This file is part of the UCS package.
 *
 * Copyright 2014 Nicolas Macherey (nicolas.macherey@gmail.com)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Handler;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * class AuthenticationSuccessHandler
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess( Request $request, TokenInterface $token )
    {
        $response = new JsonResponse(['success' => true, 'username' => $token->getUser()->getUsername()], 200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}