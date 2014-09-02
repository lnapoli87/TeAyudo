<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('TeAyudoBundle:Default:index.html.twig', array('pageTitle' => 'TeAyudo.org','middleHeaderContent'=>'MIDDLE'));
    }
}
