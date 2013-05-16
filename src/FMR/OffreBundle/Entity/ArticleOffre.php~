<?php

namespace FMR\OffreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FMR\CommonBundle\Entity\ArticleBase;

/**
 * ArticleOffre
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="FMR\OffreBundle\Entity\ArticleOffreRepository")
 */
class ArticleOffre extends ArticleBase
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
	 * @var FMR\OffreBundle\Entity\Offre
	 *
	 * @ORM\ManyToOne(targetEntity="FMR\OffreBundle\Entity\Offre", inversedBy="articles")
	 */
	private $offre;
}
