<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AuthController extends Controller {

    /**
     * @Route("/signIn", name="signin")
     */
    public function signinAction(Request $request) {
	$signin = $this->get('Users.SignIn');

	$credentials = $request->request->get('users_sign_in');

	if (!empty($credentials && is_array($credentials))) {
	    if ($signin->check($credentials)) {
		$result = $this->redirectToRoute('homepage');
	    } else {
		$result = $this->render('AppBundle:Auth:signin.html.twig', [
		    'form' => $signin->getForm()
		]);
	    }
	} else {
	    $result = $this->render('AppBundle:Auth:signin.html.twig', [
		'form' => $signin->getForm()
	    ]);
	}

	return $result;
    }

    /**
     * @Route("/signUp", name="signup")
     */
    public function signupAction(Request $request) {
	$signup = $this->get('Users.SignUp');
	
	$username = $signup->handleForm($request);
	
	if(!empty($username)){
	    $result = $this->redirectToRoute('signupSuccess', ['login' => $username]);
	}else{
	    $result = $this->render('AppBundle:Auth:signup.html.twig', [
		    'form' => $signup->getForm()
	    ]);
	}
	
	return $result;
    }

    /**
     * @Route("/signUp/success/{login}", name="signupSuccess")
     * @Template("signup_success")
     */
    public function successAction(Request $request, $login) {
	return $this->render('UserBundle:SignUp:success.html.twig', [
		    'login' => $login
	]);
    }

    /**
     * @Route("/signOut")
     */
    public function signoutAction(Request $request) {
	$this->get('Users.SignOut')->clear($request->getSession());

	return $this->redirectToRoute('homepage');
    }

}
