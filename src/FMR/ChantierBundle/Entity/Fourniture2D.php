<?php


namespace FMR\ChantierBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fourniture deux dimensions 
 *
 * @ORM\Entity()
 */
class Fourniture2D extends Fourniture1D
{
	
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @var float
	 *
	 * @ORM\Column(type="float")
	 */
	private $largeur;
	
}