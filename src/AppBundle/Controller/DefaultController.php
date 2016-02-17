<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
	$username = $this->get('security.token_storage')->getToken()->getUser();
	return $this->render('default/index.html.twig', [
		    'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
		    'username' => $username,
	]);
    }

}
