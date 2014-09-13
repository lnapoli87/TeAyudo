<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TeAyudo\TeAyudoBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class MyAccountController extends Controller
{
	protected $theUser;
	protected $error;
	
    public function showAction(Request $req)
    {
        $this->setTheUser($this->get('security.context')->getToken()->getUser());
    	$userName = $this->getTheUser()->getName();
        return $this->render('TeAyudoBundle:myAccount:myAccount.html.twig', 
        		array('pageTitle' => 'TeAyudo.org - Mi Cuenta', 
        				'username' => $userName,
        				'error'=>$this->getError(), 
        				'user'=>$this->getTheUser(),
        				'userForm'=>$this->createUserForm($req)
        		));
    }
    
    public function createUserForm($req) {
    	$usrForm = $this->createFormBuilder ( $this->getTheUser() )
    	->add('coords','hidden')
    	->add ( 'name', 'text' )
    	->add ( 'email', 'email' )
    	->add('telephone','text')
    	->add('cellphone','text')
    	->add ( 'save', 'submit', array ('label' => 'Guardar Cambios' )
    	)->getForm ();
    
    	$usrForm->handleRequest ( $req );
    	if ($usrForm->isValid ()) {
    		$data = $usrForm->getData();
    		if($data->getFormType() === 'userForm'){
    			
    		}
    	}
    
    	return $usrForm->createView ();
    }
	public function getTheUser() {
		return $this->theUser;
	}
	public function setTheUser($theUser) {
		$this->theUser = $theUser;
		return $this;
	}
	public function getError() {
		return $this->error;
	}
	public function setError($error) {
		$this->error = $error;
		return $this;
	}
	
	
}
