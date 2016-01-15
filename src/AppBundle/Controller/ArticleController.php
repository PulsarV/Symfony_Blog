<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{

    protected $articlesPerPage = 5;

    /**
     * @Route("/articles/{page}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="articleindex")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAllArticlesPaginated(($page - 1) * $this->articlesPerPage, $this->articlesPerPage);

        return [
            'articles' => $articles,
            'page' => $page,
            'pagesCount' => ceil(count($articles) / $this->articlesPerPage),
        ];
    }

    /**
     * @Route("/articles/{page}/category/{slug}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="articlebycategoryindex")
     * @Method({"GET"})
     * @Template("@App/Article/index.html.twig")
     */
    public function indexByCategoryAction($slug, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAllArticlesByCategoryPaginated($slug, ($page - 1) * $this->articlesPerPage, $this->articlesPerPage);

        return [
            'articles' => $articles,
            'page' => $page,
            'slug' => $slug,
            'pagesCount' => ceil(count($articles) / $this->articlesPerPage),
        ];
    }

    /**
     * @Route("/articles/{page}/author/{slug}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="articlebyauthorindex")
     * @Method({"GET"})
     * @Template("@App/Article/index.html.twig")
     */
    public function indexByAuthorAction($slug, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAllArticlesByAuthorPaginated($slug, ($page - 1) * $this->articlesPerPage, $this->articlesPerPage);

        return [
            'articles' => $articles,
            'page' => $page,
            'slug' => $slug,
            'pagesCount' => ceil(count($articles) / $this->articlesPerPage),
        ];
    }

    /**
     * @Route("/articles/{page}/tag/{slug}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="articlebytagindex")
     * @Method({"GET"})
     * @Template("@App/Article/index.html.twig")
     */
    public function indexByTagAction($slug, $page)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAllArticlesByTagPaginated($slug, ($page - 1) * $this->articlesPerPage, $this->articlesPerPage);

        return [
            'articles' => $articles,
            'page' => $page,
            'slug' => $slug,
            'pagesCount' => ceil(count($articles) / $this->articlesPerPage),
        ];
    }

    /**
     * @Route("/articles/{slug}/show", name="articleshow")
     * @Method({"GET"})
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findArticleBySlug($slug);

        return ['article' => $article];
    }
}
