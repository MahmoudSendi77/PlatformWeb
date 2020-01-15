<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\CategorieSu;
use ForumBundle\Form\CategorieSuType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CategorieSuController extends Controller
{
    public function showCategorieAction()
        {

            $rep=$this->getDoctrine()->getManager()->getRepository(CategorieSu::class)->findAll();


            return $this->render('@Forum/Sujets/showcategories.html.twig', array(
                'listCateg'=>$rep,

            ));

    }
    public function deleteCatAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository(CategorieSu::class)->find($id);
        $em->remove($cat);
        $em->flush();
        return $this->redirectToRoute("show_categorie");

    }
    public function updateCatAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cat= $em->getRepository(CategorieSu::class)->find($id);
        $form = $this->createForm(CategorieSuType::class, $cat);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cat);
            $em->flush();
            return $this->redirectToRoute('show_categorie');
        }
        return $this->render('@Forum/Sujets/createupdate.html.twig',
            array('form' => $form->createView()));
    }
    public function createCatAction(Request $request)
    {
        $sujet = new CategorieSu();
        $form = $this->createForm(CategorieSuType::class, $sujet);
        $form = $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sujet);
            $em->flush();
            return $this->redirectToRoute('show_categorie');
        }
        return $this->render('@Forum/Sujets/createupdate.html.twig',
            array('form' => $form->createView()));


    }

}
