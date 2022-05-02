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

class ClientController extends AbstractController
{
    /**
     * @Route("/client", methods={"GET"})
     */
    public function read_all_clients(Request $request): Response
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
            return $this->json('Saved new clients');
        }
    }
    /**
     * @Route("/client/{id}", methods={"PUT"})
     */
    public function update_client(int $id, Request $request): JsonResponse
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
            'route' => 'PUT update_client with id: '.$id,
            'updated data' => json_decode($request->getContent(), true)
        ]);
    }
    /**
     * @Route("/client/{id}", methods={"DELETE"})
     */
    public function delete_client(): JsonResponse
    {
        return $this->json(['route' => 'DELETE delete_client']);
    }
}
