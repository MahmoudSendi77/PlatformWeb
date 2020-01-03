<?php

namespace Mahmoud\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MahmoudEventBundle:Default:index.html.twig');
    }
}
