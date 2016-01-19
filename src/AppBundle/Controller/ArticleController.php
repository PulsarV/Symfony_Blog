<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commentator;
use AppBundle\Entity\Comment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{

    protected $articlesPerPage = 5;

    /**
     * @Route("/articles/{page}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="article_index")
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
     * @Route("/articles/{page}/category/{slug}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="article_bycategory_index")
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
     * @Route("/articles/{page}/author/{slug}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="article_byauthor_index")
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
     * @Route("/articles/{page}/tag/{slug}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="article_bytag_index")
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
     * @Route("/articles/{slug}/show", name="article_show")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function showAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findArticleBySlug($slug);

        $comment = new Comment();
        //$commentator = new Commentator();
        //$comment->setArticle($article);
        //$comment->setCommentator($commentator);
        $commentForm = $this->createForm('AppBundle\Form\CommentType', $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
//            $em->persist($comment);
//            $em->flush();

            return $this->redirectToRoute('article_show', ['slug' => $slug]);
        }

        return [
            'article' => $article,
            'commentForm' => $commentForm->createView(),
        ];
    }
}
