<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Boards
 *
 * @ORM\Table(name="boards")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BoardsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Boards {

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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="parent", type="integer", nullable=true)
     */
    private $parent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\PrePersist
     */
    public function onPrePersistSetRegistrationDate() {
	$this->creationDate = new \DateTime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
	return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Boards
     */
    public function setTitle($title) {
	$this->title = $title;

	return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle() {
	return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Boards
     */
    public function setDescription($description) {
	$this->description = $description;

	return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
	return $this->description;
    }

    /**
     * Set parent
     *
     * @param integer $parent
     *
     * @return Boards
     */
    public function setParent($parent) {
	$this->parent = $parent;

	return $this;
    }

    /**
     * Get parent
     *
     * @return int
     */
    public function getParent() {
	return $this->parent;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Boards
     */
    public function setCreationDate($creationDate) {
	$this->creationDate = $creationDate;

	return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate() {
	return $this->creationDate;
    }

}
