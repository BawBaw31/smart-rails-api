<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiSecurityController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function login(): JsonResponse
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->json([
                'error' => 'Invalid login request: check that the Content-Type header is "application/json".'
            ], 400);
        }
        return $this->json([
            'user' => [
                'id' => $this->getUser() ? $this->getUser()->getId() : null,
                'email' => $this->getUser() ? $this->getUser()->getEmail() : null,
                'roles' => $this->getUser() ? $this->getUser()->getRoles() : null,
            ],
            'msg' => 'login success'
        ]);
    }

    /**
     * @Route("/api/me", name="api_me", methods={"GET"})
     * 
     */
    public function me(): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->json([
                'error' => 'User not connected.'
            ], 400);
        }

        return $this->json([
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
            ],
            'msg' => 'user connected'
        ]);
    }
}
