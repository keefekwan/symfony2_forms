<?php
// src/KK/FormsBundle/Entity/Speaker.php

namespace KK\FormsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Speaker
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KK\FormsBundle\Repository\SpeakerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Speaker
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Conference", inversedBy="speakers")
     * @ORM\JoinColumn(name="genre_id", referencedColumnName="id")
     */
    protected $conference;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=false)
     */
    private $updatedAt;


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
     * Set name
     *
     * @param string $name
     * @return Speaker
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set createdAt
     *
     * @ORM\PrePersist
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @ORM\PreUpdate
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set conference
     *
     * @param \KK\FormsBundle\Entity\Conference $conference
     * @return Speaker
     */
    public function setConference($conference)
    {
        if (!$conference instanceof Conference && $conference !== null) {
            throw new \InvalidArgumentException('$conference must be an instance of Conference, or null');
        }

        $this->conference = $conference;

        return $this;
    }

    /**
     * Get conference
     *
     * @return \KK\FormsBundle\Entity\Conference 
     */
    public function getConference()
    {
        return $this->conference;
    }
}
