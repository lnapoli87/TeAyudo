<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TeAyudo\TeAyudoBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

class AdminController extends Controller
{
	
	protected $error = '';
	protected $successMessage = '';
	protected $denySuccessMessage = '';
	
public function indexAction(Request $request)
    {
    	if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
    		throw new AccessDeniedException();
    	}else{
	    	$usr= $this->get('security.context')->getToken()->getUser();
	    	$userName = $usr->getName();
	        return $this->render('TeAyudoBundle:admin:adminIndex.html.twig', 
	        		array('pageTitle' => 'TeAyudo.org', 
	        				'username' => $userName,
	        				'newCycles'=>$this->getNewCycles(),
	        				'newUsers'=>$this->getNewUsers(),
	        				'activeUsers' => $this->getActiveUsers(),
	        				'activeCycles' => $this->getActiveCycles(),
	        				'deniedUsers' => $this->getDeniedUsers(),
	        				'deniedCycles' => $this->getDeniedCycles(),
	        				'error'=> $this->error,
	        				'successMessage'=> $this->successMessage,
	        				'denySuccessMessage'=>$this->denySuccessMessage
	        		));
    	}
    }
    
    public function approveUserAction(Request $request, $userId){
    	$this->changeUserStatusById($userId, true, false);
    	$this->successMessage = 'Se ha aprobado el usuario';
    	return $this->indexAction($request);
    }
    
    public function denyUserAction(Request $request, $userId){
    	$this->changeUserStatusById($userId, false, true);
    	$this->denySuccessMessage = 'Se ha denegado el usuario';
    	return $this->indexAction($request);
    }
    
    public function approveCycleAction(Request $request, $cycleId){
    	$this->changeCycleStatusById($cycleId, true, false);
    	$this->successMessage = 'Se ha aprobado el ciclo';
    	return $this->indexAction($request);
    }
    
    public function denyCycleAction(Request $request, $cycleId){
    	$this->changeCycleStatusById($cycleId, false, true);
    	$this->denySuccessMessage = 'Se ha denegado el ciclo';
    	return $this->indexAction($request);
    }
    
    public function changeCycleStatusById($cycleId, $active, $denied){
    	try{
    		$em = $this->getDoctrine()->getManager();
    		$cycle = $this->findCycleById($cycleId)[0];
    		$cycle->setActive($active);
    		$cycle->setDenied($denied);
    		$em->merge($cycle);
    		$em->flush();
    	} catch (DBALException $e) {
    		$this->setError('ERROR: Ocurrió un error, inténtelo nuevamente');
    	}
    }
    
    public function changeUserStatusById($userId, $active, $denied){
    	try{
    		$em = $this->getDoctrine()->getManager();
    		$user = $this->findUserById($userId)[0];
    		$user->setActive($active);
    		$user->setDenied($denied);
    		$em->merge($user);
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
				WHERE c.active = false and c.denied = false
    			ORDER BY c.date ASC'
		);
	
		return $query->getResult();
	}
	public function getNewUsers() {
		$em = $this->getDoctrine()->getManager();
		
		$query = $em->createQuery(
				'SELECT u
    			FROM TeAyudo\TeAyudoBundle\Entity\User u
    			WHERE u.active = false and u.denied = false'
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
	public function getDeniedUsers() {
		$em = $this->getDoctrine()->getManager();
	
		$query = $em->createQuery(
				'SELECT u
    			FROM TeAyudo\TeAyudoBundle\Entity\User u
    			WHERE u.denied = true'
		);
	
		return $query->getResult();
	}
	public function getDeniedCycles(){
		$em = $this->getDoctrine()->getManager();
		$query = $em->createQuery(
				'SELECT c
    			FROM TeAyudo\TeAyudoBundle\Entity\Cycle c
				WHERE c.denied = true
    			ORDER BY c.date ASC'
		);
	
		return $query->getResult();
	}
	public function getError() {
		return $this->error;
	}
	public function setError($error) {
		$this->error = $error;
		return $this;
	}
	public function getSuccessMessage() {
		return $this->successMessage;
	}
	public function setSuccessMessage($successMessage) {
		$this->successMessage = $successMessage;
		return $this;
	}
	
}
