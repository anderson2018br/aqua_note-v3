<?php

namespace AppBundle\Services;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class CheckAuthorization
 * @package AppBundle\Services
 * @noinspection PhpUnused
 */
class CheckAuthorization extends Controller
{
    public function checkAuthorization($object, $message)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')
            ->findAuthenticatedUser($this->container);
        if (($object->getUser()->getUsername() != $user->getUsername()) && !in_array('ROLE_ADMIN', $user->getRoles()))
        {
            throw $this->createAccessDeniedException($message);
        }
    }

    public function checkNonObjectAuthorization()
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')
            ->findAuthenticatedUser($this->container);

        if (!in_array('ROLE_ADMIN', $user->getRoles()))
        {
            throw $this->createAccessDeniedException("You are not allowed to access this page");
        }
    }
}
