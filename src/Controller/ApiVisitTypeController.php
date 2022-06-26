<?php

namespace App\Controller;

use App\Repository\VisitTypeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/visit/type")
 * @IsGranted("ROLE_USER")
 */
class ApiVisitTypeController extends AbstractController
{
    /**
     * @Route("/", name="visit_type_get_all", methods={"GET"})
     */
    public function getAll(VisitTypeRepository $visitTypeRepository): JsonResponse
    {
        $visiTypes = $visitTypeRepository->findAll();
        return $this->json([
            'visitTypes' => $visiTypes
        ]);
    }
}
