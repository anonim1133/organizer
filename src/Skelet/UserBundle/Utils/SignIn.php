<?php

namespace Skelet\UserBundle\Utils;

/**
 * Service to handle signing in
 *
 */
class SignIn {

    /**
     * @var ContainerInterface
     */
    private $services;
    
    /**
     * @var Array Containing errors
     */
    private $errors;

    public function __construct($container) {
	$this->services = $container;
    }

    /**
     * Returns signin form
     */
    public function getForm() {
	$entity = new \Skelet\UserBundle\Entity\Users();

	$form = $this->createSignInForm($entity);

	return $this->services->get('templating')->render('UserBundle:SignIn:sign_in.html.twig', [
		    'form' => $form->createView(),
		    'error' => $this->getErrors()
	]);
    }

    /**
     * Checks form for authentication&authorization
     * @param type $credentials ['login' => user login, 'password' => user password]
     * @return boolean
     */
    public function check($credentials) {
	$result = NULL;
	if ($this->services->get('Users.Authentify')->check($credentials['login'], $credentials['password'])) {
	    $this->services->get('Users.Authorize')->user($credentials['login']);

	    $result = TRUE;
	} else {
	    $result = FALSE;
	    $this->errors[] = 'Wrong username/password';
	}

	return $result;
    }

    /**
     * Returns erros as string
     * @return String|NULL
     */
    public function getErrors() {
	if (is_array($this->errors))
	    $result = implode('<br />', $this->errors);
	else $result = NULL;
	    return $result;
    }

    /**
     * Creates sign in form
     * @param  $entity \Skelet\UserBundle\Entity\Users
     * @return Form
     */
    private function createSignInForm($entity) {
	$form = $this->services->get('form.factory')->create(\Skelet\UserBundle\Form\UsersSignInType::class, $entity, array(
	    'action' => $this->services->get('router')->generate('signin'),
	    'method' => 'POST',
	));

	return $form;
    }

}
