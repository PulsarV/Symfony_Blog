<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminCommentatorController extends Controller
{
    protected $commentatorsPerPage = 25;

    /**
     * @Route("/config/commentators/{page}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="admincommentatorindex")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $commentators = $em->getRepository('AppBundle:Commentator')
            ->findAllCommentatorsPaginated(($page - 1) * $this->commentatorsPerPage, $this->commentatorsPerPage);

        return [
            'commentators' => $commentators,
            'page' => $page,
            'pagesCount' => ceil(count($commentators) / $this->commentatorsPerPage),
        ];
    }
}
