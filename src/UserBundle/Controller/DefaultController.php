<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $membre=$this->container->get('security.token_storage')->getToken()->getUser();

        if( $this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))

            return $this->render('@MahmoudEvent/HomeEvent/admin_dashbord.html.twig');



        return $this->render('@MahmoudEvent/HomeEvent/home_event.html.twig');
    }

}
