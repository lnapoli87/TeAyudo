<?php
namespace TeAyudo\TeAyudoBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MyAccountForm {
	protected $name;
	protected $email;
	protected $telephone;
	protected $cellphone;
	protected $coords;
	/**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
		
	public $path;
	
	public function getAbsolutePath()
	{
		return null === $this->path
		? null
		: $this->getUploadRootDir().'/'.$this->path;
	}
	
	public function getWebPath()
	{
		return null === $this->path
		? null
		: $this->getUploadDir().'/'.$this->path;
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
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	public function getEmail() {
		return $this->email;
	}
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}
	public function getTelephone() {
		return $this->telephone;
	}
	public function setTelephone($phone) {
		$this->telephone = $phone;
		return $this;
	}
	public function getCellphone() {
		return $this->cellphone;
	}
	public function setCellphone($cellphone) {
		$this->cellphone = $cellphone;
		return $this;
	}
	public function getCoords() {
		return $this->coords;
	}
	public function setCoords($coords) {
		$this->coords = $coords;
		return $this;
	}
	public function getPath() {
		return $this->path;
	}
	public function setPath($path) {
		$this->path = $path;
		return $this;
	}
	
	
	public function uploadPhoto()
	{
		// the file property can be empty if the field is not required
		if (null === $this->getFile()) {
			return;
		}
	
		// use the original file name here but you should
		// sanitize it at least to avoid any security issues
	
		// move takes the target directory and then the
		// target filename to move to
		$this->getFile()->move(
				$this->getUploadRootDir(),
				$this->getFile()->getClientOriginalName()
		);
	
		// set the path property to the filename where you've saved the file
		$this->path = $this->getFile()->getClientOriginalName();
	
		// clean up the file property as you won't need it anymore
		$this->file = null;
	}
	
	
}