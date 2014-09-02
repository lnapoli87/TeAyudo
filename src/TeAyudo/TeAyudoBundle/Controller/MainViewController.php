<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainViewController extends Controller
{
    public function showAction(Request $request)
    {
    	$usr= $this->get('security.context')->getToken()->getUser();
    	$userName = $usr->getName();
        return $this->render('TeAyudoBundle:main:main.html.twig', array('pageTitle' => 'TeAyudo.org', 'username' => $userName));
    }
}
