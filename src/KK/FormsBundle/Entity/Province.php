<?php
// src/KK/FormsBundle/Entity/Province.php

namespace KK\FormsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Province
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KK\FormsBundle\Repository\ProvinceRepository")
 */
class Province
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
     * @ORM\OneToMany(targetEntity="City", mappedBy="province")
     */
    protected $cities;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cities = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Province
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
     * Add cities
     *
     * @param \KK\FormsBundle\Entity\City $cities
     * @return Province
     */
    public function addCity(City $cities)
    {
        $this->cities[] = $cities;

        return $this;
    }

    /**
     * Remove cities
     *
     * @param \KK\FormsBundle\Entity\City $cities
     */
    public function removeCity(City $cities)
    {
        $this->cities->removeElement($cities);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCities()
    {
        return $this->cities;
    }

    function __toString() {
        return $this->getName();
    }
}