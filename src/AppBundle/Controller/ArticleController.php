<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Article;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
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
     * @Route("/articles/searchblock", name="article_search_block")
     * @Method({"POST"})
     * @Template()
     */
    public function showSearchBlockAction()
    {
        $searchForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('article_search_prepare'))
            ->add('searchQuery', SearchType::class, ['attr' => ['placeholder' => 'What are you looking for?']])
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
     * @Template("@App/Article/index.html.twig")
     */
    public function indexBySearchResultAction($page, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAllArticlesBySearchQueryPaginated($slug, ($page - 1) * $this->articlesPerPage, $this->articlesPerPage);
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
        $currentAuthor = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findArticleBySlug($slug);

        $comment = new Comment();
        $commentForm = $this->createForm('AppBundle\Form\CommentType', $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $article->getComments()->add($comment);
            $comment->setArticle($article);
            $comment->setAuthor($currentAuthor);
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('article_show', ['slug' => $slug]).'#comments');
        }

        if (!$article->getRaters()->contains($currentAuthor)) {
            $ratingForm = $this->createFormBuilder()
                ->add('rating', ChoiceType::class, [
                    'attr' => ['hidden' => true],
                    'label' => false,
                    'expanded' => true,
                    'multiple' => false,
                    'choices' => ['1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5],
                    'choices_as_values' => true,
                ])
                ->getForm();

            $ratingForm->handleRequest($request);
            if ($ratingForm->isValid()) {
                $article->setRating($ratingForm->getData()['rating']);
                $article->addRater($currentAuthor);
                $em->flush();

                return $this->redirect($this->generateUrl('article_show', ['slug' => $slug]).'#comments');
            }
            return [
                'article' => $article,
                'ratingForm' => $ratingForm->createView(),
                'commentForm' => $commentForm->createView(),
            ];
        }

        return [
            'article' => $article,
            'commentForm' => $commentForm->createView(),
        ];
    }
}
