<?php

namespace FMR\LignesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use FMR\LignesBundle\Form\TitreType;

/**
 * Entité Ligne
 *
 * @author Fabrice Maillefer <fabrice.maillefer@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Titre extends Ligne
{
	/*
	 * Attributs
	 */
	
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


 	/**
     * @var string
     * @Assert\NotBlank(message="Le titre ne doit pas être vide")
     * @ORM\Column(name="Descriptif", type="string", length=255)
     */
    private $titre;


    
    /*
     * Methode magique
     */

    public function __construct() {
    	parent::__construct();
    }

    /**
     * Retourne le formulaire correspondant au type d'article
     *
     * @return FournitureType
     */
    public function getForm(){
    	return new TitreType($this->id);
    }
    
    public function getLabelAjout(){
    	return "Ajouter un titre";
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    
        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }


}