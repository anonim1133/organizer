<?php

namespace Skelet\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SignUpControllerTest extends WebTestCase {
    
    public function testSignUp() {
	$client = static::createClient();

	$crawler = $client->request('GET', '/signUp');

	$this->checkStatusCode($client, $crawler);
    }

    public function testTakenLogin() {
	$client = static::createClient();

	$crawler = $client->request('GET', '/signUp');

	$form = $crawler->selectButton('SignIn')->form();
	
	$login = 'anonim1133';
	$password = 'testt';

	$crawler_form = $client->submit($form, array(
	    'users_sign_up[login]' => $login,
	    'users_sign_up[password][first]' => $password,
	    'users_sign_up[password][second]' => $password
	));

	$this->checkStatusCode($client, $crawler_form);

	$this->assertEquals('Username is already taken', $crawler_form->filter('form[name=users_sign_up] > div ul')->first()->text());
    }

    public function testNewLogin() {
	$client = static::createClient();

	$crawler = $client->request('GET', '/signUp');

	$form = $crawler->selectButton('SignIn')->form();
	
	$login = substr(md5('login').time(), 24);
	$password = substr(md5('login').time(), 24);

	$crawler_form = $client->submit($form, [
	    'users_sign_up[login]' => $login,
	    'users_sign_up[password][first]' => $password,
	    'users_sign_up[password][second]' => $password
	]);

	$this->checkStatusCode($client, $crawler_form, 302);
	
	$crawler_form = $client->followRedirect();
	
	$this->checkStatusCode($client, $crawler_form);
	
	$this->assertEquals($login, $crawler_form->filter('h1#signup-status > span#login')->first()->text());
    }

    private function checkStatusCode($client, $crawler, $status = 200){
	if ($client->getResponse()->getStatusCode() !== $status) {
	    $block = $crawler->filter('div.text-exception > h1');
	    if ($block->count()) {
		echo $block->text();
	    }
	}

	$this->assertEquals($status, $client->getResponse()->getStatusCode());
    }
}
