<?php

namespace Superrb\KunstmaanCompanyBundle\Helper\Menu;

use Kunstmaan\AdminBundle\Helper\Menu\MenuAdaptorInterface;
use Kunstmaan\AdminBundle\Helper\Menu\MenuBuilder;
use Kunstmaan\AdminBundle\Helper\Menu\MenuItem;
use Kunstmaan\AdminBundle\Helper\Menu\TopMenuItem;
use Symfony\Component\HttpFoundation\Request;

class CompanyMenuAdaptor implements MenuAdaptorInterface
{
    public function adaptChildren(MenuBuilder $menu, array &$children, MenuItem $parent = null, Request $request = null)
    {
        if (is_null($parent)) {
            $menuItem = new TopMenuItem($menu);
            $menuItem
                ->setRoute('superrbkunstmaancompanybundle_admin_company')
                ->setLabel('Company')
                ->setUniqueId('Company')
                ->setFolder(true)
                ->setParent($parent);
            if (0 === stripos($request->attributes->get('_route'), $menuItem->getRoute())) {
                $menuItem->setActive(true);
            }
            $children[] = $menuItem;
        }
    }
}
