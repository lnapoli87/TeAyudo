<?php

namespace TeAyudo\TeAyudoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TeAyudo\TeAyudoBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use TeAyudo\TeAyudoBundle\Form\MyAccountForm;

class MyAccountController extends Controller
{
	protected $theUser;
	protected $error;
	protected $successMessage = '';
    public function showAction(Request $req)
    {
        $this->setTheUser($this->get('security.context')->getToken()->getUser());
    	$userName = $this->getTheUser()->getName();
        return $this->render('TeAyudoBundle:myAccount:myAccount.html.twig', 
        		array('pageTitle' => 'TeAyudo.org - Mi Cuenta', 
        				'username' => $userName,
        				'error'=>$this->getError(), 
        				'user'=>$this->getTheUser(),
        				'userForm'=>$this->createUserForm($req),
        				'successMessage'=> $this->successMessage
        		));
    }
    
    public function createUserForm($req) {
    	$usrForm = $this->createFormBuilder ( $this->getAccountFormModel() )
    	->add('coords','hidden')
    	->add ( 'name', 'text' )
    	->add ( 'email', 'email' )
    	->add('telephone','text')
    	->add('cellphone','text')
    	->add('file')
    	->add ( 'save', 'submit', array ('label' => 'Guardar Cambios' )
    	)->getForm ();
    
    	$usrForm->handleRequest ( $req );
    	if ($usrForm->isValid ()) {
    		$data = $usrForm->getData();
    		$data->setCoords($_POST["hiddenLatLng"]);
    		$data->uploadPhoto();
    		$this->synchronizeUser($data);
    		$this->successMessage = 'Se han guardado los cambios correctamente';
    	}
    
    	return $usrForm->createView ();
    }
    
    public function getAccountFormModel(){
    	$sessionUser = $this->getTheUser();
    	$accountFormModel = new MyAccountForm();
    	$accountFormModel->setName($sessionUser->getName());
    	$accountFormModel->setEmail($sessionUser->getEmail());
    	$accountFormModel->setTelephone($sessionUser->getTelephone());
    	$accountFormModel->setCellphone($sessionUser->getCellphone());
    	$accountFormModel->setCoords($sessionUser->getCoords());
    	$accountFormModel->setPath($sessionUser->getPhotoPath());
    	return $accountFormModel;
    }
    
    public function synchronizeUser($submitedData){
    	$sessionUser = $this->getTheUser();
    	$sessionUser->setName($submitedData->getName());
    	$sessionUser->setTelephone($submitedData->getTelephone());
    	$sessionUser->setCellphone($submitedData->getCellphone());
    	$sessionUser->setCoords($submitedData->getCoords());
    	$sessionUser->setPhotoPath($submitedData->getPath());

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($sessionUser);
    	$em->flush();
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
	
	
	public function getAbsolutePath($user)
	{
		return null === $user->photoPath
		? null
		: $this->getUploadRootDir().'/'.$user->photoPath;
	}
	
	public function getWebPath()
	{
		return null === $this->photoPath
		? null
		: $this->getUploadDir().'/'.$this->photoPath;
	}
	
	protected function getUploadRootDir()
	{
		// the absolute directory path where uploaded
		// documents should be saved
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}
	
	protected function getUploadDir()
	{
		// get rid of the __DIR__ so it doesn't screw up
		// when displaying uploaded doc/image in the view.
		return 'uploads/documents';
	}
}
