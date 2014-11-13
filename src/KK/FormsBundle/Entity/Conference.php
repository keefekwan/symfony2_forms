<?php
// src/KK/FormsBundle/Entity/Conference.php

namespace KK\FormsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Conference
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KK\FormsBundle\Repository\ConferenceRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Conference
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
     * @ORM\OneToMany(targetEntity="Speaker", mappedBy="conference", cascade={"persist"})
     */
    protected $speakers;


    public function __construct()
    {
        $this->speakers = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Conference
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
     * Add speakers
     *
     * @param \KK\FormsBundle\Entity\Speaker $speaker
     * @return Conference
     */
    public function addSpeaker(Speaker $speaker)
    {
        if (!$this->speakers->contains($speaker)) {
            $speaker->setConference($this);
            $this->speakers->add($speaker);
        }

        return $this->speakers;
    }

    /**
     * Remove speakers
     *
     * @param \KK\FormsBundle\Entity\Speaker $speaker
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function removeSpeaker(Speaker $speaker)
    {
        if ($this->speakers->contains($speaker)) {
            $this->speakers->removeElement($speaker);
        }

        return $this->speakers;
    }

    /**
     * Get speakers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSpeakers()
    {
        return $this->speakers;
    }

    /**
     * @param Collection $speakers
     * @return $this
     */
    public function setSpeakers(Collection $speakers)
    {
        $this->speakers = $speakers;

        return $this;
    }
}
