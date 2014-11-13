<?php
// src/KK/FormsBundle/Entity/City.php

namespace KK\FormsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * City
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KK\FormsBundle\Repository\CityRepository")
 */
class City
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
     * @ORM\ManyToOne(targetEntity="Province", inversedBy="cities")
     * @ORM\JoinColumn(name="provinces_id", referencedColumnName="id")
     */
    protected $province;

//    /**
//     * @ORM\OneToMany(targetEntity="Account", mappedBy="city")
//     */
//    protected $accounts;
//
//
//    /**
//     * Constructor
//     */
//    public function __construct()
//    {
//        $this->accounts = new ArrayCollection();
//    }

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
     * @return City
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
     * Set province
     *
     * @param \KK\FormsBundle\Entity\Province $province
     * @return City
     */
    public function setProvince(Province $province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \KK\FormsBundle\Entity\Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    function __toString() {
        return $this->getName();
    }
}
