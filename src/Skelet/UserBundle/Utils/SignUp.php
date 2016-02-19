<?php

namespace Skelet\UserBundle\Utils;

/**
 * Service to handle signing up
 *
 */
class SignUp {

    /**
     * @var ContainerInterface
     */
    private $services;

    /**
     * @var Array Containing errors
     */
    private $errors;
    private $form;
    private $user;

    public function __construct($container) {
	$this->services = $container;
	$this->form = $this->createSignUpForm();
	$this->user = new \Skelet\UserBundle\Entity\Users();
    }

    /**
     * Returns signup form HTML
     */
    public function getForm() {
	return $this->services->get('templating')->render('UserBundle:SignUp:sign_up.html.twig', [
		    'form' => $this->form->createView(),
		    'error' => $this->getErrors()
	]);
    }

    /**
     * Creates a new user
     * @param \Skelet\UserBundle\Utils\Request $request
     * @return String|NULL
     * User login, or nul on error
     */
    public function handleForm(\Symfony\Component\HttpFoundation\Request $request) {
	$this->form->handleRequest($request);
	if ($this->form->isValid()) {
	    $user = $this->form->getData();
	    try {
		$em = $this->services->get('doctrine.orm.entity_manager');
		$em->persist($user);
		$em->flush();
		$result = $user->getLogin();
	    } catch (Exception $exc) {
		$result = FALSE;
	    }
	} else {
	    $result = FALSE;
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
	else
	    $result = NULL;
	return $result;
    }

    /**
     * Creates sign up form
     * @return Form
     */
    private function createSignUpForm() {
	$form = $this->services->get('form.factory')->create(\Skelet\UserBundle\Form\UsersSignUpType::class, $this->user, array(
	    'action' => $this->services->get('router')->generate('signup'),
	    'method' => 'POST',
	));

	return $form;
    }

}
