<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    /**
     * @Route("/articles/{articleSlug}/comments/{commentSlug}/edit", name="comment_edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, $articleSlug, $commentSlug)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('AppBundle:Comment')->findCommentBySlug($commentSlug);

        $editForm = $this->createForm('AppBundle\Form\CommentType', $comment);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('article_show', ['slug' => $articleSlug]).'#comments');
        }

        return [
            'editForm' => $editForm->createView(),
            'articleSlug' => $articleSlug,
        ];
    }

    /**
     * @Route("/articles/{articleSlug}/comments/{commentSlug}/delete", name="comment_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, $articleSlug, $commentSlug)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('AppBundle:Comment')->findCommentBySlug($commentSlug);
        $author = $comment->getAuthor();
        $article = $comment->getArticle();
        $author->removeComment($comment);
        $article->removeComment($comment);
        $em->remove($comment);
        $em->flush();

        return $this->redirect($this->generateUrl('article_show', ['slug' => $articleSlug]).'#comments');
    }
}
