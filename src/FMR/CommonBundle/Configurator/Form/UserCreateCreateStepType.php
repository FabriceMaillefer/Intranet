<?php
namespace FMR\CommonBundle\Configurator\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 */
class UserCreateStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
    }

    public function getName()
    {
        return 'frmcommonbundle_databasecreate_step';
    }
}
