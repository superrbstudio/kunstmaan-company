<?php

namespace Superrb\KunstmaanCompanyBundle\Helper\Menu;

use Kunstmaan\AdminBundle\Helper\Menu\MenuAdaptorInterface;
use Kunstmaan\AdminBundle\Helper\Menu\MenuBuilder;
use Kunstmaan\AdminBundle\Helper\Menu\MenuItem;
use Symfony\Component\HttpFoundation\Request;

class CompanyMenuAdaptor implements MenuAdaptorInterface
{
    /**
     * @param MenuBuilder $menu
     * @param array       $children
     * @param MenuItem    $parent
     * @param Request     $request
     */
    public function adaptChildren(MenuBuilder $menu, array &$children, MenuItem $parent = null, Request $request = null)
    {
        if (!is_null($parent) && 'KunstmaanAdminBundle_settings' === $parent->getRoute()) {
            $menuItem = new MenuItem($menu);
            $menuItem
                ->setRoute('superrb\kunstmaancompanybundle_admin_company')
                ->setLabel('Company')
                ->setUniqueId('Company')
                ->setParent($parent);
            if (0 === stripos($request->attributes->get('_route'), $menuItem->getRoute())) {
                $menuItem->setActive(true);
                $parent->setActive(true);
            }
            $children[] = $menuItem;
        }

        if (!is_null($parent) && 'KunstmaanAdminBundle_settings' === $parent->getRoute()) {
            $menuItem = new MenuItem($menu);
            $menuItem
                ->setRoute('superrb\kunstmaancompanybundle_admin_address')
                ->setLabel('Company Addresses')
                ->setUniqueId('Company Addresses')
                ->setParent($parent);
            if (0 === stripos($request->attributes->get('_route'), $menuItem->getRoute())) {
                $menuItem->setActive(true);
                $parent->setActive(true);
            }
            $children[] = $menuItem;
        }
    }
}
