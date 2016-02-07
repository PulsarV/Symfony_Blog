<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminCommentController extends Controller
{
    protected $commentsPerPage = 25;

    /**
     * @Route("/admin/comments/{page}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="admin_comment_index")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('AppBundle:Comment')
            ->findAllCommentsPaginated(($page - 1) * $this->commentsPerPage, $this->commentsPerPage);

        return [
            'comments' => $comments,
            'page' => $page,
            'pagesCount' => ceil(count($comments) / $this->commentsPerPage),
        ];
    }
}
