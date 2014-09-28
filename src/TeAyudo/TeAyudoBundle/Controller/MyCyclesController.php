<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TeAyudo\TeAyudoBundle\Entity\Cycle;
use TeAyudo\TeAyudoBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

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
    
    
    public function deleteCycleAction(Request $req, $id){
    	$this->endCycleById($id);
    	return $this->showAction();	
    }
    
    public function endCycleById($cycleId){
    	try{
    		$em = $this->getDoctrine()->getManager();
    		$cycle = $this->findCycleById($cycleId)[0];
    		$cycle->setEnded(true);
    		$em->merge($cycle);
    		$em->flush();
    	} catch (DBALException $e) {
    		$this->setError('ERROR: Ocurrió un error, inténtelo nuevamente');
    	}
    }
    
    public function findCycleById($cycleId){
    	try{
    		$em = $this->getDoctrine()->getManager();
    		$query = $em->createQuery(
    				'SELECT c
	    			FROM TeAyudo\TeAyudoBundle\Entity\Cycle c
	    			WHERE c.id= :cycleId'
    		)->setParameter('cycleId', $cycleId);
    		 
    		return $query->getResult();
    	} catch (DBALException $e) {
    		$this->setError('ERROR: Ocurrió un error, inténtelo nuevamente');
    	}
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
