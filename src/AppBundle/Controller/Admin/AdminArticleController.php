<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Article;
use AppBundle\Entity\Tag;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminArticleController extends Controller
{
    protected $articlesPerPage = 25;

    /**
     * @Route("/admin/articles/{page}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="admin_article_index")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')
            ->findAllArticlesPaginated(($page - 1) * $this->articlesPerPage, $this->articlesPerPage);

        return [
            'articles' => $articles,
            'page' => $page,
            'pagesCount' => ceil(count($articles) / $this->articlesPerPage),
        ];
    }

    /**
     * @Route("/admin/articles/new", name="admin_article_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $newForm = $this->createForm('AppBundle\Form\Admin\ArticleType', $article);
        $newForm->handleRequest($request);
        if ($newForm->isValid() && (null !== $article->getTitleImage())) {
            $article->getTitleImage()->move(__DIR__.'/../../../../web/uploads', $article->getTitleImage()->getClientOriginalName());
            $article->setTitleImage($article->getTitleImage()->getClientOriginalName());
            $em = $this->getDoctrine()->getManager();
            foreach ($article->getTags() as $tag) {
                $tag->addArticle($article);
                $em->persist($tag);
            }
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('admin_article_index');
        }

        return [
            'article' => $article,
            'newForm' => $newForm->createView(),
        ];
    }

    /**
     * @Route("/admin/articles/{slug}/edit", name="admin_article_edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findOneBy(['slug' => $slug]);
        $editForm = $this->createForm('AppBundle\Form\Admin\ArticleType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('admin_article_index');
        }

        return [
            'editForm' => $editForm->createView(),
        ];
    }
//
//    /**
//     * @Route("/config/categories/{slug}/delete", name="admin_category_delete")
//     * @Method("DELETE")
//     */
//    public function deleteAction(Request $request, $slug)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $category = $em->getRepository('AppBundle:Category')->findOneBy(['slug' => $slug]);
//        $deleteForm = $this->createForm('AppBundle\Form\CategoryType', $category);
//        $deleteForm->handleRequest($request);
//
//        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($category);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('admin_category_index', []);
//    }
//
//    /**
//     * @param Category $category The Category entity
//     *
//     * @return \Symfony\Component\Form\Form The form
//     */
//    private function createDeleteForm(Category $category)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('admin_category_delete', ['slug' => $category->getSlug()]))
//            ->setMethod('DELETE')
//            ->getForm()
//            ;
//    }
}
