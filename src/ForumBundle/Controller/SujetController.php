<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\CategorieSu;
use ForumBundle\Entity\CommentaireSu;
use ForumBundle\Form\SujetType;
use ForumBundle\Form\RechercheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ForumBundle\Entity\Sujet;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SujetController extends Controller
{

                             ////////////////////////COTE ADMIN/////////////////////////////////
    public function rechercheAction(Request $request)
    {
        $Sujet = new Sujet();
        $form = $this->createForm(RechercheType::class, $Sujet);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $Sujet = $this->getDoctrine()
                ->getRepository(Sujet::class)
                ->findBy((array('subjectName' => $Sujet
                    ->getsubjectName())));

        } else {
            $Sujet = $this->getDoctrine()->getRepository(Sujet::class)
            ->findAll();
                //$form = $Sujet->findname();
        }
        return $this->render('@Forum/Sujets/forum_page.html.twig', array('f' => $form->createView(),
            'forums' => $Sujet));
    }

    public function updatesujetAdminAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Sujet::class)->find($id);
        $form = $this->createForm(SujetType::class, $club);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('forum_recherche');
        }
        return $this->render('@Forum/Sujets/createsujetAmin.html.twig',
            array('form' => $form->createView()));
    }

    public function createsujetAdminAction(Request $request)
    {
        $sujetad = new Sujet();
        $form = $this->createForm(SujetType::class, $sujetad);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $sujetad->setUser($this->get('security.token_storage')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($sujetad);
            $em->flush();
            return $this->redirectToRoute('forum_recherche');
        }
        return $this->render('@Forum/Sujets/createsujetAmin.html.twig',
            array('form' => $form->createView()));


    }

                 /////////////////////////////////// COTE CLIENT //////////////////////////////////////


    public function rechercheCAction(Request $request)
    {
        $Sujet = new Sujet();
        $form = $this->createForm(RechercheType::class, $Sujet);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $Sujet = $this->getDoctrine()
                ->getRepository(Sujet::class)
                ->findBy((array('subjectName' => $Sujet
                    ->getsubjectName())));

        } else {
            $Sujet = $this->getDoctrine()->getRepository(Sujet::class)
                ->findAll();
        }
        return $this->render('@Forum/Sujets/forum_client.html.twig', array('f' => $form->createView(),
            'forums' => $Sujet));
    }




    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Sujet::class)->find($id);
        $form = $this->createForm(SujetType::class, $club);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('forum_rechercheC');
        }
        return $this->render('@Forum/Sujets/create.html.twig',
            array('form' => $form->createView()));
    }



    public function createAction(Request $request)
    {
        $sujet = new Sujet();
        $form = $this->createForm(SujetType::class, $sujet);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $sujet->setUser($this->get('security.token_storage')->getToken()->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($sujet);
            $em->flush();
            return $this->redirectToRoute('forum_rechercheC');
        }
        return $this->render('@Forum/Sujets/create.html.twig',
            array('form' => $form->createView()));


    }


                 //////////////////////////////////// DELETE CLIENT/ADMIN //////////////////////////////////////


    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $club = $em->getRepository(Sujet::class)->find($id);
        $commentaire=$em->getRepository(CommentaireSu::class)->findBy(array('post_id'=>$id));


        for($i = 0; $i < count($commentaire); ++$i) {

            $em->remove($commentaire[$i]);



        }
        $em->remove($club);
        $em->flush();
        return $this->redirectToRoute("forum_recherche");

    }

    public function mySubjectAction()
    {
        $id=$this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $rep=$this->getDoctrine()->getManager()->getRepository(Sujet::class)->findSujetByUser($id);
//
        return $this->render('@Forum/Sujets/mysujet.html.twig', array(
            'forums'=>$rep,
        ));
    }






}
