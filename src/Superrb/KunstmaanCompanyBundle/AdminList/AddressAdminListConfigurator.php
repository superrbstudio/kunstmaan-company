<?php

namespace Superrb\KunstmaanCompanyBundle\AdminList;

use Doctrine\ORM\EntityManager;
use Kunstmaan\AdminBundle\Helper\Security\Acl\AclHelper;
use Kunstmaan\AdminListBundle\AdminList\Configurator\AbstractDoctrineORMAdminListConfigurator;
use Kunstmaan\AdminListBundle\AdminList\FilterType\ORM;
use Kunstmaan\AdminListBundle\AdminList\SortableInterface;
use Superrb\KunstmaanCompanyBundle\Entity\Address;
use Superrb\KunstmaanCompanyBundle\Form\Type\AddressAdminType;

/**
 * The admin list configurator for Address.
 */
class AddressAdminListConfigurator extends AbstractDoctrineORMAdminListConfigurator implements SortableInterface
{
    /**
     * @param EntityManager $em        The entity manager
     * @param AclHelper     $aclHelper The acl helper
     */
    public function __construct(EntityManager $em, AclHelper $aclHelper = null)
    {
        parent::__construct($em, $aclHelper);
        $this->setAdminType(AddressAdminType::class);
    }

    /**
     * Configure the visible columns.
     */
    public function buildFields()
    {
        $this->addField('name', 'Name', true);
        $this->addField('streetAddress', 'Street address', true);
        $this->addField('locality', 'Locality', true);
        $this->addField('region', 'Region', true);
        $this->addField('postcode', 'Postcode', true);
        $this->addField('country', 'Country', true);
        $this->addField('url', 'Url', true);
        $this->addField('email', 'Email', true);
        $this->addField('phone', 'Phone', true);
        $this->addField('lat', 'Lat', true);
        $this->addField('lng', 'Lng', true);
        $this->addField('displayOrder', 'Display order', true);
    }

    /**
     * Build filters for admin list.
     */
    public function buildFilters()
    {
        $this->addFilter('name', new ORM\StringFilterType('name'), 'Name');
        $this->addFilter('streetAddress', new ORM\StringFilterType('streetAddress'), 'Street address');
        $this->addFilter('locality', new ORM\StringFilterType('locality'), 'Locality');
        $this->addFilter('region', new ORM\StringFilterType('region'), 'Region');
        $this->addFilter('postcode', new ORM\StringFilterType('postcode'), 'Postcode');
        $this->addFilter('country', new ORM\StringFilterType('country'), 'Country');
        $this->addFilter('url', new ORM\StringFilterType('url'), 'Url');
        $this->addFilter('email', new ORM\StringFilterType('email'), 'Email');
        $this->addFilter('phone', new ORM\StringFilterType('phone'), 'Phone');
        $this->addFilter('lat', new ORM\StringFilterType('lat'), 'Lat');
        $this->addFilter('lng', new ORM\StringFilterType('lng'), 'Lng');
        $this->addFilter('displayOrder', new ORM\NumberFilterType('displayOrder'), 'Display order');
    }

    /**
     * Get bundle name.
     *
     * @return string
     */
    public function getBundleName()
    {
        return 'SuperrbKunstmaanCompanyBundle';
    }

    public function getEntityClass(): string
    {
        return Address::class;
    }

    /**
     * Get sortable field name.
     *
     * @return string
     */
    public function getSortableField()
    {
        return 'displayOrder';
    }
}
