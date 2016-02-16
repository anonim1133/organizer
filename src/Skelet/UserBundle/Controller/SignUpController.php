<?php

namespace Skelet\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class SignUpController extends Controller {

    /**
     * @Route("/signUp", name="signup")
     */
    public function signUpAction(Request $request) {
	$result = NULL;
	
	$entity = new \Skelet\UserBundle\Entity\Users();

	$form = $this->createSignUpForm($entity);
	$form->handleRequest($request);

	if ($form->isValid()) {
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($entity);
	    $em->flush();
	    
	    $result = $this->redirectToRoute('signupSuccess', ['login' => $entity->getLogin()]);
	}else{
	    $result = $this->render('UserBundle:SignUp:sign_up.html.twig', [
		    'form' => $form->createView()
	    ]);
	}

	return $result;
    }

    /**
     * @Route("/signUp/success/{login}", name="signupSuccess")
     */
    public function successAction(Request $request, $login) {
	return $this->render('UserBundle:SignUp:success.html.twig', [
	    'login' => $login
	]);
    }

    /**
     * Creates sign up form
     * @param  $entity \Skelet\UserBundle\Entity\Users
     * @return Form
     */
    private function createSignUpForm($entity) {
	$form = $this->createForm(\Skelet\UserBundle\Form\UsersType::class, $entity, array(
	    'action' => $this->generateUrl('signup'),
	    'method' => 'POST',
	));

	return $form;
    }

}
