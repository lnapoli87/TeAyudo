<?php

namespace TeAyudo\TeAyudoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use TeAyudo\TeAyudoBundle\Entity\User;
use \DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="cycle")
 */
class Cycle {

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $cycleType;
	/**
	 * @ORM\Column(type="string", length=200, nullable=false)
	 */
	protected $title;
	/**
	 * @ORM\Column(type="string", length=500, nullable=false)
	 */
	protected $contactData;
	/**
	 * @ORM\ManyToOne(targetEntity="User", cascade={"all"}, fetch="EAGER")
	 */
	protected $user;
	/**
	 * @ORM\Column(type="string", length=2000, nullable=false)
	 */
	protected $description;
	/** 
	 * @ORM\Column(type="datetime")
	 */
	protected $date;
	/**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	protected $ended;
	/**
	 * @ORM\Column(type="string", length=500)
	 */
	protected $coords;
	/**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	protected $active;
	/**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	protected $denied;
	
	
	
	

    public function getId()
    {
        return $this->id;
    }
	public function getCycleType() {
		return $this->cycleType;
	}
	public function setCycleType($cycleType) {
		$this->cycleType = $cycleType;
		return $this;
	}
	public function getTitle() {
		return $this->title;
	}
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
	public function getUser() {
		return $this->user;
	}
	public function setUser($user) {
		$this->user = $user;
		return $this;
	}
	public function getDescription() {
		return $this->description;
	}
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	public function getDate() {
		return $this->date;
	}
	public function setDate($date) {
		$this->date = $date;
		return $this;
	}
	public function getEnded() {
		return $this->ended;
	}
	public function setEnded($ended) {
		$this->ended = $ended;
		return $this;
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

    /**
     * Set active
     *
     * @param boolean $active
     * @return Cycle
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
    
    
    
    public function setDenied($denied)
    {
    	$this->denied = $denied;
    
    	return $this;
    }
    public function getDenied()
    {
    	return $this->denied;
    }
    public function getDateString(){
    	return $this->date->format('d-m-Y H:i');
    }
	public function getContactData() {
		return $this->contactData;
	}
	public function setContactData($contactData) {
		$this->contactData = $contactData;
		return $this;
	}
	public function setId($id) {
		$this->id = $id;
		return $this;
	}
	
	
}
