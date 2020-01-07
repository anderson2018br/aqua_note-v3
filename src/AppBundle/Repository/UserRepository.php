<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function findAuthenticatedUser($controller)
    {
        $token = $controller->get('security.token_storage')->getToken();
        $authenticatedUser = $token->getUsername();
        return $this->findOneBy(['username' => $authenticatedUser]);
    }
//
    public function findAllOrdered()
    {
        return $this->createQueryBuilder('u')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }
}
