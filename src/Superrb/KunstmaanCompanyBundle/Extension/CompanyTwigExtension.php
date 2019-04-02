<?php

namespace Superrb\KunstmaanCompanyBundle\Extension;

use Doctrine\ORM\EntityManager;

class CompanyTwigExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->company         = $em->getRepository('SuperrbKunstmaanCompanyBundle:Company')->findOneBy(['id' => 1]);
    }

    public function getGlobals()
    {
        return [
          'company'       => $this->company,
      ];
    }

    public function getName()
    {
        return 'SuperrbKunstmaanCompanyBundle:TwigExtension';
    }
}
