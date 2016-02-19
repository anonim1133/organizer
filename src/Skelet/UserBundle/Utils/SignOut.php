<?php

namespace Skelet\UserBundle\Utils;

use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * Service to handle signing out
 *
 */
class SignOut {

    /**
     * @var ContainerInterface
     */
    private $services;
    
    public function __construct($container) {
	$this->services = $container;
    }

    /**
     * Clears session and sets anonymous token
     * 
     */
    public function clear($session) {
	$token = new AnonymousToken("", "");
	$this->services->get('security.token_storage')->setToken($token);
	$session->set('_security_main', serialize($token));

	$session->clear();
    }
}
