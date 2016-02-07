<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Form\Admin\AuthorType;
use AppBundle\Entity\Author;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="admin_registration")
     * @Template()
     */
    public function registerAction(Request $request)
    {
        $author = new Author();
        $registerForm = $this->createForm(AuthorType::class, $author);

        $registerForm->handleRequest($request);
        if ($registerForm->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($author, $author->getPlainPassword());
            $author->setPassword($password);
            $author->setIsActive(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($author);
            $em->flush();

            return $this->redirectToRoute('index_page');
        }

        return ['registerForm' => $registerForm->createView()];
    }
}
