<?php

namespace Superrb\KunstmaanCompanyBundle\Twig;

use App\Entity\Pages\CareersPage;
use App\Entity\Pages\WorkPage;
use Doctrine\DBAL\Result;
use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityManagerInterface;
use Superrb\KunstmaanCompanyBundle\Entity\Company;
use Superrb\KunstmaanCompanyBundle\SuperrbKunstmaanCompanyBundle;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class AppExtension.
 */
class KunstmaanCompanyExtension extends AbstractExtension
{
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
            /** @var Statement $stmt */
            $stmt = $this->entityManager->getConnection()->prepare('SHOW COLUMNS FROM `skcb_companies` LIKE \'default_address_id\'');

            /** @var Result $result */
            $result = $stmt->executeQuery();

            if (0 === count($result->fetchAllAssociative())) {
                return;
            }
        }

        $this->setCompany($this->getEntityManager()->getRepository(Company::class)->findOneBy(['id' => 1]));
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('generate_company_schema', $this->generateCompanySchema(...)),
            new TwigFunction('get_company', $this->getCompany(...)),
        ];
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
    public function getCompany(): Company
    {
        return $this->company;
    }

    /**
     * @param Company|null $company
     * @return self
     */
    public function setCompany(?Company $company): KunstmaanCompanyExtension
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
     * @return self
     */
    public function setEntityManager(EntityManagerInterface $entityManager): KunstmaanCompanyExtension
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
     * @return self
     */
    public function setTemplating(Environment $templating): KunstmaanCompanyExtension
    {
        $this->templating = $templating;

        return $this;
    }
}