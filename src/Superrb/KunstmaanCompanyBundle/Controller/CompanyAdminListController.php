<?php

namespace Superrb\KunstmaanCompanyBundle\Controller;

use Doctrine\ORM\EntityManager;
use Kunstmaan\AdminListBundle\Controller\AbstractAdminListController;
use Superrb\KunstmaanCompanyBundle\Entity\Company;
use Superrb\KunstmaanCompanyBundle\Form\Type\CompanyAdminType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompanyAdminListController extends AbstractAdminListController
{
    /**
     * @Route("/", name="superrb\kunstmaancompanybundle_admin_company")
     *
     * @param Request $request
     */
    public function indexAction(Request $request)
    {;
        $repo            = $this->getEntityManager()->getRepository(Company::class);
        $company         = $repo->findOneBy(['id' => 1]);

        if (!$company) {
            $company = new Company();
        }

        $form = $this->createForm(CompanyAdminType::class, $company, [
            'action' => $this->generateUrl('superrb\kunstmaancompanybundle_admin_company'),
            'method' => 'POST',
        ]);

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getEntityManager()->persist($company);
                $this->getEntityManager()->flush();
                $this->addFlash('success', $this->container->get('translator')->trans('kuma_company.forms.company.messages.add_success'));

                return $this->redirect($this->generateUrl('superrb\kunstmaancompanybundle_admin_company'));
            }
        }

        return $this->render('@SuperrbKunstmaanCompany/Company/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
