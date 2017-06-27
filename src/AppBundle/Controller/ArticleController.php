<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findAll();
        return $this->render('article/index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"article"})
     */
    public function jsonIndexAction($start=0)
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('AppBundle:Article')->findList($start);
        return  $articles;
    }

        /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"article"})
     */
    public function showJsonAction( $id){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findOneById($id);
        return $article;
    }

    /**
     * Creates a new article entity.
     *
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm('AppBundle\Form\ArticleType', $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $article->setUser($this->getUser());
            $em->persist($article);
            $em->flush($article);

            return $this->redirectToRoute('article_show', array('id' => $article->getId()));
        }

        return $this->render('article/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a article entity.
     *
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('article/show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Finds and displays a article entity.
     *
     */
    public function showFromMobileAction(Article $article)
    {
        return $this->render('article/showFromMobile.html.twig', array(
            'article' => $article,
        ));
    }
    /**
     * Displays a form to edit an existing article entity.
     *
     */
    public function editAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('AppBundle\Form\ArticleType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
             $article->setValidated(false);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_show', array('id' => $article->getId()));
        }

        return $this->render('article/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing question entity.
     *
     */
    public function valideAction(Request $request, Article $article)
    {
        $article->setValidated(true);
         $article->setValidateur($this->getUser());
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('article_show', array('id' => $article->getId()));
    }
    /**
     * Deletes a article entity.
     *
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush($article);
        }

        return $this->redirectToRoute('article_index');
    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
