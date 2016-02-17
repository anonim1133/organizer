<?php

namespace Skelet\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SignInController extends Controller {

    /**
     * @Route("/signIn", name="signin")
     */
    public function signInAction(Request $request) {
	$entity = new \Skelet\UserBundle\Entity\Users();

	$form = $this->createSignInForm($entity);
	$error = NULL;

	$credentials = $request->request->get('users_sign_in');

	if($this->get('Users.Authentify')->check($credentials['login'], $credentials['password'])){
	    $this->get('Users.Authorize')->user($credentials['login']);

	    $result = $this->redirectToRoute('homepage');
	}else{
	    if(count($credentials) > 0)
		$error = 'Wrong username/password';
	    
	    $result = $this->render('UserBundle:SignIn:sign_in.html.twig', [
		'form' => $form->createView(),
		'error' => $error
	    ]);
	}

	return $result;
    }

    /**
     * Creates sign in form
     * @param  $entity \Skelet\UserBundle\Entity\Users
     * @return Form
     */
    private function createSignInForm($entity) {
	$form = $this->createForm(\Skelet\UserBundle\Form\UsersSignInType::class, $entity, array(
	    'action' => $this->generateUrl('signin'),
	    'method' => 'POST',
	));

	return $form;
    }

}
