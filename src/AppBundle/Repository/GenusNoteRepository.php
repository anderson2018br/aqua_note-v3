<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class GenusNoteRepository
 * @package AppBundle\Repository
 * @noinspection PhpUnused
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

    // find by genus
    public function findAllByGenusAnywhere($filter)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.genus', 'g', 'WITH', 'n.genus = g.id')
            ->andWhere('g.name LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->getQuery()
            ->execute();
    }

    public function findAllByGenusStartingWith($filter)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.genus', 'g', 'WITH', 'n.genus = g.id')
            ->andWhere('g.name LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->getQuery()
            ->execute();
    }

    public function findAllByGenusEndingWith($filter)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.genus', 'g', 'WITH', 'n.genus = g.id')
            ->andWhere('g.name LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->getQuery()
            ->execute();
    }

    public function findAllByGenusExactWord($filter)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.genus', 'g', 'WITH', 'n.genus = g.id')
            ->andWhere('g.name LIKE :filter')
            ->setParameter('filter', $filter)
            ->getQuery()
            ->execute();
    }

    // find by user
    public function findAllByUserAnywhere($filter)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.user', 'u', 'WITH', 'n.user = u.id')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->getQuery()
            ->execute();
    }

    public function findAllByUserStartingWith($filter)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.user', 'u', 'WITH', 'n.user = u.id')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->getQuery()
            ->execute();
    }

    public function findAllByUserEndingWith($filter)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.user', 'u', 'WITH', 'n.user = u.id')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->getQuery()
            ->execute();
    }

    public function findAllByUserExactWord($filter)
    {
        return $this->createQueryBuilder('n')
            ->innerJoin('n.user', 'u', 'WITH', 'n.user = u.id')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter', $filter)
            ->getQuery()
            ->execute();
    }

    // find by note
    public function findAllByNoteAnywhere($filter)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.note LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->getQuery()
            ->execute();
    }

    public function findAllByNoteStartingWith($filter)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.note LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->getQuery()
            ->execute();
    }

    public function findAllByNoteEndingWith($filter)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.note LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->getQuery()
            ->execute();
    }

    public function findAllByNoteExactWord($filter)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.note LIKE :filter')
            ->setParameter('filter', $filter)
            ->getQuery()
            ->execute();
    }
}
