<?php

namespace Skelet\UserBundle\Utils;

/**
 * Simple service to check if credentials given by user are correct
 *
 */
class Authentify {
    
    /**
     *
     * @var Doctrine\ORM\EntityManager 
     */
    private $em;

    public function __construct(\Doctrine\ORM\EntityManager $entityManager) {
	$this->em = $entityManager;
    }

    /**
     * Checks if user with exact password exists exists
     * @param type $login
     * @param type $password
     * @return boolean
     */
    public function check($login, $password) {
	$result = FALSE;
	$user = $this->em->getRepository('UserBundle:Users')->findOneBy(['login' => $login]);
	
	if (!empty($user) && password_verify($password, $user->getPassword())) {
	    $result = TRUE;
	    if (password_needs_rehash($password, PASSWORD_DEFAULT, ['cost' => $user->getPasswordCost()])) {
		$user->setPassword($password);
	    }
	}

	return $result;
    }

}
