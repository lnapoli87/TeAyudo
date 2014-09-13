<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TeAyudo\TeAyudoBundle\Entity\User;

class AdminController extends Controller
{
public function indexAction(Request $request)
    {
    	$usr= $this->get('security.context')->getToken()->getUser();
    	$userName = $usr->getName();
        return $this->render('TeAyudoBundle:admin:adminIndex.html.twig', 
        		array('pageTitle' => 'TeAyudo.org', 
        				'username' => $userName,
        				'newCycles'=>$this->getNewCycles(),
        				'newUsers'=>$this->getNewUsers(),
        		));
    }
	public function getNewCycles(){
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				'SELECT c
    			FROM TeAyudo\TeAyudoBundle\Entity\Cycle c
				WHERE c.active = false
    			ORDER BY c.date ASC'
		);
	
		return $query->getResult();
	}
	public function getNewUsers() {
		$em = $this->getDoctrine()->getManager();
		
		$query = $em->createQuery(
				'SELECT u
    			FROM TeAyudo\TeAyudoBundle\Entity\User u
    			WHERE u.active = false'
		);
		
		return $query->getResult();
	}
}
