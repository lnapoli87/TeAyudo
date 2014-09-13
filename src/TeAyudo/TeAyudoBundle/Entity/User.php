<?php

namespace TeAyudo\TeAyudoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use TeAyudo\TeAyudoBundle\Entity\Cycle;
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="Email already taken")
 */
class User implements UserInterface, \Serializable{
	
	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=200, nullable=false)
	 */
	protected $name;
	
	/**
	 * @ORM\Column(type="string", length=255, nullable=false, unique=true)
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 */
	protected $email;
	
	/**
	 * @ORM\Column(type="string", length=200, nullable=false)
	 */
	protected $password;
	
	/**
	 * @ORM\Column(type="string", length=500, nullable=true)
	 */
	protected $coords;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $telephone;
	
	/**
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $cellphone;
	
	/**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	protected $active;
	
	/**
	 * @ORM\Column(type="boolean", nullable=false)
	 */
	protected $admin;
	
	/**
	 * @ORM\OneToMany(targetEntity="Cycle", mappedBy="user", cascade={"persist", "remove", "merge"}, orphanRemoval=false)
	 */
	protected $cycles;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set coords
     *
     * @param string $coords
     * @return User
     */
    public function setCoords($coords)
    {
        $this->coords = $coords;

        return $this;
    }

    /**
     * Get coords
     *
     * @return string 
     */
    public function getCoords()
    {
        return $this->coords;
    }

    /**
     * Set telephone
     *
     * @param integer $telephone
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return integer 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set cellphone
     *
     * @param integer $cellphone
     * @return User
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;

        return $this;
    }

    /**
     * Get cellphone
     *
     * @return integer 
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * Set admin
     *
     * @param boolean $admin
     * @return User
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * Get admin
     *
     * @return boolean 
     */
    public function getAdmin()
    {
        return $this->admin;
    }
    
	/* (non-PHPdoc)
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getRoles()
	 */
public function getRoles()
{
    return array('ROLE_USER');
}

	/* (non-PHPdoc)
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getSalt()
	 */
	public function getSalt() {
		// TODO: Auto-generated method stub

	}

	/* (non-PHPdoc)
	 * @see \Symfony\Component\Security\Core\User\UserInterface::getUsername()
	 */
	public function getUsername() {
		// TODO: Auto-generated method stub

	}

	/* (non-PHPdoc)
	 * @see \Symfony\Component\Security\Core\User\UserInterface::eraseCredentials()
	 */
	public function eraseCredentials() {
		// TODO: Auto-generated method stub

	}
	
	/**
	 * @see \Serializable::serialize()
	 */
	public function serialize()
	{
		return serialize(array(
				$this->id,
				$this->email,
				$this->password,
				// see section on salt below
				// $this->salt,
		));
	}
	
	/**
	 * @see \Serializable::unserialize()
	 */
	public function unserialize($serialized)
	{
		list (
				$this->id,
				$this->email,
				$this->password,
				// see section on salt below
				// $this->salt
		) = unserialize($serialized);
	}
	
	/**
	 * Set email
	 *
	 * @param string $email
	 * @return User
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	
		return $this;
	}
	
	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}
	public function getCycles() {
		return $this->cycles;
	}
	public function setCycles($cycles) {
		$this->cycles = $cycles;
		return $this;
	}
	

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cycles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add cycles
     *
     * @param \TeAyudo\TeAyudoBundle\Entity\Cycle $cycles
     * @return User
     */
    public function addCycle(\TeAyudo\TeAyudoBundle\Entity\Cycle $cycles)
    {
        $this->cycles[] = $cycles;

        return $this;
    }

    /**
     * Remove cycles
     *
     * @param \TeAyudo\TeAyudoBundle\Entity\Cycle $cycles
     */
    public function removeCycle(\TeAyudo\TeAyudoBundle\Entity\Cycle $cycles)
    {
        $this->cycles->removeElement($cycles);
    }
	public function getActive() {
		return $this->active;
	}
	public function setActive($active) {
		$this->active = $active;
		return $this;
	}
	
}
