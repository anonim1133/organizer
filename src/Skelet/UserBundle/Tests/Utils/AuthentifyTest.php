<?php

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Tests of Authentify service
 *
 */
class AuthentifyTest extends KernelTestCase {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    protected function setUp() {
	self::bootKernel();
    }

    public function testCorrectCredentials() {
	$authentify = static::$kernel->getContainer()->get('Users.Authentify');

	$this->assertEquals(true, $authentify->check('anonim1133', 'testt'));
    }

    public function testInCorrectCredentials() {
	$authentify = static::$kernel->getContainer()->get('Users.Authentify');

	$this->assertEquals(false, $authentify->check('anonim1133', 'tests'));
    }

}
