<?php
namespace FMR\CommonBundle\Configurator\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * Formulaire servant à faire éxéctuer l'installation des tables de la bd
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 */
class SchemaCreateStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function getName()
    {
        return 'frmcommonbundle_databasecreate_step';
    }
}
