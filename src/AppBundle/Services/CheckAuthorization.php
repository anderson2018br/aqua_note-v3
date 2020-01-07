<?php

namespace AppBundle\Services;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class CheckAuthorization
 * @package AppBundle\Services
 * @noinspection PhpUnused
 */
class CheckAuthorization
{
    private $container;
    private $entityManager;

    public function __construct(ContainerInterface $container,EntityManagerInterface $entityManager)
    {
        $this->container = $container;
        $this->entityManager = $entityManager;
    }

    public function checkAuthorization($object, $message)
    {
        $user = $this->entityManager->getRepository('AppBundle:User')
            ->findAuthenticatedUser($this->container);
        /** @noinspection PhpUndefinedMethodInspection */
        if (($object->getUser()->getUsername() != $user->getUsername()) && !in_array('ROLE_ADMIN', $user->getRoles()))
        {
            throw new AccessDeniedException($message);
        }
    }

    public function checkNonObjectAuthorization()
    {
        $user = $this->entityManager->getRepository('AppBundle:User')
            ->findAuthenticatedUser($this->container);

        if (!in_array('ROLE_ADMIN', $user->getRoles()))
        {
            throw new AccessDeniedException("You are not allowed to access this page");
        }
    }
}
