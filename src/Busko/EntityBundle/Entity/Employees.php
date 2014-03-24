<?php

namespace Busko\EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Employees
 */
class Employees extends BaseUser
{   
     public function __construct()
    {
        parent::__construct();
        $this->phone = new \Doctrine\Common\Collections\ArrayCollection();// your own logic
        $this->driver = new \Doctrine\Common\Collections\ArrayCollection();
        $this->assistant = new \Doctrine\Common\Collections\ArrayCollection();
    }
    private $assistant;
    private $driver;
    /**
     * @var string
     */
    private $phone;


    private $branchId;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $streetNo;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    protected $id;


    /**
     * Set username
     *
     * @param string $username
     * @return Employees
     */
   /* public function setPhone( $phone)
    {
        $this->phone[] = $phone;

        return $this;
    }*/

    /**
     * Remove phone
     *
     * @param \Busko\EntityBundle\Entity\EmployeePhones $phone
     */
    public function removePhone(EmployeePhones $phone)
    {
        $this->phone->removeElement($phone);
    }
   

    /**
     * Get phone
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhone()
    {
        return $this->phone;
    }
     public function getDriver()
    {
        return $this->driver;
    }
    public function getAssistant()
    {
        return $this->assistant;
    }
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Employees
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
     * Set branchId
     *
     * @param string $branchId
     * @return Employees
     */
    public function setBranchId($branchId)
    {
        $this->branchId = $branchId;

        return $this;
    }

    /**
     * Get branchId
     *
     * @return string 
     */
    public function getBranchId()
    {
        return $this->branchId;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Employees
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Employees
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set streetNo
     *
     * @param string $streetNo
     * @return Employees
     */
    public function setStreetNo($streetNo)
    {
        $this->streetNo = $streetNo;

        return $this;
    }

    /**
     * Get streetNo
     *
     * @return string 
     */
    public function getStreetNo()
    {
        return $this->streetNo;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Employees
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Employees
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;
        return $this->id;
    }
    
}
