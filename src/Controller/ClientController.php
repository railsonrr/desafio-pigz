<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", methods={"GET"})
     */
    public function read_all_clients(): Response
    {
        return $this->json(['route' => 'GET read_all_clients']);
    }
    /**
     * @Route("/client/{id}", methods={"GET"})
     */
    public function read_client(): JsonResponse
    {
        return $this->json(['route' => 'GET read_client']);
    }
    /**
     * @Route("/client", methods={"POST"})
     */
    public function create_client(): JsonResponse
    {
        return $this->json(['route' => 'POST create_client']);
    }
    /**
     * @Route("/client/{id}", methods={"PUT"})
     */
    public function update_client(int $id): JsonResponse
    {
        return $this->json(['route' => 'PUT update_client with id: '.$id]);
    }
    /**
     * @Route("/client/{id}", methods={"DELETE"})
     */
    public function delete_client(): JsonResponse
    {
        return $this->json(['route' => 'DELETE delete_cliente']);
    }
}
