<?php

namespace Superrb\KunstmaanCompanyBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Superrb\KunstmaanCompanyBundle\Entity\Day;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DayRepository extends ServiceEntityRepository
{
    /**
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Day::class);
    }
}
