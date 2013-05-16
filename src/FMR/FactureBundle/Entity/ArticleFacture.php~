<?php

namespace FMR\FactureBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FMR\CommonBundle\Entity\ArticleBase;

/**
 * ArticleFacture
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FMR\OffreBundle\Entity\ArticleFactureRepository")
 */
class ArticleFacture extends ArticleBase
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
	 * @var FMR\FactureBundle\Entity\Facture
	 *
	 * @ORM\ManyToOne(targetEntity="FMR\FactureBundle\Entity\Facture", inversedBy="articles")
	 */
	private $facture;
}