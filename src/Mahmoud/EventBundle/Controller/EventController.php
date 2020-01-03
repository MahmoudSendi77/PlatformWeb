<?php
//
//namespace Mahmoud\EventBundle\Controller;
//
//use Mahmoud\EventBundle\Entity\Event;
//use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//
///**
// * Event controller.
// *
// * @Route("event")
// */
//class EventController extends Controller
//{
//    /**
//     * Lists all event entities.
//     *
//     * @Route("/", name="event_index")
//     * @Method("GET")
//     */
//    public function indexAction()
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $events = $em->getRepository('MahmoudEventBundle:Event')->findAll();
//
//        return $this->render('event/index.html.twig', array(
//            'events' => $events,
//        ));
//    }
//
//    /**
//     * Finds and displays a event entity.
//     *
//     * @Route("/{id}", name="event_show")
//     * @Method("GET")
//     */
//    public function showAction(Event $event)
//    {
//
//        return $this->render('event/show.html.twig', array(
//            'event' => $event,
//        ));
//    }
//}
