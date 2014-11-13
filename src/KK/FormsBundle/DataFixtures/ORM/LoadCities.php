<?php
// src/KK/FormsBundle/DataFixtures/ORM/LoadCities.php

namespace KK\FormsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use KK\FormsBundle\Entity\City;
use KK\FormsBundle\Entity\Province;

/**
 * Class LoadCities
 */
class LoadCities extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $city1 = new City();
        $city1->SetName('City 1');
        $city1->setProvince($this->getReference('province-1'));

        $city2 = new City();
        $city2->SetName('City 2');
        $city2->setProvince($this->getReference('province-2'));

        $city3 = new City();
        $city3->SetName('City 3');
        $city3->setProvince($this->getReference('province-3'));

        $manager->persist($city1);
        $manager->persist($city2);
        $manager->persist($city3);
        $manager->flush();

        $this->addReference('city-1', $city1);
        $this->addReference('city-2', $city2);
        $this->addReference('city-3', $city3);
    }

    public function getOrder()
    {
        return 15;
    }
}