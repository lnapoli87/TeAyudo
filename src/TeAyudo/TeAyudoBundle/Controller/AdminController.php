<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TeAyudo\TeAyudoBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;

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
        				'activeUsers' => $this->getActiveUsers(),
        				'activeCycles' => $this->getActiveCycles()
        		));
    }
    
    public function approveUserAction(Request $request, $userId){
    	$this->changeUserStatusById($userId, true);
    	return $this->indexAction($request);
    }
    
    public function denyUserAction(Request $request, $userId){
    	$this->changeUserStatusById($userId, false);
    	return $this->indexAction($request);
    }
    
    public function approveCycleAction(Request $request, $cycleId){
    	$this->changeCycleStatusById($cycleId, true);
    	return $this->indexAction($request);
    }
    
    public function denyCycleAction(Request $request, $cycleId){
    	$this->changeCycleStatusById($cycleId, false);
    	return $this->indexAction($request);
    }
    
    public function changeCycleStatusById($cycleId, $active){
    	try{
    		$em = $this->getDoctrine()->getManager();
    		$cycle = $this->findCycleById($cycleId)[0];
    		$cycle->setActive($active);
    		$em->merge($cycle);
    		$em->flush();
    	} catch (DBALException $e) {
    		$this->setError('ERROR: Ocurrió un error, inténtelo nuevamente');
    	}
    }
    
    public function changeUserStatusById($userId, $active){
    	try{
    		$em = $this->getDoctrine()->getManager();
    		$cycle = $this->findUserById($userId)[0];
    		$cycle->setActive($active);
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
    
    public function findUserById($userId){
    	try{
    		$em = $this->getDoctrine()->getManager();
    		$query = $em->createQuery(
    				'SELECT u
	    			FROM TeAyudo\TeAyudoBundle\Entity\User u
	    			WHERE u.id= :userId'
    		)->setParameter('userId', $userId);
    		 
    		return $query->getResult();
    	} catch (DBALException $e) {
    		$this->setError('ERROR: Ocurrió un error, inténtelo nuevamente');
    	}
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
	public function getActiveUsers() {
		$em = $this->getDoctrine()->getManager();
	
		$query = $em->createQuery(
				'SELECT u
    			FROM TeAyudo\TeAyudoBundle\Entity\User u
    			WHERE u.active = true'
		);
	
		return $query->getResult();
	}
	public function getActiveCycles(){
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				'SELECT c
    			FROM TeAyudo\TeAyudoBundle\Entity\Cycle c
				WHERE c.active = true
    			ORDER BY c.date ASC'
		);
	
		return $query->getResult();
	}
}
