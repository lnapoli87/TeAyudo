<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TeAyudo\TeAyudoBundle\Entity\User;

class MainViewController extends Controller
{
	protected $lastCycles;
	protected $lastHelpNeededCycles;
	protected $lastHelpOfferedCycles;

    public function showAction(Request $request)
    {
    	$usr= $this->get('security.context')->getToken()->getUser();
    	$userName = $usr->getName();
    	$this->getCyclesFromDB($usr);
        return $this->render('TeAyudoBundle:main:main.html.twig', 
        		array('pageTitle' => 'TeAyudo.org', 
        				'username' => $userName,
        				'lastCycles'=>$this->getLastCycles(),
        				'lastHelpOfferedCycles'=>$this->getLastHelpOfferedCycles(),
        				'lastHelpNeededCycles'=>$this->getLastHelpNeededCycles()
        		));
    }
	public function getCyclesFromDB(User $user){
	
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				'SELECT c
    			FROM TeAyudo\TeAyudoBundle\Entity\Cycle c
				WHERE c.active = true
    			ORDER BY c.date DESC'
		)->setMaxResults(6);
	
		$this->lastCycles = $query->getResult();
		
		$query = $em->createQuery(
				'SELECT c
    			FROM TeAyudo\TeAyudoBundle\Entity\Cycle c
    			WHERE c.cycleType = 0 AND c.active = true
    			ORDER BY c.date DESC'
		)->setMaxResults(6);
		
		$this->lastHelpNeededCycles = $query->getResult();
		
		$query = $em->createQuery(
				'SELECT c
    			FROM TeAyudo\TeAyudoBundle\Entity\Cycle c
    			WHERE c.cycleType = 1 AND c.active = true
    			ORDER BY c.date DESC'
		)->setMaxResults(6);
		
		$this->lastHelpOfferedCycles = $query->getResult();
	
	}
	public function getLastCycles() {
		return $this->lastCycles;
	}
	public function setLastCycles($lastCycles) {
		$this->lastCycles = $lastCycles;
		return $this;
	}
	public function getLastHelpNeededCycles() {
		return $this->lastHelpNeededCycles;
	}
	public function setLastHelpNeededCycles($lastHelpNeededCycles) {
		$this->lastHelpNeededCycles = $lastHelpNeededCycles;
		return $this;
	}
	public function getLastHelpOfferedCycles() {
		return $this->lastHelpOfferedCycles;
	}
	public function setLastHelpOfferedCycles($lastHelpOfferedCycles) {
		$this->lastHelpOfferedCycles = $lastHelpOfferedCycles;
		return $this;
	}
	
}
