<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;

class AdminCategoryController extends Controller
{
    protected $categoriesPerPage = 25;

    /**
     * @Route("/admin/categories/{page}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="admin_category_index")
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
