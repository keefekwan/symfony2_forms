<?php
// src/KK/FormsBundle/DataFixtures/ORM/LoadAccounts.php

namespace KK\FormsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use KK\FormsBundle\Entity\Account;
use KK\FormsBundle\Entity\City;

/**
 * Class LoadAccounts
 */
class LoadAccounts extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $account1 = new Account();
        $account1->SetName('Account1');
        $account1->setCity($this->getReference('city-1'));

        $account2 = new Account();
        $account2->SetName('Account2');
        $account2->setCity($this->getReference('city-2'));

        $account3 = new Account();
        $account3->SetName('Account3');
        $account3->setCity($this->getReference('city-3'));

        $manager->persist($account1);
        $manager->persist($account2);
        $manager->persist($account3);
        $manager->flush();

        $this->addReference('account-1', $account1);
        $this->addReference('account-2', $account2);
        $this->addReference('account-3', $account3);
    }

    public function getOrder()
    {
        return 20;
    }
}