<?php

namespace Superrb\KunstmaanCompanyBundle\Extension;

use Doctrine\ORM\EntityManagerInterface;
use Superrb\KunstmaanCompanyBundle\Entity\Company;
use Superrb\KunstmaanCompanyBundle\SuperrbKunstmaanCompanyBundle;
use Twig\Environment;
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
     * @var Environment
     */
    protected $templating;

    /**
     * CompanyTwigExtension constructor.
     * @param EntityManagerInterface $em
     * @param Environment $twigEngine
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __construct(EntityManagerInterface $em, Environment $twigEngine)
    {
        $this->setEntityManager($em);
        $this->setTemplating($twigEngine);

        // Don't attempt to load company unless migration has been run, otherwise Doctrine errors prevent
        // the migration command from initialising
        if (SuperrbKunstmaanCompanyBundle::VERSION >= 2) {
            $stmt = $this->entityManager->getConnection()->prepare('SHOW COLUMNS FROM `skcb_companies` LIKE \'default_address_id\'');
            $stmt->execute();

            if (0 === count($stmt->fetchAll())) {
                return;
            }
        }

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

    /**
     * @return array|TwigFunction[]
     */
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

    /**
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
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
     * @return CompanyTwigExtension
     */
    public function setCompany(?Company $company): CompanyTwigExtension
    {
        if (!($company instanceof Company)) {
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
     * @return CompanyTwigExtension
     */
    public function setEntityManager(EntityManagerInterface $entityManager): CompanyTwigExtension
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    /**
     * @return Environment
     */
    public function getTemplating(): Environment
    {
        return $this->templating;
    }

    /**
     * @param Environment $templating
     * @return CompanyTwigExtension
     */
    public function setTemplating(Environment $templating): CompanyTwigExtension
    {
        $this->templating = $templating;

        return $this;
    }
}
