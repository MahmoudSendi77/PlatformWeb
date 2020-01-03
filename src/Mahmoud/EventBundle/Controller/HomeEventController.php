<?php

namespace Mahmoud\EventBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Mahmoud\EventBundle\Entity\EventLocation;
use Mahmoud\EventBundle\Entity\Reservation;
use Mahmoud\EventBundle\Form\EventLocationType;
use Mahmoud\EventBundle\Form\EventType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mahmoud\EventBundle\Entity\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\IsNull;


class HomeEventController extends Controller
{
    public function homeEventAction()
    {
        return $this->render('@MahmoudEvent/HomeEvent/home_event.html.twig', array(
            // ...
        ));
    }

    public function showEventAction(Request $request)
    {



        $em=$this->getDoctrine()->getManager();

            $pp=$em->getRepository(Event::class)->findAll();

        $rep  = $this->get('knp_paginator')->paginate(
            $pp,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            5/*nbre d'éléments par page*/

        );



        return $this->render('@MahmoudEvent/HomeEvent/show_event.html.twig', array(
           'listEvent'=>$rep,

        ));
    }

    public function adminadminManagerAction()
    {

        $rep=$this->getDoctrine()->getManager()->getRepository(Event::class)->findAll();
//        $images = array();
//        foreach ($rep as $key => $entity) {
//            $images[$key] = base64_encode(stream_get_contents($entity->getEventPicture()));
//        }

        return $this->render('@MahmoudEvent/HomeEvent/admin_admin.html.twig', array(
            'listEvent'=>$rep,

        ));
    }

    public function adminManagerAction()
    {

        $rep=$this->getDoctrine()->getManager()->getRepository(Event::class)->findAll();
//        $images = array();
//        foreach ($rep as $key => $entity) {
//            $images[$key] = base64_encode(stream_get_contents($entity->getEventPicture()));
//        }

        return $this->render('@MahmoudEvent/HomeEvent/admin_page.html.twig', array(
            'listEvent'=>$rep,

        ));
    }


    public function myEventAction()
    {
        $id=$this->container->get('security.token_storage')->getToken()->getUser()->getId();
        $rep=$this->getDoctrine()->getManager()->getRepository(Event::class)->findEventByUser($id);
//

        return $this->render('@MahmoudEvent/HomeEvent/my_event.html.twig', array(
            'listEvent'=>$rep,

        ));
    }
    public function showEventDetailAction($id)
    {

        $ev=$this->getDoctrine()->getManager()->getRepository(Event::class)->find($id);
        $location=$this->getDoctrine()->getManager()->getRepository(EventLocation::class)->findByEventId($ev->getId());//hedha eraw 8alet sal7ou lezmek joiture sin raw 9a3d ye5ed fi id event yaaa b

        $nbrSubscribe=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->countAllReservation();
        $nbrSubscribeByEvent=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->countReservationByEvent($id);

        $nbrplace=$ev->getEventNBRPlace();

        $perc=($nbrSubscribeByEvent/$nbrSubscribe);


        $rank=$nbrSubscribe - $nbrSubscribeByEvent ;
        $available=$nbrplace-$nbrSubscribeByEvent;


        return $this->render('@MahmoudEvent/HomeEvent/detail_event.html.twig', array(
            'event'=>$ev,
            'lat'=>$location->getLattitude(),
            'lon'=>$location->getLongitude(),

            'subscriber'=>$nbrSubscribeByEvent,
            'perSubs'=>$perc,
            'rank'=>$rank,
            'available'=>$available

        ));
    }

    /* ******************************************************************************* ADD event ***********************************************************/
    public function addEventAction()
    {
        $e = new Event();
       $form=$this->createForm(EventType::class,$e,array(
           'action'=>$this->generateUrl('add_eventDB')
       ));

        return $this->render('@MahmoudEvent/HomeEvent/add_event.html.twig', array(
            'form'=>$form->createView()
        ));
    }



