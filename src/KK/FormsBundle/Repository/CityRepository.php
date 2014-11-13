<?php

namespace KK\FormsBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CityRepository extends EntityRepository
{
    public function findByProvince($province)
    {
        return $this
            ->createQueryBuilder('city')
            ->join('city.province', 'province')
            ->andWhere('province.id = :province')
            ->setParameter('province', $province)
            ->getQuery()
            ->getResult();
    }
}
