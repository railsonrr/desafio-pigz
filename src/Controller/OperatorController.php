<?php

namespace App\Controller;

use App\Repository\OperatorRepository;
use App\Entity\Operator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class OperatorController extends AbstractController
{
    /**
     * @Route("/operator", methods={"GET"})
     */
    public function read_all_operators(Request $request): Response
    {
        return $this->json(['route' => 'GET read_all_operators']);
    }
    /**
     * @Route("/operator/{id}", methods={"GET"})
     */
    public function read_operator(): JsonResponse
    {
        return $this->json(['route' => 'GET read_operator']);
    }
    /**
     * @Route("/operator", methods={"POST"})
     */
    public function create_operator(Request $request, OperatorRepository $repository): JsonResponse
    {
        foreach (json_decode($request->getContent()) as $operator) {
            $new_operator = new Operator();
            $new_operator->setNome($operator->nome);
            $repository->add($new_operator);
        }
        return $this->json("Saved new operator new operators");
    }
    /**
     * @Route("/operator/{id}", methods={"PUT"})
     */
    public function update_operator(int $id, Request $request): JsonResponse
    {
        // $params = json_decode($request->getContent(), true);
        // foreach ($params as $obj) {
        //     var_dump($obj);
        // }
        //$i = 0;
        // for ($i; $i < count($params); $i++)
        // {
        //     var_dump($params[$i]);
        // }
        // exit;
        return $this->json
        ([
            'route' => 'PUT update_operator with id: '.$id,
            'updated data' => json_decode($request->getContent(), true)
        ]);
    }
    /**
     * @Route("/operator/{id}", methods={"DELETE"})
     */
    public function delete_operator(): JsonResponse
    {
        return $this->json(['route' => 'DELETE delete_operator']);
    }
}
