<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminIndexController extends Controller
{
    /**
     * @Route("/config", name="adminindexpage")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('adminarticleindex');
    }
}
