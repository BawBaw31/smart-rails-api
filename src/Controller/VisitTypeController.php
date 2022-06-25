<?php

namespace App\Controller;

use App\Entity\VisitType;
use App\Form\VisitTypeType;
use App\Repository\VisitTypeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/visit/type")
 * @IsGranted("ROLE_ADMIN")
 */
class VisitTypeController extends AbstractController
{
    /**
     * @Route("/", name="app_visit_type_index", methods={"GET"})
     */
    public function index(VisitTypeRepository $visitTypeRepository): Response
    {
        return $this->render('visit_type/index.html.twig', [
            'visit_types' => $visitTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_visit_type_new", methods={"GET", "POST"})
     */
    public function new(Request $request, VisitTypeRepository $visitTypeRepository): Response
    {
        $visitType = new VisitType();
        $form = $this->createForm(VisitTypeType::class, $visitType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visitTypeRepository->add($visitType, true);

            return $this->redirectToRoute('app_visit_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('visit_type/new.html.twig', [
            'visit_type' => $visitType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_visit_type_show", methods={"GET"})
     */
    public function show(VisitType $visitType): Response
    {
        return $this->render('visit_type/show.html.twig', [
            'visit_type' => $visitType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_visit_type_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, VisitType $visitType, VisitTypeRepository $visitTypeRepository): Response
    {
        $form = $this->createForm(VisitTypeType::class, $visitType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $visitTypeRepository->add($visitType, true);

            return $this->redirectToRoute('app_visit_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('visit_type/edit.html.twig', [
            'visit_type' => $visitType,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_visit_type_delete", methods={"POST"})
     */
    public function delete(Request $request, VisitType $visitType, VisitTypeRepository $visitTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$visitType->getId(), $request->request->get('_token'))) {
            $visitTypeRepository->remove($visitType, true);
        }

        return $this->redirectToRoute('app_visit_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
