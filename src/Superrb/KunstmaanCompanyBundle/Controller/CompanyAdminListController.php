<?php

namespace Superrb\KunstmaanCompanyBundle\Controller;

use Superrb\KunstmaanCompanyBundle\Entity\Company;
use Superrb\KunstmaanCompanyBundle\Form\Type\CompanyAdminType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CompanyAdminListController extends Controller
{
    /**
     * @Route("/", name="superrbkunstmaancompanybundle_admin_company")
     *
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        $em              = $this->getDoctrine()->getManager();
        $repo            = $em->getRepository('SuperrbKunstmaanCompanyBundle:Company');

        $company         = $repo->findOneBy(['locale' => $request->getLocale()]);

        if (!$company) {
            $company = new Company();
            $company->setLocale($request->getLocale());
        }

        $form = $this->createForm(CompanyAdminType::class, $company, [
            'action' => $this->generateUrl('superrbkunstmaancompanybundle_admin_company'),
            'method' => 'POST',
        ]);

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($company);
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', $this->get('translator')->trans('kuma_company.forms.company.messages.add_success'));

                return $this->redirect($this->generateUrl('superrbkunstmaancompanybundle_admin_company'));
            }
        }

        return $this->render('SuperrbKunstmaanCompanyBundle:Company:index.html.twig', [
            'form'         => $form->createView(),
        ]);
    }
}
