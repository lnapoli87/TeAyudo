<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TeAyudo\TeAyudoBundle\Entity\Cycle;
use TeAyudo\TeAyudoBundle\Entity\User;

class MyCyclesController extends Controller
{
	protected $cycles;
    public function showAction()
    {
    	$usr= $this->get('security.context')->getToken()->getUser();
    	$userName = $usr->getName();
    	$this->getCyclesFromDB($usr);
        return $this->render('TeAyudoBundle:myCycles:myCycles.html.twig', array('pageTitle' => 'TeAyudo.org', 'username' => $userName, 'cycles'=>$this->getCycles()));
    }
	public function getCycles() {
		return $this->cycles;
	}
	public function setCycles($cycles) {
		$this->cycles = $cycles;
		return $this;
	}
	
	public function getCyclesFromDB(User $user){
		
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				'SELECT c
    			FROM TeAyudo\TeAyudoBundle\Entity\Cycle c
    			WHERE c.user = :userId
    			ORDER BY c.date ASC'
		)->setParameter('userId', $user);
		
		$this->cycles = $query->getResult();
		
	}
	
}
