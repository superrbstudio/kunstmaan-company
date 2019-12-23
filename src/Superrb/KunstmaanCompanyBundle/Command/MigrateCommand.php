<?php

namespace Superrb\KunstmaanCompanyBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use ErrorException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct('superrb:kunstmaan-company:migrate-addresses');
    }

    /**
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;

        if ($this->input->getOption('rollback')) {
            $this->rollback();

            return;
        }

        $this->migrate();
    }

    public function configure()
    {
        $this->setName('superrb:kunstmaan-company:migrate-addresses')
            ->setDescription('Migrate to multiple addresses')
            ->setHelp('Migrates address data from company table to new addresses table')
            ->addOption('rollback', 'r', InputOption::VALUE_NONE, 'Rollback data');
    }

    public function migrate()
    {
        // this up() migration is auto-generated, please modify it to your needs
        if ('mysql' !== $this->em->getConnection()->getDatabasePlatform()->getName()) {
            throw new ErrorException('Migration can only be executed safely on \'mysql\'.');
        }

        $rollbackPoint = 0;

        $this->output->writeLn('Starting migration');

        try {
            $sql  = 'CREATE TABLE skcb_addresses (id BIGINT AUTO_INCREMENT NOT NULL, company_id BIGINT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, street_address VARCHAR(255) DEFAULT NULL, locality VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, phone VARCHAR(35) DEFAULT NULL COMMENT \'(DC2Type:phone_number)\', email VARCHAR(255) DEFAULT NULL, lat VARCHAR(255) DEFAULT NULL, lng VARCHAR(255) DEFAULT NULL, displayOrder INT NOT NULL, INDEX IDX_3827A7D8979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $sql  = 'ALTER TABLE skcb_addresses ADD CONSTRAINT FK_3827A7D8979B1AD6 FOREIGN KEY (company_id) REFERENCES skcb_companies (id)';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            ++$rollbackPoint;
            $this->output->writeLn('<fg=green>Created skcb_addresses table</>');

            $sql  = 'ALTER TABLE skcb_companies ADD default_address_id BIGINT DEFAULT NULL';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $sql  = 'ALTER TABLE skcb_companies ADD CONSTRAINT FK_D5A978F4BD94FB16 FOREIGN KEY (default_address_id) REFERENCES skcb_addresses (id)';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $sql  = 'CREATE INDEX IDX_D5A978F4BD94FB16 ON skcb_companies (default_address_id)';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $this->output->writeLn('<fg=green>Created default_address_id column on skcb_companies</>');
            ++$rollbackPoint;

            $sql  = 'INSERT INTO skcb_addresses (id, company_id, name, street_address, locality, region, postcode, country, url, phone, email, lat, lng, displayOrder) SELECT "1", id, "Main", street_address, address_locality, address_region, postcode, address_country, address_url, phone, email, lat, lng, "1" FROM skcb_companies';
            $sql  = 'UPDATE skcb_companies SET default_address_id = (SELECT id FROM skcb_addresses LIMIT 1)';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $this->output->writeLn('<fg=green>Migrated address data</>');
            ++$rollbackPoint;

            $sql  = 'ALTER TABLE skcb_companies DROP street_address, DROP address_locality, DROP address_region, DROP postcode, DROP address_country, DROP lat, DROP lng, DROP address_url';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $this->output->writeLn('<fg=green>Dropped old address columns on skcb_companies</>');
            ++$rollbackPoint;
        } catch (\Throwable $e) {
            $this->output->writeLn('<fg=red>Error occurred</>');
            $this->output->writeLn('<fg=red>'.$e->getMessage().'</>');
            $this->rollback($rollbackPoint);
        }
    }

    public function rollback(int $startPoint = 0)
    {
        // this down() migration is auto-generated, please modify it to your needs
        if ('mysql' !== $this->em->getConnection()->getDatabasePlatform()->getName()) {
            throw new ErrorException('Migration can only be executed safely on \'mysql\'.');
        }

        $this->output->writeLn('Starting rollback');

        if ($startPoint > 4) {
            $sql  = 'ALTER TABLE skcb_companies ADD street_address VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD address_locality VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD address_region VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD postcode VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD address_country VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD lat VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD lng VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD address_url VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $this->output->writeLn('<fg=green>Re-created address columns on skcb_companies</>');
        }

        if ($startPoint > 3) {
            $sql = 'UPDATE skcb_companies c
                            JOIN skcb_addresses a
                            ON a.id = c.default_address_id
                            SET c.street_address = a.street_address,
                                c.address_locality = a.locality,
                                c.address_region = a.region,
                                c.postcode = a.postcode,
                                c.address_country = a.country,
                                c.lat = a.lat,
                                c.lng = a.lng,
                                c.address_url = a.url';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $this->output->writeLn('<fg=green>Migrate data from addresses table to company</>');
        }

        if ($startPoint > 2) {
            $sql  = 'ALTER TABLE skcb_companies DROP FOREIGN KEY FK_D5A978F4BD94FB16';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();

            $sql  = 'DROP INDEX IDX_D5A978F4BD94FB16 ON skcb_companies';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();

            $sql  = 'ALTER TABLE skcb_companies DROP default_address_id';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $this->output->writeLn('<fg=green>Drop default_address_id column on skcb_companies</>');
        }

        if ($startPoint > 1) {
            $sql  = 'DROP TABLE skcb_addresses';
            $stmt = $this->em->getConnection()->prepare($sql);
            $stmt->execute();
            $this->output->writeLn('<fg=green>Drop skcb_addresses</>');
        }
    }
}
