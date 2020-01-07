<?php
/** @noinspection PhpUndefinedMethodInspection */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class UserRepository
 * @package AppBundle\Repository
 * @noinspection PhpUnused
 */
class UserRepository extends EntityRepository
{
    public function findAuthenticatedUser($controller)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $token = $controller->get('security.token_storage')->getToken();
        /** @noinspection PhpUndefinedMethodInspection */
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
            ->orWhere('u.totalAmountOfCreatedObjects LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->orWhere('u.avatarFileName LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->orWhere('u.roles LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByQueryStartingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter',$filter.'%')
            ->orWhere('u.amountOfGenus LIKE :filter')
            ->setParameter('filter',$filter.'%')
            ->orWhere('u.amountOfSubFamilies LIKE :filter')
            ->setParameter('filter',$filter.'%')
            ->orWhere('u.amountOfNotes LIKE :filter')
            ->setParameter('filter',$filter.'%')
            ->orWhere('u.totalAmountOfCreatedObjects LIKE :filter')
            ->setParameter('filter',$filter.'%')
            ->orWhere('u.avatarFileName LIKE :filter')
            ->setParameter('filter',$filter.'%')
            ->orWhere('u.roles LIKE :filter')
            ->setParameter('filter','["'.$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByQueryEndingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->orWhere('u.amountOfGenus LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->orWhere('u.amountOfSubFamilies LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->orWhere('u.amountOfNotes LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->orWhere('u.totalAmountOfCreatedObjects LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->orWhere('u.avatarFileName LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->orWhere('u.roles LIKE :filter')
            ->setParameter('filter','%'.$filter.'"]')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByQueryExactWord($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter',$filter)
            ->orWhere('u.amountOfGenus LIKE :filter')
            ->setParameter('filter',$filter)
            ->orWhere('u.amountOfSubFamilies LIKE :filter')
            ->setParameter('filter',$filter)
            ->orWhere('u.amountOfNotes LIKE :filter')
            ->setParameter('filter',$filter)
            ->orWhere('u.totalAmountOfCreatedObjects LIKE :filter')
            ->setParameter('filter',$filter)
            ->orWhere('u.avatarFileName LIKE :filter')
            ->setParameter('filter',$filter)
            ->orWhere('u.roles LIKE :filter')
            ->setParameter('filter','["'.$filter.'"]')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    // find by username
    public function findAllByUsernameAnywhere($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByUsernameStartingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter',$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByUsernameEndingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByUsernameExactWord($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :filter')
            ->setParameter('filter',$filter)
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    // find by genus amount
    public function findAllByAmountOfGenusAnywhere($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.amountOfGenus LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByAmountOfGenusStartingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.amountOfGenus LIKE :filter')
            ->setParameter('filter',$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByAmountOfGenusEndingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.amountOfGenus LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByAmountOfGenusExactWord($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.amountOfGenus LIKE :filter')
            ->setParameter('filter',$filter)
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    // find by amount of subFamilies
    public function findAllByAmountOfSubFamiliesAnywhere($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.amountOfSubFamilies LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByAmountOfSubFamiliesStartingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.amountOfSubFamilies LIKE :filter')
            ->setParameter('filter',$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByAmountOfSubFamiliesEndingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.amountOfSubFamilies LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByAmountOfSubFamiliesExactWord($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.amountOfSubFamilies LIKE :filter')
            ->setParameter('filter',$filter)
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    // find by amount of notes
    public function findAllByAmountOfNotesAnywhere($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.amountOfNotes LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByAmountOfNotesStartingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.amountOfNotes LIKE :filter')
            ->setParameter('filter',$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByAmountOfNotesEndingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.amountOfNotes LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByAmountOfNotesExactWord($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.amountOfNotes LIKE :filter')
            ->setParameter('filter',$filter)
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    // find by total amount
    public function findAllByTotalAmountOfCreatedObjectsAnywhere($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.totalAmountOfCreatedObjects LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByTotalAmountOfCreatedObjectsStartingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.totalAmountOfCreatedObjects LIKE :filter')
            ->setParameter('filter',$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByTotalAmountOfCreatedObjectsEndingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.totalAmountOfCreatedObjects LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByTotalAmountOfCreatedObjectsExactWord($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.totalAmountOfCreatedObjects LIKE :filter')
            ->setParameter('filter',$filter)
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    // find by avatar file name
    public function findAllByAvatarFileNameAnywhere($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.avatarFileName LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByAvatarFileNameStartingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.avatarFileName LIKE :filter')
            ->setParameter('filter',$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByAvatarFileNameEndingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.avatarFileName LIKE :filter')
            ->setParameter('filter','%'.$filter)
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByAvatarFileNameExactWord($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.avatarFileName LIKE :filter')
            ->setParameter('filter',$filter)
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    // find by roles
    public function findAllByRolesAnywhere($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :filter')
            ->setParameter('filter','%'.$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByRolesStartingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :filter')
            ->setParameter('filter','["'.$filter.'%')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByRolesEndingWith($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :filter')
            ->setParameter('filter','%'.$filter.'"]')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllByRolesExactWord($filter)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :filter')
            ->setParameter('filter','["'.$filter.'"]')
            ->addOrderBy('u.totalAmountOfCreatedObjects','DESC')
            ->getQuery()
            ->execute();
    }

}