    public function addEventDBAction(Request $request)
    {
        $e = new Event();
        $current_user=$this->container->get('security.token_storage')->getToken()->getUser();
        $idu=$current_user->getId();
        $form=$this->createForm(EventType::class,$e);
        $form = $form->handleRequest($request);
        //3.sauvgarde des donnees
        if ($form->isSubmitted()&&$form->isValid()) {
            $manager = $this->get('mgilet.notification');

            $em = $this->getDoctrine()->getManager();
            $notif = $manager->createNotification("Event  ");
            $notif->setMessage(' Event Has Been Added BY Foulen  ');

            $tt=$em->getRepository(User::class)->findAll();
            foreach ($tt as $value) {

                $manager->addNotification(array($value), $notif, true); }

            $e->setEventPicture(file_get_contents($e->getEventPicture()->getPathname()));
            $e->setUserId($current_user);
            $em->persist($e);
            $em->flush(); //flush du tout l 'orm

            //3.4 redirection de l'utilisateur vers l'intreface d'affichege
            return $this->redirectToRoute('add_event_location', array(
                'id'=>$e->getId(),
            ));
        }
        return $this->render('@MahmoudEvent/HomeEvent/add_event.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    /* ******************************************************************************* ADD event ***********************************************************/

    public function addEventLocationAction($id)
    {
        $l=new EventLocation();
        $form=$this->createForm(EventLocationType::class,$l,array(
            'action'=>$this->generateUrl('add_event_locationdb',array('id'=>$id))));

        return $this->render('@MahmoudEvent/HomeEvent/map_event.html.twig', array(
            'form'=>$form->createView(),
            'id'=>$id
        ));
    }

    public function addEventLocationDBAction(Request $request,$id)
    {
        $l = new EventLocation();
        $form=$this->createForm(EventLocationType::class,$l);
        $form = $form->handleRequest($request);
        $e=$this->getDoctrine()->getManager()->getRepository(Event::class)->find($id);
        //3.sauvgarde des donnees
        if ($form->isValid()) {
            $l->setEventId($e);
            $em = $this->getDoctrine()->getManager();
            $em->persist($l);
            $em->flush(); //flush du tout l 'orm
            return $this->redirectToRoute('show_event', array(
            ));
        }
        return $this->render('@MahmoudEvent/HomeEvent/map.html.twig', array(
            'form'=>$form->createView(),
            'id'=>$id
        ));
    }


    public function eventByOwnerAction()
    {

        $id=1;//id de current user
        // $ev=$this->getDoctrine()->getManager()->getRepository(Event::class)->findEventByOwner($id);//list of event by user
        //  $location=$this->getDoctrine()->getManager()->getRepository(EventLocation::class)->findByEventId($ev->getId());//hedha eraw 8alet sal7ou lezmek joiture sin raw 9a3d ye5ed fi id event yaaa b

        return $this->render('@MahmoudEvent/HomeEvent/show_my_event.html.twig', array(
            //      'event'=>$ev,

        ));
    }

   /* *******************************************************************************update***********************************************************/

    public function updateEventAction($id, Request $request)
    {
        $image1=null;
        $em = $this->getDoctrine()->getManager();
        $e = $em->getRepository(Event::class)->find($id);

        $image=$e->displayPhoto();
        $image1=$e->getEventPicture();

        //2.preparation de notre formulaire
        $e->setEventPicture(null);
        $form = $this->createForm(EventType::class, $e);

        $form = $form->handleRequest($request);
        //SAUVGARDE DES DONNEES

        if ($form->isSubmitted() && $form->isValid()) {

            if($e->getEventPicture()==null){
                $e->setEventPicture($image1);
                $em->persist($e);
                $em->flush();
                return $this->redirectToRoute('show_event');

            }

            $e->setEventPicture(file_get_contents($e->getEventPicture()->getPathname()));
                $em->persist($e);
                $em->flush();
                return $this->redirectToRoute('show_event');


        }
        //3.envoi du formulaire à l'utilisateur
        return $this->render('@MahmoudEvent/HomeEvent/modify_event.html.twig', array('form' => $form->createView(),'img'=>$image));


    }



    /* *******************************************************************************delete ***********************************************************/
    public function deleteEventAction($id)
    {
        $e = new Event();
        $event=$this->getDoctrine()->getRepository('MahmoudEventBundle:Event')->find($id);
        $location=$this->getDoctrine()->getRepository('MahmoudEventBundle:EventLocation')->findByEventId($id);
        $reaction=$this->getDoctrine()->getRepository('MahmoudEventBundle:Reactionevent')->findByEventId($id);
        $em = $this->getDoctrine()->getManager();
        foreach ($reaction as $reac){
            $em->remove($reac);
            $em->flush();
        }

        $em->remove($location);
        $em->remove($event);
        $em->flush();

        $user=$this->container->get('security.token_storage')->getToken()->getUser();
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
        return $this->redirectToRoute('admin_space');
        }
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
            return $this->redirectToRoute('my_event');
        }
        return $this->redirectToRoute('show_event');
    }

