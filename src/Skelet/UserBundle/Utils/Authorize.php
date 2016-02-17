<?php

namespace Skelet\UserBundle\Utils;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Simple service to authorize user
 *
 */
class Authorize {

    /**
     *
     * @var Doctrine\ORM\EntityManager 
     */
    private $em;

    /**
     *
     * @var ContainerInterface 
     */
    private $services;

    /**
     * @var Session
     */
    private $session;

    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param ContainerInterface $services
     * @param \Skelet\UserBundle\Utils\Session $session
     */
    public function __construct(\Doctrine\ORM\EntityManager $entityManager, ContainerInterface $services, Session $session) {
	$this->em = $entityManager;
	$this->services = $services;
	$this->session = $session;
    }

    /**
     * Sets session, and authorizes user.
     * @param type $login
     * @return boolean
     */
    public function user($login) {
	$user = $this->em->getRepository('UserBundle:Users')->findOneBy(array('login' => $login));

	if (empty($user)) {
	    $result = FALSE;
	} else {
	    $token = new UsernamePasswordToken($user->getLogin(), $user->getPassword(), 'main', ['USER']);
	    $this->services->get('security.token_storage')->setToken($token);
	    $this->session->set('_security_main', serialize($token));

	    $result = $user;

	    return $result;
	}
    }

}
