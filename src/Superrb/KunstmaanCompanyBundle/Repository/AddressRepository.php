<?php

namespace Superrb\KunstmaanCompanyBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Superrb\KunstmaanCompanyBundle\Entity\Address;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AddressRepository extends ServiceEntityRepository
{
    /**
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Address::class);
    }
}