    public function deletereservationAction($id)
    {
        $e = new Event();
        $r=$this->getDoctrine()->getRepository(Reservation::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($r);
        $em->flush();

        /*$user=$this->container->get('security.token_storage')->getToken()->getUser();
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute('admin_space');
        }
        if($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
            return $this->redirectToRoute('my_event');
        }*/
        return $this->redirectToRoute('show_event');
    }



    public function reserveEventAction($id)
    {
        $reservation = new Reservation();

        $event=$this->getDoctrine()->getManager()->getRepository(Event::class)->find($id);

        $current_user=$this->container->get('security.token_storage')->getToken()->getUser();
        $idu=$current_user->getId();

        $isfound=null;
        $isf=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->isFound($id,$idu);


        $reservation->setEventId($event);
        $reservation->setUserId($current_user);
        $char ="abcdefghijklmnopqrstvwxyz0123456789";
        $chaineAleatoire =str_shuffle($char);
        $code= substr($chaineAleatoire,1,10);
        $reservation->setCode($code);


        if(is_null($isf)){
        try{

        $em = $this->getDoctrine()->getManager();
        $em->persist($reservation);
        $em->flush();

        }catch (\Exception $e){
            return $this->redirectToRoute('show_event');
        }
        }


        $res=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->findByuserId($idu);
       // $username=$this->container->get('security.token_storage')->getToken()->getUser()->getUsername();



        return $this->render('@MahmoudEvent/HomeEvent/my_event_reservation.html.twig', array(
            'listEvent'=>$res,'event'=>$event

        ));
    }

    public function reservationByEventUserAction($id){

        $reservation = new Reservation();

        $event=$this->getDoctrine()->getManager()->getRepository(Event::class)->find($id);

        $current_user=$this->container->get('security.token_storage')->getToken()->getUser();
        $idu=$current_user->getId();

        $res=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->findByuserId($idu);



        return $this->render('@MahmoudEvent/HomeEvent/my_event_reservation.html.twig', array(
            'listEvent'=>$res,'event'=>$event

        ));

    }


/***********************************************************************************************search**********************************************************************************************/

    public function searchEventAction(Request $request)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizer = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoders);

        $em = $this->getDoctrine()->getManager();

        if($request->isXmlHttpRequest()) {
            // To retrieve $_GET parameters do this $request->query->get('parameter');

            $search = $request->request->get('search');

            echo('aaaaaaaaaaaa');
            echo($search);
          //  $beneficiaire = $request->request->get('beneficiaire');

            $parcelles = $em->getRepository(Event::class)->findByeventCountry($search);

            $jsonContent = $serializer->serialize($parcelles, 'json');

          //  return new Response($jsonContent);

            return $this->render('@MahmoudEvent/HomeEvent/dd_event.html.twig', array(
                'i'=>$jsonContent

            ));
        }

