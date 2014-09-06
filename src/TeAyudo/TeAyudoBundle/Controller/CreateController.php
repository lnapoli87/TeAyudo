<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TeAyudo\TeAyudoBundle\Entity\User;
use Symfony\Component\BrowserKit\Response;
use TeAyudo\TeAyudoBundle\Entity\Cycle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;

class CreateController extends Controller
{
	protected $error="";
	protected $successMessage="";
	
    public function showAction(Request $req)
    {
    	$usr= $this->get('security.context')->getToken()->getUser();
    	$userName = $usr->getName();
       return $this->render('TeAyudoBundle:creation:createCycle.html.twig', 
       		array('pageTitle' => 'TeAyudo.org', 
       		   		'username' => $userName,
       				'error' => $this->error,
       				'successMessage' => $this->successMessage,
       				'cycleForm' => $this->createCycleForm($req,$usr)
       		));
    }
    
    public function createCycleForm($req,$usr) {
    	$cycleForm = $this->createFormBuilder ( new Cycle() )
    	->add('cycleType','choice', array(
    		'required'  => true,
    		'expanded' => true,
    		'choices'  => array('Necesito', 'Ofrezco')
		))
    	->add ( 'title', 'text' )
    	->add ( 'description', 'textarea' )
    	->add ( 'save', 'submit', array ('label' => 'Empezar Ciclo' )
    	)->getForm ();
    
    	$cycleForm->handleRequest ( $req );
    	if ($cycleForm->isValid ()) {
    		try{
    			$newCycle = $cycleForm->getData();
    			$newCycle->setDate(new \DateTime());
    			$newCycle->setEnded(false);
    			$newCycle->setActive(false);
    			$newCycle->setCoords('');
    			$newCycle->setUser($usr);
    			$em = $this->getDoctrine()->getEntityManager();
    			$em->persist($newCycle);
    			$em->flush($newCycle);
    			$this->setSuccessMessage("Se ha abierto un nuevo Ciclo. Un Administrador de TeAyudo.org validará el mismo y luego será visible para los demás usuarios del sitio. ¡Muchas gracias por tu aporte!");
    		} catch (DBALException $e) {
    			$this->setError('ERROR: Ocurrió un error, inténtelo nuevamente');
    		}
    	}
    
    	return $cycleForm->createView ();
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
