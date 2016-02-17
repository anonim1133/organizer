<?php

namespace Skelet\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SignInControllerTest extends WebTestCase {

    public function testSignIn() {
	$client = static::createClient();

	$crawler = $client->request('GET', '/signIn');

	$this->checkStatusCode($client, $crawler);

	$login = 'anonim1133';
	$password = 'testt';

	$form = $crawler->selectButton('SignIn')->form();

	$crawler_form = $client->submit($form, array(
	    'users_sign_in[login]' => $login,
	    'users_sign_in[password]' => $password,
	));

	$crawler_redirect = $client->followRedirect();

	$this->checkStatusCode($client, $crawler_redirect);

	$this->assertEquals($login, trim($crawler_redirect->filter('span#signedin-login')->first()->text()));
    }

    public function testWrongPassword() {
	$client = static::createClient();

	$crawler = $client->request('GET', '/signIn');

	$this->checkStatusCode($client, $crawler);

	$login = 'anonim1133';
	$password = 'tests';

	$form = $crawler->selectButton('SignIn')->form();

	$crawler_form = $client->submit($form, array(
	    'users_sign_in[login]' => $login,
	    'users_sign_in[password]' => $password,
	));

	$this->checkStatusCode($client, $crawler);

	$this->assertEquals('Wrong username/password', trim($crawler_form->filter('div#error span')->first()->text()));
    }

    /**
     * First sign up, then try to sign in with that credentials
     */
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
	
	$crawler_redirect = $client->followRedirect();
	
	$this->checkStatusCode($client, $crawler_form);
	
	$this->assertEquals($login, $crawler_redirect->filter('h1#signup-status > span#login')->first()->text());
	
	//Now its time to sign in with new credentials
	
	$crawler_signin = $client->request('GET', '/signIn');

	$this->checkStatusCode($client, $crawler_signin);
	
	$form_sign_in = $crawler_signin->selectButton('SignIn')->form();

	$crawler_form_sign_in = $client->submit($form_sign_in, array(
	    'users_sign_in[login]' => $login,
	    'users_sign_in[password]' => $password,
	));

	$crawler_redirect_sign_in = $client->followRedirect();

	$this->checkStatusCode($client, $crawler_redirect_sign_in);

	$this->assertEquals($login, trim($crawler_redirect_sign_in->filter('span#signedin-login')->first()->text()));
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
