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
    public function index(Request $request, PhoneRepository $phone_repository, ClientRepository $client_repository, OperatorRepository $operator_repository, NormalizerInterface $serializer): Response
    {
        $body = json_decode($request->getContent());
        $phones_created_list = [];
        
        foreach ($body as $phone)
        {
            $client_relationed = $client_repository->find($phone->client_id);
            $operator_relationed = $operator_repository->find($phone->operator_id);

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
}
