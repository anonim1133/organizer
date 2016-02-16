<?php

namespace Skelet\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UsersType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
	$builder
		->add('login')
		->add('password', PasswordType::class, [
		    'constraints' => [
			new NotBlank(),
			new Length(array('min' => 5)),
	       ],
		])
		->add('submit', SubmitType::class, ['label' => 'SignIn']);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
	$resolver->setDefaults(array(
	    'data_class' => 'Skelet\UserBundle\Entity\Users'
	));
    }

}
