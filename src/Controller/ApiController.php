<?php

namespace App\Controller;


use App\Entity\Device;
use App\Entity\Repair;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    
    /**
     * @Route("/api/device/{id}", name="api_device")
     */
    public function getDevice(Device $device)
    {
        $response = new Response($this->get('serializer')->serialize($device, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/api/repair/{reference}", name="api_repair")
     */
    public function getRepair(Repair $repair)
    {
        $json = $this->get('serializer')->serialize($repair, 'json', ['groups' => 'group1']);
        $response = new JsonResponse($json, 200, [], true);
        return $response;
    }
}