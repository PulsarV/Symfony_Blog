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
     * @Route("/config/categories/{page}", requirements={"page": "\d+"}, defaults={"page" = 1}, name="admin_category_index")
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

//    /**
//     * @Route("/config/categories/new", name="admin_category_new")
//     * @Method({"GET", "POST"})
//     * @Template()
//     */
//    public function newAction(Request $request)
//    {
//        $category = new Category();
//        $newForm = $this->createForm('AppBundle\Form\CategoryType', $category);
//        $newForm->handleRequest($request);
//
//        if ($newForm->isSubmitted() && $newForm->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($category);
//            $em->flush();
//
//            return $this->redirectToRoute('admin_category_index');
//        }
//
//        return [
//            'category' => $category,
//            'newForm' => $newForm->createView(),
//        ];
//    }
//
//    /**
//     * @Route("/config/categories/{slug}/edit", name="admin_category_edit")
//     * @Method({"GET", "POST"})
//     * @Template()
//     */
//    public function editAction(Request $request, $slug)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $category = $em->getRepository('AppBundle:Category')->findOneBy(['slug' => $slug]);
//        $deleteForm = $this->createDeleteForm($category);
//        $editForm = $this->createForm('AppBundle\Form\CategoryType', $category);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($category);
//            $em->flush();
//
//            return $this->redirectToRoute('admin_category_index', []);
//        }
//
//        return [
//            'deleteForm' => $deleteForm->createView(),
//            'editForm' => $editForm->createView(),
//        ];
//    }
//
//    /**
//     * @Route("/config/categories/{slug}/delete", name="admin_category_delete")
//     * @Method("DELETE")
//     */
//    public function deleteAction(Request $request, $slug)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $category = $em->getRepository('AppBundle:Category')->findOneBy(['slug' => $slug]);
//        $deleteForm = $this->createForm('AppBundle\Form\CategoryType', $category);
//        $deleteForm->handleRequest($request);
//
//        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($category);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('admin_category_index', []);
//    }
//
//    /**
//     * @param Category $category The Category entity
//     *
//     * @return \Symfony\Component\Form\Form The form
//     */
//    private function createDeleteForm(Category $category)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('admin_category_delete', ['slug' => $category->getSlug()]))
//            ->setMethod('DELETE')
//            ->getForm()
//            ;
//    }
}
