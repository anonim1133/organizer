<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BoardsControllerTest extends WebTestCase {

    public function testCreateMainBoard() {
	$client = static::createClient();

	$crawler = $client->request('GET', $client->getContainer()->get('router')->generate('create_board'));

	$form = $crawler->selectButton('Create')->form();

	$title = 'title_' . md5(time());
	$description = 'description_' . md5(time());

	$crawler_form = $client->submit($form, [
	    'boards[title]' => $title,
	    'boards[description]' => $description,
	]);

	$this->checkStatusCode($client, $crawler_form, 302);
    }

    public function testList() {
	$client = static::createClient();

	$crawler = $client->request('GET', '/list');
	
	$this->assertGreaterThan(0, $crawler->filter('ul#boards li.parent-board p.title')->count());
    }

    public function testShow() {
	$client = static::createClient();

	$crawler = $client->request('GET', '/show');

//	$crawler_redirect = $client->followRedirect();
//
//	$this->assertMatch('/', $client->getResponse()->headers->get('location'));
//
//	$this->assertEquals($title, $crawler_redirect->filter('div.parent-board[title="' . $title . ' span.board-title"]')->first()->text());
    }

    public function testRemove() {
	$client = static::createClient();

	$crawler = $client->request('GET', '/remove');
    }

    public function testUpdate() {
	$client = static::createClient();

	$crawler = $client->request('GET', '/update');
    }

    private function checkStatusCode($client, $crawler, $status = 200) {
	if ($client->getResponse()->getStatusCode() !== $status) {
	    $block = $crawler->filter('div.text-exception > h1');
	    if ($block->count()) {
		echo $block->text();
	    }
	}

	$this->assertEquals($status, $client->getResponse()->getStatusCode());
    }

}
