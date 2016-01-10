<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    public function getPaginatedArticle($first, $max)
    {
        $dql = "SELECT art, aut
                FROM AppBundle:Article art
                JOIN art.author aut
                ORDER BY art.createdAt DESC";

        return new Paginator($this->getEntityManager()->createQuery($dql)->setFirstResult($first)->setMaxResults($max));
    }
}
