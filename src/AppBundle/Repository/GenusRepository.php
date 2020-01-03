<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GenusRepository extends EntityRepository
{
    // find all anywhere
    public function findAllByQueryAnywhere($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.name LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->innerJoin('g.subFamily', 's', 'WITH', 'g.subFamily = s.id')
            ->orWhere('s.name LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->innerJoin('g.user', 'u', 'WITH', 'g.user = u.id')
            ->orWhere('u.username LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->orWhere('g.speciesCount LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->orWhere('g.firstDiscoveredAt LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByQueryStartingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.name LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->innerJoin('g.subFamily', 's', 'WITH', 'g.subFamily = s.id')
            ->orWhere('s.name LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->innerJoin('g.user', 'u', 'WITH', 'g.user = u.id')
            ->orWhere('u.username LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->orWhere('g.speciesCount LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->orWhere('g.firstDiscoveredAt LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByQueryEndingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.name LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->innerJoin('g.subFamily', 's', 'WITH', 'g.subFamily = s.id')
            ->orWhere('s.name LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->innerJoin('g.user', 'u', 'WITH', 'g.user = u.id')
            ->orWhere('u.username LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->orWhere('g.speciesCount LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->orWhere('g.firstDiscoveredAt LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByQueryExactWord($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.name LIKE :filter')
            ->setParameter('filter', $filter)
            ->innerJoin('g.subFamily', 's', 'WITH', 'g.subFamily = s.id')
            ->orWhere('s.name LIKE :filter')
            ->setParameter('filter', $filter)
            ->innerJoin('g.user', 'u', 'WITH', 'g.user = u.id')
            ->orWhere('u.username LIKE :filter')
            ->setParameter('filter', $filter)
            ->orWhere('g.speciesCount LIKE :filter')
            ->setParameter('filter', $filter)
            ->orWhere('g.firstDiscoveredAt LIKE :filter')
            ->setParameter('filter', $filter)
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }
}
