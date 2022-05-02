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
    public function read_all_clients(Request $request, ClientRepository $client_repository, NormalizerInterface $serializer): Response
    {
        $client_list = $client_repository->findAll();
        $data = $serializer->normalize($client_list, null, ['groups' => 'group1']);
        return $this->json($data);
    }
    /**
     * @Route("/client/{id}", methods={"GET"})
     */
    public function read_client(int $id, ClientRepository $client_repository, NormalizerInterface $serializer): JsonResponse
    {
        $client = $client_repository->find($id);
        $data = $serializer->normalize($client, null, ['groups' => 'group1']);
        return $this->json($data);
    }
    /**
     * @Route("/client", methods={"POST"})
     */
    public function create_client(Request $request, ClientRepository $client_repository, OperatorRepository $operator_repository, PhoneRepository $phone_repository): JsonResponse
    {
        foreach (json_decode($request->getContent()) as $client)
        {
            $date = new \Datetime($client->nascimento);
            $new_client = new Client();
            $new_client->setNome($client->nome);
            $new_client->setCpf($client->cpf);
            $new_client->setNascimento($date);
            $client_repository->add($new_client);
            foreach($client->telefones as $telefone)
            {
                $operadora = $operator_repository->find($telefone->operadora_id);
                $new_telefone = new Phone();
                $new_telefone->setDdd($telefone->ddd);
                $new_telefone->setNumero($telefone->numero);
                $new_telefone->setOperator($operadora);
                $new_telefone->setClient($new_client);
                $phone_repository->add($new_telefone);
            }
        }
        return $this->json('Saved new clients');
    }
    /**
     * @Route("/client/{id}", methods={"PUT"})
     */
    public function update_client(int $id, Request $request, ClientRepository $client_repository, NormalizerInterface $serializer): JsonResponse
    {
        $clientFetched = $client_repository->find($id);
        // $data = $serializer->normalize($client, null, ['groups' => 'group1']);

        foreach (json_decode($request->getContent()) as $clientRequest)
        {
            $date = new \Datetime($clientRequest->nascimento);
            $clientFetched->setNome($clientRequest->nome);
            $clientFetched->setCpf($clientRequest->cpf);
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
        }
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