        $rep=$this->getDoctrine()->getManager()->getRepository(Event::class)->findByeventTitle($request->get('searchname'));
        return $this->render('@MahmoudEvent/HomeEvent/show_event.html.twig', array(
            'listEvent'=>$rep

        ));


    }

    public function searchDBAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');

        $entities =  $em->getRepository(Event::class)->findEntitiesByString($requestString);

        if(!$entities) {
            $result['entities']['error'] = "No results matche with your search ";
        } else {
            $result['entities'] = $this->getRealEntities($entities);
        }
        return new Response(json_encode($result));

    }

    public function getRealEntities($entities){
        foreach ($entities as $entity){
            $realEntities[$entity->getId()] = [$entity->getEventTitle(),"hhhh"];
        }
        return $realEntities;
    }


    public function reservationCardAction($id) {
        $username=$this->container->get('security.token_storage')->getToken()->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $resCard = $em->getRepository(Reservation::class)->find($id);///get event for that


        return $this->render('@MahmoudEvent/HomeEvent/reservation.html.twig',array('res'=>$resCard,'user'=>$username));
    }


    /**************************************************************************************************************************reaction******************************************************************/

    public function reactiondLikeAction($id) {
        $username=$this->container->get('security.token_storage')->getToken()->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $resCard = $em->getRepository(Reservation::class)->find($id)->getEventId();///get event for that


        return $this->render('@MahmoudEvent/HomeEvent/reservation.html.twig',array('event'=>$resCard,'user'=>$username));
    }
    public function reactiondInterstAction($id) {
        $username=$this->container->get('security.token_storage')->getToken()->getUser()->getUsername();
        $em = $this->getDoctrine()->getManager();
        $resCard = $em->getRepository(Reservation::class)->find($id);///get event for that


        return $this->render('@MahmoudEvent/HomeEvent/reservation.html.twig',array('res'=>$resCard,'user'=>$username));
    }

    //*****************************************************************************************************************mobile web service *********************************************************************************

    public function mobileEventAddAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $event = new Event();
        $idu=$request->get('userid');
        $event->setEventTitle($request->get('titreEvent'));
        $event->setEventCountry($request->get('coutryEvent'));
        $event->setEventAdress($request->get('addressEvent'));
        $event->setEventCategory($request->get('categoryEvent'));
        $event->setEventStartDate(new \DateTime($request->get('dateEvent')));
        $event->setEventEndDate(new \DateTime($request->get('datefinEvent')));
        $event->setEventNBRPlace($request->get('nbplaceEvent'));
        $event->setEventHoure($request->get('houreEvent'));
        $event->setEventDescription($request->get('descriptionEvent'));
        $eve=$request->get('afficheEvent');
        $user=$this->getDoctrine()->getManager()->getRepository(User::class)->find($idu);
        $event->setUserId($user);
        //$s= "data:image/png;base64," . base64_decode($eve);
        //file_put_contents($eve);

        $eee=file_get_contents($eve);
        $event->setEventPicture($eee);

        $em->persist($event);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize(["id"=>$event->getId()]);
        return new JsonResponse($formatted);
    }
    public function mobileEventModifyAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $event = new Event();
        $id=$request->get('id');
        $event = $this->getDoctrine()->getManager()->getRepository(Event::class)->find($id);
        $event->setEventTitle($request->get('titreEvent'));
        $event->setEventCountry($request->get('coutryEvent'));
        $event->setEventAdress($request->get('addressEvent'));
        $event->setEventCategory($request->get('categoryEvent'));
        $event->setEventStartDate(new \DateTime($request->get('dateEvent')));
        $event->setEventEndDate(new \DateTime($request->get('datefinEvent')));
        $event->setEventNBRPlace($request->get('nbplaceEvent'));
        $event->setEventHoure($request->get('houreEvent'));
        $event->setEventDescription($request->get('descriptionEvent'));
        $eve=$request->get('afficheEvent');
        //echo ($eve);
        if($eve!="00"){
            $eee=file_get_contents($eve);
            $event->setEventPicture($eee);
        }
        //$s= "data:image/png;base64," . base64_decode($eve);
        //file_put_contents($eve);

        $em->persist($event);
        $em->flush();
