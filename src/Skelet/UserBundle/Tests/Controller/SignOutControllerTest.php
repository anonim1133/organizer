<?php

namespace Skelet\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SignOutControllerTest extends WebTestCase {

    public function testSignout() {
	$client = static::createClient();
	
	//Sign in first
	$crawler_in = $client->request('GET', '/signIn');

	$this->checkStatusCode($client, $crawler_in);

	$login = 'anonim1133';
	$password = 'testt';

	$form = $crawler_in->selectButton('SignIn')->form();

	$client->submit($form, [
	    'users_sign_in[login]' => $login,
	    'users_sign_in[password]' => $password,
	    ]);

	$crawler_redirect = $client->followRedirect();

	$this->checkStatusCode($client, $crawler_redirect);

	$this->assertEquals($login, trim($crawler_redirect->filter('span#signedin-login')->first()->text()));
	
	// Sign out
	$crawler_out = $client->request('GET', '/signOut');

	$this->checkStatusCode($client, $crawler_out, 302);
	
	$crawler_redirect_out = $client->followRedirect();
	
	$this->assertEquals('', trim($crawler_redirect_out->filter('span#signedin-login')->first()->text()));
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
