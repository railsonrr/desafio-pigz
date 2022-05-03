<?php

namespace App\Controller;

use App\Repository\OperatorRepository;
use App\Entity\Operator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OperatorController extends AbstractController
{

    /**
     * @Route("/operator", methods={"GET"})
     */
    public function read_all_operators(OperatorRepository $operator_repository, NormalizerInterface $serializer): Response
    {
        $operators_list = $operator_repository->findAll();
        $operators_list_serialized = $serializer->normalize($operators_list, null, ['groups' => 'group1']);
        return $this->json($operators_list_serialized);
    }

    /**
     * @Route("/operator/{id}", methods={"GET"})
     */
    public function read_operator(int $id, OperatorRepository $operator_repository, NormalizerInterface $serializer): JsonResponse
    {
        $operator = $operator_repository->find($id);
        $operator_serialized = $serializer->normalize($operator, null, ['groups' => 'group1']);
        return $this->json($operator_serialized);
    }

    /**
     * @Route("/operator", methods={"POST"})
     */
    public function create_operator(Request $request, OperatorRepository $operator_repository): JsonResponse
    {
        foreach (json_decode($request->getContent()) as $operator) {
            $new_operator = new Operator();
            $new_operator->setNome($operator->nome);
            $operator_repository->add($new_operator);
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
