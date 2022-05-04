<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Phone;
use App\Repository\ClientRepository;
use App\Repository\PhoneRepository;
use App\Repository\OperatorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", methods={"GET"})
     */
    public function read_all_clients(ClientRepository $client_repository, NormalizerInterface $serializer): Response
    {
        $client_list = $client_repository->findAll();
        $client_list_serialized = $serializer->normalize($client_list, null, ['groups' => 'group1']);
        return $this->json($client_list_serialized);
    }

    /**
     * @Route("/client/{id}", methods={"GET"})
     */
    public function read_client(int $id, ClientRepository $client_repository, NormalizerInterface $serializer): JsonResponse
    {
        $client = $client_repository->find($id);
        $client_serialized = $serializer->normalize($client, null, ['groups' => 'group1']);
        return $this->json($client_serialized);
    }

    /**
     * @Route("/client", methods={"POST"})
     */
    public function create_client(Request $request, ClientRepository $client_repository): JsonResponse
    {
        $body = json_decode($request->getContent());
        $clients_created_list = [];

        foreach ($body as $client)
        {
            $date = new \Datetime($client->nascimento);
            $new_client = new Client();
            $new_client->setNome($client->nome);
            $new_client->setCpf($client->cpf);
            $new_client->setNascimento($date);

            $clients_created_list[] = $new_client;
            $client_repository->add($new_client);
        }
        return $this->json(['Saved new clients' => $clients_created_list]);
    }

    /**
     * @Route("/client/{id}", methods={"PUT"})
     */
    public function update_client(int $id, Request $request, ClientRepository $client_repository, NormalizerInterface $serializer): JsonResponse
    {
        $client_body_request = json_decode($request->getContent());
        $clientFetched = $client_repository->find($id);
        // $data = $serializer->normalize($client, null, ['groups' => 'group1']);

        $date = new \Datetime($client_body_request->nascimento);
        $clientFetched->setNome($client_body_request->nome);
        $clientFetched->setCpf($client_body_request->cpf);
        $clientFetched->setNascimento($date);
        $client_repository->add($clientFetched);
        // foreach($clientRequest->telefones as $telefone)
        // {
        //     $operadora = $operator_repository->find($telefone->operadora_id);
        //     $new_telefone = new Phone();
        //     $new_telefone->setDdd($telefone->ddd);
        //     $new_telefone->setNumero($telefone->numero);
        //     $new_telefone->setOperator($operadora);
        //     $new_telefone->setClient($new_client);
        //     $phone_repository->add($new_telefone);
        // }
        return $this->json('Updated client');
    }

    /**
     * @Route("/client/{id}", methods={"DELETE"})
     */
    public function delete_client(int $id, ClientRepository $client_repository, NormalizerInterface $serializer): JsonResponse
    {
        $client = $client_repository->find($id);
        $data = $serializer->normalize($client, null, ['groups' => 'group1']);
        $client_repository->remove($client);
        return $this->json($data);
    }
}
