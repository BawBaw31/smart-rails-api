<?php

namespace App\Controller;

use App\Entity\VisitReport;
use App\Entity\VisitValue;
use App\Repository\MeasureRepository;
use App\Repository\VisitReportRepository;
use App\Repository\VisitTypeRepository;
use App\Repository\VisitValueRepository;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Twig\Environment;
use Dompdf\Dompdf;

/**
 * @Route("/api/visit/report")
 * @IsGranted("ROLE_USER")
 */
class ApiVisitReportController extends AbstractController
{

    /**
     * @Route("/new", name="api_visit_report_new", methods={"POST"})
     */
    public function new(
        VisitTypeRepository $visitTypeRepository,
        VisitReportRepository $visitReportRepository,
        VisitValueRepository $visitValueRepository,
        MeasureRepository $measureRepository,
        SerializerInterface $serializer,
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $body = json_decode($request->getContent());
        $visitReport = new VisitReport();
        $visitReport->setCreatedAt(new DateTimeImmutable('now'));
        $visitReport->setWriter($this->getUser());
        $visitReport->setVisitType($visitTypeRepository->find($body->visit_type));
        $visitReportRepository->add($visitReport);

        foreach ($body->values as $value) {
            $visitValue = new VisitValue();
            $visitValue->setValue($value->value);
            $visitValue->setMeasure($measureRepository->find($value->measure));
            $visitValue->setVisitReport($visitReport);
            $visitValueRepository->add($visitValue);
            $visitReport->addValue($visitValue);
        }

        $entityManager = $doctrine->getManager();
        $entityManager->flush();

        $json = $serializer->serialize($visitReport, 'json', [
            'groups' => ['visit_reports']
        ]);

        return new Response($json);
    }

    /**
     * @Route("/{id}/download", name="api_visit_report_download_pdf", methods={"GET"})
     */
    public function downloadPdf(
        Environment $twig,
        VisitReport $visitReport
    ): Response {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $pdfName = "visit_report_" . $visitReport->getId();
        $html = $twig->render('pdf/visit_report_pdf.html.twig', [
            'report' => $visitReport,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream(
            "$pdfName.pdf",
            [
                'Attachment' => false,
            ]
        );

        return new Response(
            '',
            200,
            [
                'Content-Type' => 'application/pdf',
            ]
        );
    }
}
