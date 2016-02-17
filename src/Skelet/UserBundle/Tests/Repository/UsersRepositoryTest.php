<?php

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Tests of User Entity Repository
 *
 */
class UsersRepositoryTest extends KernelTestCase {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    protected function setUp() {
	self::bootKernel();

	$this->em = static::$kernel->getContainer()
		->get('doctrine')
		->getManager();
    }

    public function testSignIn() {
	$signin_correct = $this->em->getRepository('UserBundle:Users')->signin('anonim1133', '$2y$10$gVAaeYhRAytPVm/mOPHipOwX5j4OQlQ22rdynkSYKeoOIDiv6rgY6');
	$signin_incorrect = $this->em->getRepository('UserBundle:Users')->signin('anonim1133', 'tests');

	$this->assertEquals('anonim1133', $signin_correct->getLogin());
	$this->assertNull($signin_incorrect);
    }

}
