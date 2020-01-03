<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserRepository extends EntityRepository
{
    public function findAuthenticatedUser($controller)
    {
        $token = $controller->get('security.token_storage')->getToken();
        $authenticatedUser = $token->getUsername();

        return $this->findOneBy(['username' => $authenticatedUser]);
    }
}
