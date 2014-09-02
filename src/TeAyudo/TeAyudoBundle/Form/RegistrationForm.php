<?php

namespace TeAyudo\TeAyudoBundle\Form;

class RegistrationForm {

	protected $name;
	protected $email;
	protected $password;
	protected $passwordRepeat;
	protected $formType = 'registrationForm';

	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setCoords($coords)
	{
		$this->coords = $coords;

		return $this;
	}

	public function getCoords()
	{
		return $this->coords;
	}

	public function setTelephone($telephone)
	{
		$this->telephone = $telephone;

		return $this;
	}

	public function getTelephone()
	{
		return $this->telephone;
	}

	public function setCellphone($cellphone)
	{
		$this->cellphone = $cellphone;

		return $this;
	}

	public function getCellphone()
	{
		return $this->cellphone;
	}

	public function setAdmin($admin)
	{
		$this->admin = $admin;

		return $this;
	}

	public function getAdmin()
	{
		return $this->admin;
	}
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}
	public function getPasswordRepeat() {
		return $this->passwordRepeat;
	}
	public function setPasswordRepeat($passwordRepeat) {
		$this->passwordRepeat = $passwordRepeat;
		return $this;
	}
	public function getFormType() {
		return $this->formType;
	}
	public function setFormType($formType) {
		$this->formType = $formType;
		return $this;
	}
	


}

