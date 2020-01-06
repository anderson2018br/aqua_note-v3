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
}
