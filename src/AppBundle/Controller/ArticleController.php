<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Partie;
use Pwm\AdminBundle\Entity\Info;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\View; 
use Symfony\Component\HttpFoundation\Response;
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
     * Finds and displays a partie entity.
     *
     */
    public function getDificultContentsAction(Article $article)
    {
         $url="https://trainings-fa73e.firebaseio.com/status/content/".$article->getId()."/.json";
         $res =!is_null($this->get('fmc_manager')->sendOrGetData($url,null,'GET')) ? $this->get('fmc_manager')->sendOrGetData($url,null,'GET'): array(); 
        return  new Response(''.count($res));
    }

    /**
     * Lists all Produit entities.
     *@Rest\View(serializerGroups={"full"})
     */
    public function showJsonAction( $id){
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findOneById($id);
        return $article;
    }


    /**
     * Lists all Produit entities.
     *@Rest\View()
     */
    public function lireCoursAction(Request $request,Article $article, Info $info)
    {
         $status=$request->query->get('status');
          if ($session!=null && $info!=null) {
                switch ($status) {
                    case 'true':
                        $article->addInfo($info);
                         $this->getDoctrine()->getManager()->flush();
                         return  true;
                    case 'false':
                          $article->removeInfo($info);
                           $this->getDoctrine()->getManager()->flush();
                        return  false;                    
                    default:
                    return !empty($this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findByUser($article,$info));  
                }
          }
         return  false;
    }

    /**
     * Creates a new article entity.
     *
     */
    public function newAction(Request $request, Partie $partie)
    {
        $article = new Article();
        $form = $this->createForm('AppBundle\Form\ArticleType', $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $partie->setArticle($article);
            $em = $this->getDoctrine()->getManager();
            $article->setUser($this->getUser());
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('content_index', array('id' => $article->getId()));
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
        return $this->redirectToRoute('content_index', array('id' => $article->getId()));
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
