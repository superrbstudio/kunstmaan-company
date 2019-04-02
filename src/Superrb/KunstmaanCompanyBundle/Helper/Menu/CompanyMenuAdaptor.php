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
                ->setRoute('company_index')
                ->setLabel('Company')
                ->setUniqueId('Company')
                ->setFolder(true)
                ->setParent($parent);
            if (0 === stripos($request->attributes->get('_route'), $menuItem->getRoute())) {
                $menuItem->setActive(true);
            }
            $children[] = $menuItem;
        }

        // if (is_null($parent)) {
        //     $menuItem = new TopMenuItem($menu);
        //     $menuItem
        //         ->setRoute('superrbkunstmaansocialmediabundle_admin_social_false')
        //         ->setLabel('Social Media')
        //         ->setUniqueId('Social Media')
        //         ->setFolder(true)
        //         ->setParent($parent);
        //     if (stripos($request->attributes->get('_route'), $menuItem->getRoute()) === 0) {
        //         $menuItem->setActive(true);
        //     }
        //     $children[] = $menuItem;
        // }

        // if (!is_null($parent) && 'superrbkunstmaansocialmediabundle_admin_social_false' == $parent->getRoute()) {
        //     // Social Media Posts
        //     $menuItem = new TopMenuItem($menu);
        //     $menuItem
        //         ->setRoute('superrbkunstmaansocialmediabundle_admin_social')
        //         ->setLabel('Social Media Posts')
        //         ->setUniqueId('Social Media Posts')
        //         ->setParent($parent);
        //     if ($request->attributes->get('_route') == 'superrbkunstmaansocialmediabundle_admin_social') {
        //         $menuItem->setActive(true);
        //         $parent->setActive(true);
        //     }
        //     $children[] = $menuItem;

        // }
    }
}
