<?php
namespace FMR\CommonBundle\Configurator\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Formulaire pour la création d'un utilisateur depuis le web configurator
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 */
class UserCreateStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
    	->add('username', null, array('label' => 'Nom d\'utilisateur'))
    	->add('email', 'text', array('label' => 'Adresse Email'))
    	->add('password', 'repeated', array(
    			'type' => 'password',
    			'first_options' => array('label' => 'Mot de passe'),
    			'second_options' => array('label' => 'Confirmation'),
    			'invalid_message' => 'Les mots de passe ne correspondent pas',
    	))
    	;
    }

    public function getName()
    {
        return 'frmcommonbundle_usercreate_step';
    }
}
