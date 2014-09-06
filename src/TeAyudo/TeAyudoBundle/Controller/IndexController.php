<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TeAyudo\TeAyudoBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use TeAyudo\TeAyudoBundle\Form\RegistrationForm;
use TeAyudo\TeAyudoBundle\Form\LoginForm;
use Symfony\Component\Security\Core\SecurityContextInterface;
use TeAyudo\TeAyudoBundle\Entity\UserRepository;
use Doctrine\DBAL\DBALException;

class IndexController extends Controller {
	protected $error = '';
	protected $registerError = '';
	protected $lastUsername = '';
	protected $registrationSuccess= '';
	
	public function indexAction(Request $request) {
		return $this->render ( 'TeAyudoBundle:home:index.html.twig', array (
				'pageTitle' => 'TeAyudo.org',
				'registrationForm' => $this->createRegistrationForm ( $request ),
				'loginForm' => $this->createLoginForm ( $request ),
				'last_username' => $this->lastUsername,
				'error' => $this->error,
				'pageTitle' => 'Ingrese sus credenciales',
				'registerError' => $this->getRegisterError(),
				'registrationSuccess'=>$this->getRegistrationSuccess()
		) );
	}

	public function createRegistrationForm($req) {
		$registration = new RegistrationForm ();
		
		$regForm = $this->createFormBuilder ( $registration )
				->add('formType','hidden')
				->add ( 'name', 'text' )
				->add ( 'email', 'email' )->add ( 'password', 'password' )
				->add ( 'passwordRepeat', 'password' )
				->add ( 'save', 'submit', array ('label' => 'Registrarse' )
		)->getForm ();
		
		$regForm->handleRequest ( $req );
		if ($regForm->isValid ()) {
			$data = $regForm->getData();
			if($data->getFormType() === 'registrationForm'){
				if($data->getPassword() === $data->getPasswordRepeat()){
					try{
						$newUser = $this->createUserFromRegistrationForm($data);
						$em = $this->getDoctrine()->getEntityManager();
						$em->persist($newUser);
						$em->flush($newUser);
						$this->setRegistrationSuccess('Se ha registrado correctamente su usuario. Ahora puede ingresar con sus credenciales.');
					} catch (DBALException $e) {
						$this->setRegisterError('ERROR: ya existe un usuario con el mismo Email');
					}
				}else{
					$this->setRegisterError('La contraseña y la confirmación deben ser iguales');
				}
			}
		}
		
		return $regForm->createView ();
	}
	
	
	public function createLoginForm($request) {
		$session = $request->getSession();

		if($request->attributes->has('registrationForm')){		
			// get the login error if there is one
			if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
				$this->error = $request->attributes->get(
						SecurityContextInterface::AUTHENTICATION_ERROR
				);
			} elseif (null !== $session &&
					$session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
				$this->error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
				$session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
			} else {
				$this->error = '';
			}
			// last username entered by the user
			$this->lastUsername = (null === $session) ? '' :
			$session->get(SecurityContextInterface::LAST_USERNAME);
		}
		
	}
	
	public function getLoginError() {
		return $this->loginError;
	}
	public function setLoginError($loginError) {
		$this->loginError = $loginError;
		return $this;
	}
	
	public function createUserFromRegistrationForm(RegistrationForm $registrationFormData){
		$newUser = new User();
		$newUser->setAdmin(false); 
		$newUser->setName($registrationFormData->getName());
		$newUser->setPassword($registrationFormData->getPassword());
		$newUser->setEmail($registrationFormData->getEmail());
		
		return $newUser;
	}
	public function getRegisterError() {
		return $this->registerError;
	}
	public function setRegisterError($registerError) {
		$this->registerError = $registerError;
		return $this;
	}
	public function getError() {
		return $this->error;
	}
	public function setError($error) {
		$this->error = $error;
		return $this;
	}
	public function getRegistrationSuccess() {
		return $this->registrationSuccess;
	}
	public function setRegistrationSuccess($registrationSuccess) {
		$this->registrationSuccess = $registrationSuccess;
		return $this;
	}
	
		

}
