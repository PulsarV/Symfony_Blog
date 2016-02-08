<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
    public function findAllCommentsPaginated($first, $max)
    {
        $dql = "SELECT co
                FROM AppBundle:Comment co
                JOIN co.author au
                ORDER BY co.createdAt DESC";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setFirstResult($first)
            ->setMaxResults($max);

        return new Paginator($query);
    }

    public function findRecentCommentsByDate()
    {
        $dql = "SELECT co
                FROM AppBundle:Comment co
                ORDER BY co.createdAt DESC";
        $query = $this->getEntityManager()
            ->createQuery($dql)
            ->setFirstResult(0)
            ->setMaxResults(5)
            ->getResult();

        return $query;
    }
}
