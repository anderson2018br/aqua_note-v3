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

    public function findAllOrdered()
    {
        return $this->createQueryBuilder('u')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    // find all
    public function findAllByQueryAnywhere($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->orWhere('u.amountOfGenus LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->orWhere('u.amountOfSubFamilies LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->orWhere('u.amountOfNotes LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->orWhere('u.avatarFileName LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->orWhere('u.roles LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }
}