$re=$request->get('id');
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($re);
        return new JsonResponse($formatted);
    }
    public function mobileEventDeleteAction($id)
    {
        $e = new Event();
        $event=$this->getDoctrine()->getRepository('MahmoudEventBundle:Event')->find($id);
        $location=$this->getDoctrine()->getRepository('MahmoudEventBundle:EventLocation')->findByEventId($id);
        //$reaction=$this->getDoctrine()->getRepository('MahmoudEventBundle:Reactionevent')->findByEventId($id);
        $em = $this->getDoctrine()->getManager();
        if($location!=NULL){  $em->remove($location);
            $em->flush();
        }

        $em->remove($event);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("ok");
        return new JsonResponse($formatted);
    }
    public function mobilegetAllEventAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $res =$em->getRepository(Event::class)->findAll();
        $stat=new ArrayCollection();

        /*
                    $nbrSubscribe=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->countAllReservation();
                    $nbrSubscribeByEvent=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->countReservationByEvent($e->getId());
                    $nbrplace=$e->getEventNBRPlace();
                    $percSubsFromAll=($nbrSubscribeByEvent/$nbrSubscribe);
                    $rank=$nbrSubscribe - $nbrSubscribeByEvent ;
                    $available=$nbrplace-$nbrSubscribeByEvent;
                    $s=["id"=>$e->getId(),"pourcentage"=>$percSubsFromAll,"pourcentage"=>$rank,"pourcentage"=>$available];
                    $stat.add(s);
        */

        foreach ( $res  as $e ){
            $e->setEventPicture($e->displayPhoto());
        }




        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($res);
        return new JsonResponse($formatted);
    }
    public function mobilegetStatEventAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();


        $res =$em->getRepository(Event::class)->findEventById($id);
        $ev=$this->getDoctrine()->getManager()->getRepository(Event::class)->find($id);

        $nbrSubscribe=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->countAllReservation();

        $nbrSubscribeByEvent=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->countReservationByEvent($id);

        if($nbrSubscribeByEvent==null){
            $nbrSubscribeByEvent=0;
        }
        $nbrplace=$ev->getEventNBRPlace();


        $s=["id"=>$id,"nbrAllSubscriber"=>$nbrSubscribe,"nbrplace"=>$nbrplace,"nbrSubscribeByEvent"=>$nbrSubscribeByEvent];

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($s);
        return new JsonResponse($formatted);
    }
    public function mobilegetOneEventAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();

        $stat=new ArrayCollection();
        $res =$em->getRepository(Event::class)->findEventById($id);
        $ev=$this->getDoctrine()->getManager()->getRepository(Event::class)->find($id);
        $location=$this->getDoctrine()->getManager()->getRepository(EventLocation::class)->findByEventId($ev->getId());
        $nbrSubscribe=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->countAllReservation();
        $nbrSubscribeByEvent=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->countReservationByEvent($id);
        $nbrplace=$ev->getEventNBRPlace();
        $percSubsFromAll=($nbrSubscribeByEvent/$nbrSubscribe);


        $rank=$nbrSubscribe - $nbrSubscribeByEvent ;
        $available=$nbrplace-$nbrSubscribeByEvent;

        $s=["id"=>$id,"pourcentage"=>$percSubsFromAll,"rank"=>$rank,"availilty"=>$available];

        foreach ( $res  as $e ) {
           $e->setEventPicture($e->displayPhoto());
           // $e->setEventPicture(null);
        }

        $stat=["stat"=>$s,"event"=>$res];
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($res);
        return new JsonResponse($formatted);
    }
    public function mobilegetEventByUserAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();

        $res =$em->getRepository(Event::class)->findEventByUser($id);

        foreach ( $res  as $e ){
            //  $e->displayPhoto();
            $e->setEventPicture($e->displayPhoto());
            // $m=$e->displayPhoto();
        }

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($res);
        return new JsonResponse($formatted);
    }
    public function mobileEventlastAddedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $res =$em->getRepository(Event::class)->topFive();
        foreach ( $res  as $e ){
            $e->setEventPicture($e->displayPhoto());
        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($res);
        return new JsonResponse($formatted);
    }



    //***************************************************************mobile location event***********************************
    public function addEventLocationMobileAction(Request $request)
    {
        $l = new EventLocation();
        $l->setLattitude($request->get('lattitude'));
        $l->setLongitude($request->get('longitude'));
        $id=$request->get("EventId");
        $e=$this->getDoctrine()->getManager()->getRepository(Event::class)->find($id);

            $l->setEventId($e);
            $em = $this->getDoctrine()->getManager();
            $em->persist($l);
            $em->flush(); //flush du tout l 'orm
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("ok");
        return new JsonResponse($formatted);
    }
    public function modifieEventLocationMobileAction(Request $request)
    {
        $id=$request->get("id");
        $l = $this->getDoctrine()->getManager()->getRepository(EventLocation::class)->find($id);
        $l->setLattitude($request->get('lattitude'));
        $l->setLongitude($request->get('longitude'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($l);
        $em->flush(); //flush du tout l 'orm
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("ok");
        return new JsonResponse($formatted);
    }
    public function deleteEventLocationMobileAction(Request $request,$id)
    {

        $l = $this->getDoctrine()->getManager()->getRepository(EventLocation::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($l);
        $em->flush(); //flush du tout l 'orm

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("ok");
        return new JsonResponse($formatted);
    }
    function getEventLocationMobileAction(Request $request)
    {

        $id=$request->get("id");

        $location=$this->getDoctrine()->getManager()->getRepository(EventLocation::class)->findByEventId($id);//hedha eraw 8alet sal7ou lezmek joiture sin raw 9a3d ye5ed fi id event yaaa b
        $l=new EventLocation();
        $e=new Event();
        $e=$location->getEventId();
        $l->setLongitude($location->getLongitude());
        $l->setLattitude($location->getLattitude());
        $l->setEventId($location->getEventId()->getId());
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($l);
        return new JsonResponse($formatted);
    }


    //******************************************************************************mobile reservation *****************************



    public function addReservationMobileAction(Request $request)
    {
        $reservation = new Reservation();
        $id=$request->get('idevent');
        $idu=$request->get('iduser');
        $em=$this->getDoctrine()->getManager();
        $event=$this->getDoctrine()->getManager()->getRepository(Event::class)->find($id);

        $user=$this->getDoctrine()->getManager()->getRepository(User::class)->find($idu);


        $isfound=null;
        $isf=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->isFound($id,$idu);


        $reservation->setEventId($event);
        $reservation->setUserId($user);
        $char ="abcdefghijklmnopqrstvwxyz0123456789";
        $chaineAleatoire =str_shuffle($char);
        $code= substr($chaineAleatoire,1,10);
        $reservation->setCode($code);


        if(is_null($isf)){
            try{

                $em = $this->getDoctrine()->getManager();
                $em->persist($reservation);
                $em->flush();
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize(["id"=>$reservation->getId()]);
                return new JsonResponse($formatted);
            }catch (\Exception $e){
                $serializer = new Serializer([new ObjectNormalizer()]);
                $formatted = $serializer->normalize(["id"=>0]);
                return new JsonResponse($formatted);
            }
        }

        else{


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize(["id"=>0]);
        return new JsonResponse($formatted);//
        }
    }

    public function deleteReservationMobileAction(Request $request,$id)
    {

        $l = $this->getDoctrine()->getManager()->getRepository(Reservation::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($l);
        $em->flush(); //flush du tout l 'orm

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("ok");
        return new JsonResponse($formatted);
    }

    function reservationByUserMobileAction(Request $request)
    {

        $id=$request->get("id");
        $res=$this->getDoctrine()->getManager()->getRepository(Reservation::class)->findReservationByUser($id);
        $ress=new ArrayCollection();


        foreach ( $res  as $e ){
            $e->getEventId()->setEventPicture($e->getEventId()->displayPhoto());
        }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($res);
        return new JsonResponse($formatted);
    }

    public function loginMobileAction(Request $request){

        $password =$request->get("password");
        $email =$request->get("email");
        $io='notValid';
        $user=$this->getDoctrine()->getManager()->getRepository(User::class)->findOneByEmail($email);
     /*   $encoder_service = $this->get('security.encoder_factory');
        $encoder = $encoder_service->getEncoder($user);
        $encoded_pass = $encoder->encodePassword($password, $user->getSalt());
        if ($user->getPassword()==$encoded_pass)*/

    if($user!=null){
        $encoder_service = $this->get('security.encoder_factory');
        $encoder = $encoder_service->getEncoder($user);
        if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt()))
        {
            $io= ['isValid'=>"Valid","email"=>$email,"username"=>$user->getUsername(),"id"=>$user->getId()];

        }
        else {
            $io= ['isValid'=>"notValid","email"=>"","username"=>"","id"=>""];
        }

    }else{
        $io= ['isValid'=>"notValidMail","email"=>"","username"=>"","id"=>""];
    }
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($io );
        return new JsonResponse($formatted);
    }



    public function searchMobileAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('search');

        $entities =  $em->getRepository(Event::class)->findEntitiesByString($requestString);
        $result=array();
        $i=0;
       // return new Response(json_encode($entities[0]));
        if(!$entities or $entities==null) {
            $res=["message"=>"false","id"=>0,"title"=>0,"adresse"=>0,"img"=>0];
            $result[0]=$res;
            return new Response(json_encode($result));
        } elseif($entities[0]->getEventTitle()!=null){
            foreach ($entities as $entity){
try{
            $res=["message"=>"true","id"=>$entity->getId(),"title"=>$entity->getEventTitle(),"adresse"=>$entity->getEventAdress(),"img"=>$entity->displayPhoto()];
                $result[$i]=$res;
                $i=$i+1;
}catch (\mysqli_sql_exception $e){
    $res=["message"=>"false","id"=>0,"title"=>0,"adresse"=>0,"img"=>0];
    $result[0]=$res;
    return new Response(json_encode($result));
}
        }
            return new Response(json_encode($result));
        }



    }





    /* public function searchNowAction(Request $request){
         $searchTerm = $request->query->get('search');

         $em = $this->getDoctrine()->getManager();
         $search = $em->getRepository('AppBundle:Classified')->searchClassifieds($searchTerm);

         $results = $query->getResult();

         $content = $this->renderView('search-result.html.twig', [
             'results' => $results
         ]);

         $response = new JsonResponse();
         $response->setData(array('classifiedList' => $content));
         return $response;


     }*/
}
