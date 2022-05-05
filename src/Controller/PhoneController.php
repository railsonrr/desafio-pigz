<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Repository\ClientRepository;
use App\Repository\OperatorRepository;
use App\Repository\PhoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class PhoneController extends AbstractController
{
    /**
     * @Route("/phone", methods={"POST"})
     */
    public function create_phone(Request $request, PhoneRepository $phone_repository, ClientRepository $client_repository, OperatorRepository $operator_repository, NormalizerInterface $serializer): Response
    {
        $body = json_decode($request->getContent());
        $phones_created_list = [];
        
        foreach ($body as $phone)
        {
            $client_relationed = $client_repository->find($phone->client_id);
            $operator_relationed = $operator_repository->find($phone->operator_id);

            if (!$client_relationed || !$operator_relationed)
            {
                continue;
            }

            $new_phone = new Phone();
            $new_phone->setDdd($phone->ddd);
            $new_phone->setNumero($phone->numero);
            $new_phone->setClient($client_relationed);
            $new_phone->setOperator($operator_relationed);

            $phones_created_list[] = $new_phone;
            $phone_repository->add($new_phone);
        }

        $phones_created_list_serialized = $serializer->normalize($phones_created_list, null, ['groups' => 'group1']);
        return $this->json(['Saved new phones' => $phones_created_list_serialized]);
    }

    /**
     * @Route("/phone", methods={"GET"})
     */
    public function read_all_phones(PhoneRepository $phone_repository, NormalizerInterface $serializer): Response
    {
        $phones_list = $phone_repository->findAll();
        $phones_list_serialized = $serializer->normalize($phones_list, null, ['groups' => 'group1']);
        return $this->json($phones_list_serialized);
    }

    /**
     * @Route("/phone/{id}", methods={"GET"})
     */
    public function read_phone(int $id, PhoneRepository $phone_repository, NormalizerInterface $serializer): Response
    {
        $phone = $phone_repository->find($id);
        $phones_serialized = $serializer->normalize($phone, null, ['groups' => 'group1']);
        return $this->json($phones_serialized);
    }
    
    /**
     * @Route("/phone/{id}", methods={"PUT"})
     */
    public function update_phone(int $id, Request $request, PhoneRepository $phone_repository, OperatorRepository $operator_repository, ClientRepository $client_repository, NormalizerInterface $serializer): Response
    {
        $phone_body_request = json_decode($request->getContent());
        $phone_fetched = $phone_repository->find($id);
        $client_relationed = $client_repository->find($phone_body_request->client_id);
        $operator_relationed = $operator_repository->find($phone_body_request->operator_id);

        if (!$phone_fetched || !$client_relationed || !$operator_relationed)
        {
            return $this->json(null);
        }

        $phone_fetched->setDdd($phone_body_request->ddd);
        $phone_fetched->setNumero($phone_body_request->numero);
        $phone_fetched->setClient($client_relationed);
        $phone_fetched->setOperator($operator_relationed);

        $phone_repository->add($phone_fetched);

        $phone_fetched_serialized = $serializer->normalize($phone_fetched, null, ['groups' => 'group1']);
        return $this->json(['Update phone' => $phone_fetched_serialized]);
    }

    /**
     * @Route("/phone/{id}", methods={"DELETE"})
     */
    public function delete_phone(int $id, PhoneRepository $phone_repository, NormalizerInterface $serializer): Response
    {
        $phone = $phone_repository->find($id);

        if(!$phone)
        {
            return $this->json(null);
        }

        $data = $serializer->normalize($phone, null, ['groups' => 'group1']);
        $phone_repository->remove($phone);
        return $this->json(["Deleted phone" => $data]);
    }
}
