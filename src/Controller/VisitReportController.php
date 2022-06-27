<?php

namespace App\Controller;

use App\Entity\VisitReport;
use App\Form\VisitReportType;
use App\Repository\VisitReportRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/visit/report")
 * @IsGranted("ROLE_USER")
 */
class VisitReportController extends AbstractController
{
    /**
     * @Route("/", name="app_visit_report_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(VisitReportRepository $visitReportRepository): Response
    {
        return $this->render('visit_report/index.html.twig', [
            'visit_reports' => $visitReportRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_visit_report_new", methods={"GET", "POST"})
     */
    // public function new(Request $request, VisitReportRepository $visitReportRepository): Response
    // {
    //     $visitReport = new VisitReport();
    //     $form = $this->createForm(VisitReportType::class, $visitReport);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $visitReportRepository->add($visitReport, true);

    //         return $this->redirectToRoute('app_visit_report_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('visit_report/new.html.twig', [
    //         'visit_report' => $visitReport,
    //         'form' => $form,
    //     ]);
    // }

    /**
     * @Route("/{id}", name="app_visit_report_show", methods={"GET"})
     */
    public function show(VisitReport $visitReport): Response
    {
        if (
            in_array("ROLE_ADMIN", $this->getUser()->getRoles()) ||
            $visitReport->getWriter() == $this->getUser()
        ) {
            return $this->render('visit_report/show.html.twig', [
                'visit_report' => $visitReport,
            ]);
        } else {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour voir ce rapport de visite');
            return $this->redirectToRoute('app_visit_report_index');
        }
    }

    /**
     * @Route("/{id}/edit", name="app_visit_report_edit", methods={"GET", "POST"})
     */
    // public function edit(Request $request, VisitReport $visitReport, VisitReportRepository $visitReportRepository): Response
    // {
    //     $form = $this->createForm(VisitReportType::class, $visitReport);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $visitReportRepository->add($visitReport, true);

    //         return $this->redirectToRoute('app_visit_report_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('visit_report/edit.html.twig', [
    //         'visit_report' => $visitReport,
    //         'form' => $form,
    //     ]);
    // }

    /**
     * @Route("/{id}", name="app_visit_report_delete", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, VisitReport $visitReport, VisitReportRepository $visitReportRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $visitReport->getId(), $request->request->get('_token'))) {
            $visitReportRepository->remove($visitReport, true);
        }

        return $this->redirectToRoute('app_visit_report_index', [], Response::HTTP_SEE_OTHER);
    }
}
