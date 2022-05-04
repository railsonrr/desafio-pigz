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
        $body = json_decode($request->getContent());
        $operator_fetched_list = $operator_repository->findAll();

        $operators_name_existents = [];
        foreach ($operator_fetched_list as $operator_fetched) {
            $operators_name_existents[] = $operator_fetched->getNome();
        }

        $operators_created_list = [];
        
        foreach ($body as $operator) {

            $is_operator_existent = false;

            foreach($operators_name_existents as $existent_name)
            {
                if($operator->nome === $existent_name)
                {
                    $is_operator_existent = true;
                    continue;
                }
            }

            if($is_operator_existent)
            {
                continue;
            }

            $new_operator = new Operator();
            $new_operator->setNome($operator->nome);
            $operator_repository->add($new_operator);

            $operators_created_list[] = $new_operator;
        }
        return $this->json(["Saved new operators" => $operators_created_list]);
    }

    /**
     * @Route("/operator/{id}", methods={"PUT"})
     */
    public function update_operator(int $id, Request $request, OperatorRepository $operator_repository): JsonResponse
    {
        $operator_body_request = json_decode($request->getContent());
        $operator_fetched = $operator_repository->find($id);

        if(!$operator_fetched)
        {
            return $this->json(null);
        }
        
        $operator_fetched->setNome($operator_body_request->nome);
        $operator_repository->add($operator_fetched);

        return $this->json(["Updated operator" => $operator_fetched]);
    }

    /**
     * @Route("/operator/{id}", methods={"DELETE"})
     */
    public function delete_operator(int $id, OperatorRepository $operator_repository): JsonResponse
    {
        $operator_fetched = $operator_repository->find($id);
        $operator_repository->remove($operator_fetched);
        return $this->json(['Deleted operator' => $operator_fetched]);
    }
}
