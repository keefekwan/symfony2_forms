<?php
// src/KK/FormsBundle/DataFixtures/ORM/LoadProvinces.php

namespace KK\FormsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use KK\FormsBundle\Entity\City;
use KK\FormsBundle\Entity\Province;

/**
 * Class LoadProvinces
 */
class LoadProvinces extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $province1 = new Province();
        $province1->SetName('Province1');

        $province2 = new Province();
        $province2->SetName('Province2');

        $province3 = new Province();
        $province3->SetName('Province3');

        $manager->persist($province1);
        $manager->persist($province2);
        $manager->persist($province3);
        $manager->flush();

        $this->addReference('province-1', $province1);
        $this->addReference('province-2', $province2);
        $this->addReference('province-3', $province3);
    }

    public function getOrder()
    {
        return 10;
    }
}