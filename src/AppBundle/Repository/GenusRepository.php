<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class GenusRepository
 * @package AppBundle\Repository
 * @noinspection PhpUnused
 */
class GenusRepository extends EntityRepository
{
    // find all ordered
    public function findAllOrderedBy()
    {
        return $this->createQueryBuilder('g')
            ->addOrderBy('g.updatedAt','DESC')
            ->getQuery()
            ->execute();
    }

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
            ->orWhere('g.amountOfNotes LIKE :filter')
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
            ->orWhere('g.amountOfNotes LIKE :filter')
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
            ->orWhere('g.amountOfNotes LIKE :filter')
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
            ->orWhere('g.amountOfNotes LIKE :filter')
            ->setParameter('filter', $filter)
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    // find by name
    public function findAllByNameAnywhere($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.name LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByNameStartingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.name LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByNameEndingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.name LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByNameExactWord($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.name LIKE :filter')
            ->setParameter('filter', $filter)
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    // find by subFamily
    public function findAllBySubFamilyAnywhere($filter)
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.subFamily', 's', 'WITH', 'g.subFamily = s.id')
            ->andWhere('s.name LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllBySubFamilyStartingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.subFamily', 's', 'WITH', 'g.subFamily = s.id')
            ->andWhere('s.name LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllBySubFamilyEndingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.subFamily', 's', 'WITH', 'g.subFamily = s.id')
            ->andWhere('s.name LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllBySubFamilyExactWord($filter)
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.subFamily', 's', 'WITH', 'g.subFamily = s.id')
            ->andWhere('s.name LIKE :filter')
            ->setParameter('filter', $filter)
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    // find by user
    public function findAlByUserAnywhere($filter)
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.user', 'u', 'WITH', 'g.user = u.id')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByUserStartingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.user', 'u', 'WITH', 'g.user = u.id')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByUserEndingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.user', 'u', 'WITH', 'g.user = u.id')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByUserExactWord($filter)
    {
        return $this->createQueryBuilder('g')
            ->innerJoin('g.user', 'u', 'WITH', 'g.user = u.id')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter', $filter)
            ->getQuery()
            ->execute();
    }

    // find by species count
    public function findAllBySpeciesCountAnywhere($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.speciesCount LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllBySpeciesCountStartingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.speciesCount LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllBySpeciesCountEndingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.speciesCount LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllBySpeciesCountExactWord($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.speciesCount LIKE :filter')
            ->setParameter('filter', $filter)
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    // find by discovered at
    public function findAllByDiscoveredAtAnywhere($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.firstDiscoveredAt LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByDiscoveredAtStartingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.firstDiscoveredAt LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByDiscoveredAtEndingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.firstDiscoveredAt LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByDiscoveredAtExactWord($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.firstDiscoveredAt LIKE :filter')
            ->setParameter('filter', $filter)
            ->addOrderBy('g.updatedAt', 'DESC')
            ->getQuery()
            ->execute();
    }

    // find all by amount of notes
    public function findAllByAmountOfNotesAnywhere($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.amountOfNotes LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%')
            ->getQuery()
            ->execute();
    }

    public function findAllByAmountOfNotesStartingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.amountOfNotes LIKE :filter')
            ->setParameter('filter', $filter.'%')
            ->getQuery()
            ->execute();
    }

    public function findAllByAmountOfNotesEndingWith($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.amountOfNotes LIKE :filter')
            ->setParameter('filter', '%'.$filter)
            ->getQuery()
            ->execute();
    }

    public function findAllByAmountOfNotesExactWord($filter)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.amountOfNotes LIKE :filter')
            ->setParameter('filter', $filter)
            ->getQuery()
            ->execute();
    }
}
