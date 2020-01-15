<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\CategorieSu;
use ForumBundle\Entity\CommentaireSu;
use ForumBundle\Entity\Sujet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;



class MobileController extends Controller
{

    public function afficheSujetMobileAction()
    {
        $tab = $this->getDoctrine()->getManager()->getRepository(Sujet::class)->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);

        $formatted=$serializer->normalize($tab);
        return new JsonResponse($formatted);

    }



    public function findAction($id)
    {

/////////////////////////////
        $tasks = $this->getDoctrine()->getManager()->getRepository(Sujet::class) ->find($id);
        $encoders = array(new XmlEncoder(), new JsonEncoder());

       $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
       $serializer = new Serializer($normalizers, $encoders);

        $formatted=$serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $task = new Sujet();
        $task->setId($request->get('id'));
        $task->setSubjectName($request->get('subjectName'));
        $task->setSubjectDescription($request->get('subjectDescription'));
        $task->setName($request->get('name'));
        $em->persist($task);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($task);
        return new JsonResponse($formatted);

    }
    public function suppAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository(Sujet::class)->find($id);
        $em->remove($formation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($formation);
        return new JsonResponse($formatted);
    }
    public function modifAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $formation=$em->getRepository(Sujet::class)->find($id);

        $formation->setSubjectName($request->get('subjectName'));
        $formation->setSubjectDescription($request->get('subjectDescription'));
        $formation->setName($request->get('name'));

        $em->persist($formation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($formation);
        return new JsonResponse($formatted);
    }


    ////////////////////////////////////commentaires////////////////////////////////////

    public function affichecommentaireMobileAction()
    {
        $tab = $this->getDoctrine()->getManager()->getRepository(CommentaireSu::class)->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);

        $formatted=$serializer->normalize($tab);
        return new JsonResponse($formatted);

    }

    public function findcommAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()->getRepository(CommentaireSu::class) ->find($id);
        $encoders = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);

        $formatted=$serializer->normalize($tasks);
        return new JsonResponse($formatted);

    }
    public function newcommAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $task = new CommentaireSu();
        $task->setId($request->get('id'));
        $task->setCommentSuContent($request->get('commentSuContent'));

        $em->persist($task);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($task);
        return new JsonResponse($formatted);

    }

    public function suppcommAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $formation = $em->getRepository(CommentaireSu::class)->find($id);
        $em->remove($formation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($formation);
        return new JsonResponse($formatted);
    }


    public function modifcommAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $formation=$em->getRepository(CommentaireSu::class)->find($id);

        $formation->setCommentSuContent($request->get('commentSuContent'));

        $em->persist($formation);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($formation);
        return new JsonResponse($formatted);
    }

    public function findcommsujetAction($id)
    {

        $tasks = $this->getDoctrine()->getManager()->getRepository(CommentaireSu::class) ->findBy(array('post_id'=>$id));
        $encoders = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);

        $formatted=$serializer->normalize($tasks);
        return new JsonResponse($formatted);

    }

    public function afficheCategMobileAction()
    {
        $tab = $this->getDoctrine()->getManager()->getRepository(CategorieSu::class)->findAll();
        $encoders = array(new XmlEncoder(), new JsonEncoder());

        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);

        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object;
        });
        $normalizers = array($normalizer);
        $serializer = new Serializer($normalizers, $encoders);

        $formatted=$serializer->normalize($tab);
        return new JsonResponse($formatted);

    }



}
