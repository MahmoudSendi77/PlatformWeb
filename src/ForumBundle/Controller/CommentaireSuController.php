<?php

namespace ForumBundle\Controller;
use ForumBundle\Entity\Sujet;
use ForumBundle\Form\CommentaireSuType;
use ForumBundle\Entity\CommentaireSu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CommentaireSuController extends Controller
{
                       ////////////////////// COTE ADMIN /////////////////////////////
    public function showCommentAdminAction($id)
    {

        $rep=$this->getDoctrine()->getManager()->getRepository(CommentaireSu::class);
         $CommentaireSu=$rep->findBy(['post_id'=>$id]);
        return $this->render('@Forum/Sujets/showcommentsAdmin.html.twig', array(
            'listComment'=>$CommentaireSu,

        ));

    }

    public function updateCommentAdminAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $club=$em->getRepository(CommentaireSu::class)->find($id);
        $form = $this->createForm(CommentaireSuType::class, $club);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            echo "<script>alert(\" votre commentaire et modifier  \")</script>";}
        return $this->render('@Forum/Sujets/updatecommentaireAdmin.html.twig',
            array('form' => $form->createView()));
    }

    public function createCommentAdminAction($id, Request $request)
    {
        {
            $comment = new CommentaireSu();
            $form = $this->createForm(CommentaireSuType::class, $comment);
            $form = $form->handleRequest($request);
            $comment->setUser($this->get('security.token_storage')->getToken()->getUser());


            $idPosts = $this->getDoctrine()->getRepository(CommentaireSu::class)->findOneBy(array('id' => $id));

            $id1=$idPosts->getPostId();


            if ($form->isValid()) {
                $comment->setPostId($id1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
                echo "<script>alert(\" votre commentaire et ajouté  \")</script>";
                return $this->render('@Forum/Sujets/updatecommentaireAdmin.html.twig',
                    array('form' => $form->createView()));
            }
            return $this->render('@Forum/Sujets/updatecommentaireAdmin.html.twig',
                array('form' => $form->createView()));


        }
    }




               ////////////////////////////////////  COTE CLIENT //////////////////////////////////////////
    public function showCommentClientAction($id)
    {

        $rep=$this->getDoctrine()->getManager()->getRepository(CommentaireSu::class);
        $CommentaireSu=$rep->findBy(['post_id'=>$id]);
        return $this->render('@Forum/Sujets/showcomments.html.twig', array(
            'listComment'=>$CommentaireSu,

        ));

    }

    public function updateCommentAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $club=$em->getRepository(CommentaireSu::class)->find($id);
        $form = $this->createForm(CommentaireSuType::class, $club);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('show_comment');}
        return $this->render('@Forum/Sujets/update_commentaire.html.twig',
            array('form' => $form->createView()));
    }

    public function createCommentAction($id , Request $request)
    {
        {
            $comment = new CommentaireSu();
            $form = $this->createForm(CommentaireSuType::class, $comment);
            $form = $form->handleRequest($request);
            $comment->setUser($this->get('security.token_storage')->getToken()->getUser());


            $idPosts = $this->getDoctrine()->getRepository(CommentaireSu::class)->findOneBy(array('id' => $id));

            $id1=$idPosts->getPostId();


            if ($form->isValid()) {
                $comment->setPostId($id1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
                echo "<script>alert(\" votre commentaire et ajouté  \")</script>";
                return $this->render('@Forum/Sujets/update_commentaire.html.twig',
                    array('form' => $form->createView()));
            }
            return $this->render('@Forum/Sujets/update_commentaire.html.twig',
                array('form' => $form->createView()));


        }


    }
    public function deleteCAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository("ForumBundle:CommentaireSu")->find($id);
        $em->remove($comment);
        $em->flush();
        return$this->redirectToRoute("forum_recherche");

    }
}
