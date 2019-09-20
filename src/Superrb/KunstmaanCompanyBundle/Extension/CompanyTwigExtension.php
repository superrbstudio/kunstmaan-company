<?php

namespace Superrb\KunstmaanCompanyBundle\Extension;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Superrb\KunstmaanCompanyBundle\Entity\Company;
use Symfony\Component\Templating\EngineInterface;
use Twig\TwigFunction;

/**
 * Class CompanyTwigExtension.
 */
class CompanyTwigExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var Company|null
     */
    protected $company;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var EngineInterface
     */
    protected $templating;

    /**
     * CompanyTwigExtension constructor.
     *
     * @param EntityManagerInterface $em
     * @param EngineInterface        $twigEngine
     */
    public function __construct(EntityManagerInterface $em, EngineInterface $twigEngine)
    {
        $this->setEntityManager($em);
        $this->setTemplating($twigEngine);
        $this->setCompany($this->getEntityManager()->getRepository('SuperrbKunstmaanCompanyBundle:Company')->findOneBy(['id' => 1]));
    }

    /**
     * @return array
     */
    public function getGlobals()
    {
        return [
            'company'       => $this->company,
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('generate_company_schema', [$this, 'generateCompanySchema']),
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'SuperrbKunstmaanCompanyBundle:TwigExtension';
    }

    public function generateCompanySchema()
    {
        return $this->getTemplating()->render('@SuperrbKunstmaanCompany/Twig/companySchema.html.twig', [
            'company' => $this->getCompany(),
        ]);
    }

    /**
     * @return Company|null
     */
    public function getCompany(): ?Company
    {
        return $this->company;
    }

    /**
     * @param Company|null $company
     *
     * @return CompanyTwigExtension
     */
    public function setCompany(?Company $company): CompanyTwigExtension
    {
        if(!($company instanceof Company)) {
            $this->company = new Company();
        } else {
            $this->company = $company;
        }

        return $this;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManagerInterface $entityManager
     *
     * @return CompanyTwigExtension
     */
    public function setEntityManager(EntityManagerInterface $entityManager): CompanyTwigExtension
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * @return EngineInterface
     */
    public function getTemplating(): EngineInterface
    {
        return $this->templating;
    }

    /**
     * @param EngineInterface $templating
     *
     * @return CompanyTwigExtension
     */
    public function setTemplating(EngineInterface $templating): CompanyTwigExtension
    {
        $this->templating = $templating;

        return $this;
    }
}
