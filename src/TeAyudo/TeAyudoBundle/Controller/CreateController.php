<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TeAyudo\TeAyudoBundle\Entity\User;
use Symfony\Component\BrowserKit\Response;

class CreateController extends Controller
{
    public function showAction()
    {
    		$aUser = new User();
    		$aUser->setName('Lucas Napoli');
    		$aUser->setTelephone('2215680527');
    		$aUser->setCellphone('2215680527');
    		$aUser->setCoords('2215680527');
    		$aUser->setPassword('2215680527');
    		$aUser->setAdmin(true);
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($aUser);
    		$em->flush();
    		return new Response('Created product id '.$aUser->getId());
//         return $this->render('TeAyudoBundle:Default:index.html.twig', array('pageTitle' => 'TeAyudo.org','middleHeaderContent'=>'MIDDLE'));
    }
}
