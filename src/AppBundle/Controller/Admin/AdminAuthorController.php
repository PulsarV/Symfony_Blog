<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminAuthorController extends Controller
{
    protected $autorsPerPage = 25;

    /**
     * @Route("/admin/authors/{page}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="admin_author_index")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $authors = $em->getRepository('AppBundle:Author')
            ->findAllAutorsPaginated(($page - 1) * $this->autorsPerPage, $this->autorsPerPage);

        return [
            'authors' => $authors,
            'page' => $page,
            'pagesCount' => ceil(count($authors) / $this->autorsPerPage),
        ];
    }
}
