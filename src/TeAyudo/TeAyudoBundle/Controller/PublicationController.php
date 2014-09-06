<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PublicationController extends Controller
{
	protected $user;
	protected $error='';
	protected $cycle;
	
    public function showAction(Request $req, $cycleId)
    {
    	$this->setUser($this->get('security.context')->getToken()->getUser());
    	$userName = $this->getUser()->getName();
    	$this->findCycleById();
        return $this->render('TeAyudoBundle:Default:index.html.twig', 
        		array('pageTitle' => 'TeAyudo.org',
        				'username' => $userName,
						'error'=>$this->error,
        				'cycle'=>$this->getCycle()       				
        		));
    }
    
    
    public function findCycleById(){
    	try{
	    	$em = $this->getDoctrine()->getManager();
	    	$query = $em->createQuery(
	    			'SELECT c
	    			FROM TeAyudo\TeAyudoBundle\Entity\Cycle c
	    			WHERE id= :cycleId'
    	);
    	
    	$this->cycle = $query->getResult();
    	} catch (DBALException $e) {
    		$this->setError('ERROR: Ocurrió un error, inténtelo nuevamente');
    	}
    }
	public function getUser() {
		return $this->user;
	}
	public function setUser($user) {
		$this->user = $user;
		return $this;
	}
	public function getError() {
		return $this->error;
	}
	public function setError($error) {
		$this->error = $error;
		return $this;
	}
	public function getCycle() {
		return $this->cycle;
	}
	public function setCycle($cycle) {
		$this->cycle = $cycle;
		return $this;
	}
	
}
