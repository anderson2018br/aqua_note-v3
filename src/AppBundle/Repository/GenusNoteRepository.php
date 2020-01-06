<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class GenusNoteRepository
 * @package AppBundle\Repository
 */
class GenusNoteRepository extends EntityRepository
{
    public function findAllOrdered()
    {
        return $this->createQueryBuilder('n')
            ->addOrderBy('n.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    // find all
    public function findAllByQueryAnywhere($filter)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.note LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->innerJoin('n.genus', 'g', 'WITH', 'n.genus = g.id')
            ->orWhere('g.name LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->innerJoin('n.user', 'u', 'WITH', 'n.user = u.id')
            ->orWhere('u.username LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->addOrderBy('n.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByQueryStartingWith($filter)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.note LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->innerJoin('n.genus', 'g', 'WITH', 'n.genus = g.id')
            ->orWhere('g.name LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->innerJoin('n.user', 'u', 'WITH', 'n.user = u.id')
            ->orWhere('u.username LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->addOrderBy('n.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByQueryEndingWith($filter)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.note LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->innerJoin('n.genus', 'g', 'WITH', 'n.genus = g.id')
            ->orWhere('g.name LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->innerJoin('n.user', 'u', 'WITH', 'n.user = u.id')
            ->orWhere('u.username LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->addOrderBy('n.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByQueryExactWord($filter)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.note LIKE :filter')
            ->setParameter('filter', $filter)
            ->innerJoin('n.genus', 'g', 'WITH', 'n.genus = g.id')
            ->orWhere('g.name LIKE :filter')
            ->setParameter('filter', $filter)
            ->innerJoin('n.user', 'u','WITH', 'n.user = u.id')
            ->orWhere('u.username LIKE :filter')
            ->setParameter('filter', $filter)
            ->addOrderBy('n.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }
}
