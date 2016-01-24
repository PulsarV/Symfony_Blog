<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commentator;
use AppBundle\Entity\Comment;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/articles/searchblock", name="article_search_block")
     * @Method({"POST"})
     * @Template()
     */
    public function showSearchBlockAction()
    {
        $searchForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('article_search_prepare'))
            ->add('searchQuery', SearchType::class)
            ->getForm();

        return [
            'searchForm' => $searchForm->createView(),
        ];
    }

    /**
     * @Route("/articles/search", name="article_search_prepare")
     * @Method({"POST"})
     */
    public function checkSearchQueryAction(Request $request)
    {
        $searchForm = $this->createFormBuilder()
            ->add('searchQuery', SearchType::class)
            ->getForm();

        $searchForm->handleRequest($request);

        if ($searchForm->isValid()) {
            return $this->redirectToRoute('article_search', ['page' => 1, 'slug' => filter_var($searchForm->get('searchQuery')->getData(), FILTER_SANITIZE_STRING)]);
        }

        return $this->redirectToRoute('index_page');
    }

    /**
     * @Route("articles/{page}/search/{slug}", defaults={"page" = 1}, name="article_search")
     * @Method({"GET"})
     * @Template()
     */
    public function searchAction($page, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAllArticlesBySearchQueryPaginated($slug, ($page - 1) * $this->articlesPerPage, $this->articlesPerPage);
        return [
            'articles' => $articles,
            'page' => $page,
            'slug' => $slug,
            'pagesCount' => ceil(count($articles) / $this->articlesPerPage),
        ];
        return [
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

//        $comment = new Comment();
        //$commentator = new Commentator();
        //$comment->setArticle($article);
        //$comment->setCommentator($commentator);
//        $commentForm = $this->createForm('AppBundle\Form\CommentType', $comment);
//        $commentForm->handleRequest($request);

//        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($comment);
//            $em->flush();

//            return $this->redirectToRoute('article_show', ['slug' => $slug]);
//        }

        return [
            'article' => $article,
//            'commentForm' => $commentForm->createView(),
        ];
    }
}
