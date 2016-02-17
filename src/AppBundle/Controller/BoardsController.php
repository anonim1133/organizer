<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class BoardsController extends Controller {

    /**
     * @Route("/create", name="create_board")
     */
    public function createAction(Request $request) {
	$entity = new \AppBundle\Entity\Boards();
	$form = $this->createCreateForm($entity);

	$form->handleRequest($request);

	if ($form->isValid()) {
	    $em = $this->getDoctrine()->getManager();
	    $em->persist($entity);
	    $em->flush();
	    
	    $result = $this->redirectToRoute('showBoard', ['idBoard' => $entity->getId()]);
	}else{
	    $result = $this->render('AppBundle:Boards:create.html.twig', array(
		    'form' => $form->createView(),
	    ));
	}

	return  $result;
    }

    /**
     * @Route("/list")
     */
    public function listAction() {
	$boards = $this->getDoctrine()->getManager()->getRepository('AppBundle:Boards')->findAll();
	
	return $this->render('AppBundle:Boards:list.html.twig', array(
	    'boards' => $boards
	));
    }

    /**
     * @Route("/show/{idBoard}", name="showBoard")
     */
    public function showAction($idBoard) {
	return $this->render('AppBundle:Boards:show.html.twig', array(
			// ...
	));
    }

    /**
     * @Route("/remove")
     */
    public function removeAction() {
	return $this->render('AppBundle:Boards:remove.html.twig', array(
			// ...
	));
    }

    /**
     * @Route("/update")
     */
    public function updateAction() {
	return $this->render('AppBundle:Boards:update.html.twig', array(
			// ...
	));
    }

    /**
     * Creates form for creating new Boards
     * @param  $entity \Skelet\UserBundle\Entity\Users
     * @return Form
     */
    private function createCreateForm($entity) {
	$form = $this->createForm(\AppBundle\Form\BoardsType::class, $entity, array(
	    'action' => $this->generateUrl('create_board'),
	    'method' => 'POST',
	));

	return $form;
    }

}
