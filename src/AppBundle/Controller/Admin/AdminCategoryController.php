<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminCategoryController extends Controller
{
    protected $categoriesPerPage = 25;

    /**
     * @Route("/config/categories/{page}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="admincategoryindex")
     * @Method({"GET"})
     * @Template()
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')
            ->findAllCategoriesPaginated(($page - 1) * $this->categoriesPerPage, $this->categoriesPerPage);

        return [
            'categories' => $categories,
            'page' => $page,
            'pagesCount' => ceil(count($categories) / $this->categoriesPerPage),
        ];
    }
}
