<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminTagController extends Controller
{
    protected $tagsPerPage = 25;

    /**
     * @Route("/admin/tags/{page}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="admin_tag_index")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('AppBundle:Tag')
            ->findAllTagsPaginated(($page - 1) * $this->tagsPerPage, $this->tagsPerPage);

        return [
            'tags' => $tags,
            'page' => $page,
            'pagesCount' => ceil(count($tags) / $this->tagsPerPage),
        ];
    }
}
