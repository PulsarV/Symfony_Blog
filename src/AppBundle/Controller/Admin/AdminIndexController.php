<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminIndexController extends Controller
{
    /**
     * @Route("/admin", name="admin_index_page")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('admin_article_index');
    }
}
