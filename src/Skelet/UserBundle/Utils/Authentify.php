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
	$user = $this->em->getRepository('UserBundle:Users')->signin($login, $password);

	$result = FALSE;
	
	if(!empty($user))
	    $result = TRUE;
	    
	return $result;
    }

}
