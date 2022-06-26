<?php

namespace App\Controller;
use App\Repository\VisitTypeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/visit/type")
 * @IsGranted("ROLE_USER")
 */
class ApiVisitTypeController extends AbstractController
{
    /**
     * @Route("/", name="api_visit_type_get_all", methods={"GET"})
     */
    public function getAll(
        VisitTypeRepository $visitTypeRepository,
        SerializerInterface $serializer
    ): Response {
        $visiTypes = $visitTypeRepository->findAll();

        $json = $serializer->serialize($visiTypes, 'json', [
            'groups' => ['visit_types']
        ]);
        return new Response($json);
    }

    /**
     * @Route("/{id}", name="api_visit_type_get_one", methods={"GET"})
     */
    public function getOne(
        VisitTypeRepository $visitTypeRepository,
        SerializerInterface $serializer,
        int $id
    ): Response {
        $visitType = $visitTypeRepository->find($id);

        $json = $serializer->serialize($visitType, 'json', [
            'groups' => ['visit_types']
        ]);
        return new Response($json);
    }
}
