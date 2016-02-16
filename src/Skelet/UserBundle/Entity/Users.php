<?php

namespace Skelet\UserBundle\Entity;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Skelet\UserBundle\Repository\UsersRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity("login", message="Username is already taken"))
 */
class Users {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=32, unique=true)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=32, unique=true)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_date", type="datetime")
     */
    private $registrationDate;

    /**
     * @ORM\PrePersist
     */
    public function onPrePersistSetRegistrationDate() {
	$this->registrationDate = new \DateTime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return Users
     */
    public function setLogin($login) {
	$this->login = $login;

	return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin() {
	return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password) {
	$this->password = md5($password);

	return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword() {
	return $this->password;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime 
     */
    public function getRegistrationDate() {
	return $this->registrationDate;
    }

}
