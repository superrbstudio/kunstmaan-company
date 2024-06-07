<?php

namespace Superrb\KunstmaanCompanyBundle\Controller;

use Kunstmaan\AdminListBundle\AdminList\Configurator\AdminListConfiguratorInterface;
use Kunstmaan\AdminListBundle\Controller\AbstractAdminListController;
use Superrb\KunstmaanCompanyBundle\AdminList\AddressAdminListConfigurator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddressAdminListController extends AbstractAdminListController
{
    /**
     * @var AdminListConfiguratorInterface
     */
    private $configurator;

    /**
     * @return AdminListConfiguratorInterface
     */
    public function getAdminListConfigurator()
    {
        if (!isset($this->configurator)) {
            $this->configurator = new AddressAdminListConfigurator($this->getEntityManager());
        }

        return $this->configurator;
    }

    /**
     * The index action.
     *
     * @Route("/", name="superrb\kunstmaancompanybundle_admin_address")
     *
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        return parent::doIndexAction($this->getAdminListConfigurator(), $request);
    }

    /**
     * The add action.
     *
     * @Route("/add", name="superrb\kunstmaancompanybundle_admin_address_add", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return array
     */
    public function addAction(Request $request)
    {
        return parent::doAddAction($this->getAdminListConfigurator(), null, $request);
    }

    /**
     * The edit action.
     *
     * @param int     $id
     * @param Request $request
     *
     * @Route("/{id}", requirements={"id" = "\d+"}, name="superrb\kunstmaancompanybundle_admin_address_edit", methods={"GET", "POST"})
     *
     * @return array
     */
    public function editAction(Request $request, $id)
    {
        return parent::doEditAction($this->getAdminListConfigurator(), $id, $request);
    }

    /**
     * The view action.
     *
     * @param int     $id
     * @param Request $request
     *
     * @Route("/{id}/view", requirements={"id" = "\d+"}, name="superrb\kunstmaancompanybundle_admin_address_view", methods={"GET"})
     *
     * @return array
     */
    public function viewAction(Request $request, $id)
    {
        return parent::doViewAction($this->getAdminListConfigurator(), $id, $request);
    }

    /**
     * The delete action.
     *
     * @param int     $id
     * @param Request $request
     *
     * @Route("/{id}/delete", requirements={"id" = "\d+"}, name="superrb\kunstmaancompanybundle_admin_address_delete", methods={"GET", "POST"})
     *
     * @return array
     */
    public function deleteAction(Request $request, $id)
    {
        return parent::doDeleteAction($this->getAdminListConfigurator(), $id, $request);
    }

    /**
     * The export action.
     *
     * @param string  $_format
     * @param Request $request
     *
     * @Route("/export.{_format}", requirements={"_format" = "csv|ods|xlsx"}, name="superrb\kunstmaancompanybundle_admin_address_export", methods={"GET", "POST"})
     *
     * @return array
     */
    public function exportAction(Request $request, $_format)
    {
        return parent::doExportAction($this->getAdminListConfigurator(), $_format, $request);
    }

    /**
     * The move up action.
     *
     * @param int     $id
     * @param Request $request
     *
     * @Route("/{id}/move-up", requirements={"id" = "\d+"}, name="superrb\kunstmaancompanybundle_admin_address_move_up", methods={"GET"})
     *
     * @return array
     */
    public function moveUpAction(Request $request, $id)
    {
        return parent::doMoveUpAction($this->getAdminListConfigurator(), $id, $request);
    }

    /**
     * The move down action.
     *
     * @param int     $id
     * @param Request $request
     *
     * @Route("/{id}/move-down", requirements={"id" = "\d+"}, name="superrb\kunstmaancompanybundle_admin_address_move_down", methods={"GET"})
     *
     * @return array
     */
    public function moveDownAction(Request $request, $id)
    {
        return parent::doMoveDownAction($this->getAdminListConfigurator(), $id, $request);
    }
}
