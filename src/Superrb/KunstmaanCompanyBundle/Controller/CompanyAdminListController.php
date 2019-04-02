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
     * @Route("/", name="company_index")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em              = $this->getDoctrine()->getManager();
        $repo            = $em->getRepository('SuperrbKunstmaanCompanyBundle:Company');
        $company         = $repo->findOneBy(['id' => 1]);

        if (!$company) {
            $company = new Company();
        }

        $form = $this->createForm(CompanyAdminType::class, $company, [
            'action' => $this->generateUrl('company_index'),
            'method' => 'POST',
        ]);

        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->getDoctrine()->getManager()->persist($company);
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', $this->get('translator')->trans('kuma_social.forms.social.messages.add_success'));

                return $this->redirect($this->generateUrl('company_index'));
            }
        }

        return $this->render('SuperrbKunstmaanCompanyBundle:Company:index.html.twig', [
            'form'         => $form->createView(),
        ]);
    }
}
