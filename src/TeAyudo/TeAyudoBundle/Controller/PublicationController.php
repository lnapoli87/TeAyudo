<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PublicationController extends Controller
{
    public function showAction()
    {
        return $this->render('TeAyudoBundle:Default:index.html.twig', array('pageTitle' => 'TeAyudo.org','middleHeaderContent'=>'MIDDLE'));
    }
}
