<?php
namespace FMR\CommonBundle\Configurator\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * 
 * Formulaire servant à faire éxéctuer l'installation de la base de données
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 */
class DatabaseCreateStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    public function getName()
    {
        return 'frmcommonbundle_databasecreate_step';
    }
}
