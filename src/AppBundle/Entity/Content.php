<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Content
 *
 * @ORM\Table(name="content")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContentRepository")
 */
class Content
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="subtitle", type="string", length=255 , nullable=true)
     */
    private $subtitle;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text", nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

   /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Article"  ,inversedBy="contents")
   */
    private $article;

        /**
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Explication")
   */
    private $explication;

        /**
     * @var string
     *
     * @ORM\Column(name="validated", type="boolean", nullable=true)
     */
    private $validated;

    /**
     * Constructor
     */
    public function __construct($text=null,$subtitle=null)
    {
        $this->text = $text;
         $this->subtitle = $subtitle;
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
     * Set subtitle
     *
     * @param string $subtitle
     * @return Content
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string 
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Content
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Content
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set article
     *
     * @param \AppBundle\Entity\Article $article
     * @return Content
     */
    public function setArticle(\AppBundle\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \AppBundle\Entity\Article 
     */
    public function getArticle()
    {
        return $this->article;
    }


    /**
     * Set explication
     *
     * @param \AppBundle\Entity\Explication $explication
     *
     * @return Content
     */
    public function setExplication(\AppBundle\Entity\Explication $explication = null)
    {
        $this->explication = $explication;

        return $this;
    }

    /**
     * Get explication
     *
     * @return \AppBundle\Entity\Explication
     */
    public function getExplication()
    {
        return $this->explication;
    }

        /**
     * Set validated
     *
     * @param boolean $validated
     * @return Question
     */
    public function setValidated($validated)
    {
        $this->validated = $validated;

        return $this;
    }

    /**
     * Get validated
     *
     * @return boolean 
     */
    public function getValidated()
    {
        return $this->validated;
    }
}
