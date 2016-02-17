<?php

namespace Skelet\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

class SignOutController extends Controller {

    /**
     * @Route("/signOut")
     */
    public function signOutAction(Request $request) {
	$session = $request->getSession();

	$token = new AnonymousToken("", "");
	$this->get('security.token_storage')->setToken($token);
	$session->set('_security_main', serialize($token));

	$session->clear();

	return $this->redirectToRoute('homepage');
    }

}
