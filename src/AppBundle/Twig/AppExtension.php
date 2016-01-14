<?php

namespace AppBundle\Twig;

use Doctrine\Common\Persistence\ObjectManager;

class AppExtension extends \Twig_Extension
{
    protected $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function getName()
    {
        return 'app_extension';
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('all_categories', [$this, 'getAllCategories']),
            new \Twig_SimpleFunction('top_articles', [$this, 'getTopArticles']),
            new \Twig_SimpleFunction('recent_comments', [$this, 'getRecentComments']),
            new \Twig_SimpleFunction('tag_cloud_elements', [$this, 'getTagCloudElements'])
        ];
    }

    public function getAllCategories()
    {
        $categories = $this->em->getRepository('AppBundle:Category')->findAllCategoriesASC();

        return $categories;
    }

    public function getTopArticles()
    {
        $articles = $this->em->getRepository('AppBundle:Article')->findTopArticlesByRating();

        return $articles;
    }

    public function getRecentComments()
    {
        $comments = $this->em->getRepository('AppBundle:Comment')->findRecentCommentsByDate();

        return $comments;
    }

    public function getTagCloudElements()
    {
        $tags = $this->em->getRepository('AppBundle:Tag')->findAll();
        shuffle($tags);
        array_splice($tags, 50);
        return $tags;
    }
}