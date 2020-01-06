<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SubFamilyRepository extends EntityRepository
{
    // find ordered
    public function findAllOrderedBy()
    {
        return $this->createQueryBuilder('s')
            ->addOrderBy('s.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    // find all
    public function findAllByQueryAnywhere($filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->innerJoin('s.user', 'u', 'WITH', 's.user = u.id')
            ->orWhere('u.username LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->orWhere('s.description LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByQueryStartingWith($filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->innerJoin('s.user', 'u', 'WITH', 's.user = u.id')
            ->orWhere('u.username LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->orWhere('s.description LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByQueryEndingWith($filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->innerJoin('s.user', 'u', 'WITH', 's.user = u.id')
            ->orWhere('u.username LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->orWhere('s.description LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByQueryExactWord($filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name LIKE :filter')
            ->setParameter('filter', $filter)
            ->innerJoin('s.user', 'u', 'WITH', 's.user = u.id')
            ->orWhere('u.username LIKE :filter')
            ->setParameter('filter', $filter)
            ->orWhere('s.description LIKE :filter')
            ->setParameter('filter', $filter)
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    // find by name
    public function findAllByNameAnywhere($filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByNameStartingWith($filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByNameEndingWith($filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByNameExactWord($filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.name LIKE :filter')
            ->setParameter('filter', $filter)
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    // find by user
    public function findAllByUserAnywhere($filter)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.user', 'u', 'WITH', 's.user = u.id')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->addOrderBy('s.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByUserStartingWith($filter)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.user', 'u', 'WITH', 's.user = u.id')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByUserEndingWith($filter)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.user', 'u', 'WITH', 's.user = u.id')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->addOrderBy('s.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByUserExactWord($filter)
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.user', 'u', 'WITH','s.user = u.id')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter', $filter)
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    // find by description
    public function findAllByDescriptionAnywhere($filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.description LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByDescriptionStartingWith($filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.description LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByDescriptionEndingWith($filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.description LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByDescriptionExactWord($filter)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.description LIKE :filter')
            ->setParameter('filter',$filter)
            ->addOrderBy('s.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }
}
