<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Repair;
use App\Form\TacheType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

class FrontController extends AbstractController
{
    /**
     * @Route("/front", name="front")
     */
    public function connect()
    {
        return $this->render('front/connection.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/detailrepair", name="repair")
     */
    public function detailsRepair()
    {
        return $this->render('front/details_repair.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/addtache", name="add_tache")
     */
    public function addTache(Request $request, FileUploader $fileUploader)
    {
        $repair = new Repair();
        $form = $this->createForm(TacheType::class, $repair);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form['image']->getData();
            if ($image) {
                $imageFileName = $fileUploader->upload($image);
                $repair->setImage($imageFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($repair);
            $entityManager->flush();
            // return new JsonResponse(true);
        }
        
        return $this->render('front/add_tache.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/searchcustomer", name="search_customer")
     */
    public function searchCustomer(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('email') !== '') {
            $email = $request->query->get('email');
            $entityManager = $this->getDoctrine()->getManager();
            $customer = $entityManager->getRepository(Client::class)
                ->findBy(['email' => $email])[0];
            $client = ['lastname' => $customer->getLastname(), 'firstname' => $customer->getFirstname(), 'email' => $customer->getEmail(), 'phonenumber' => $customer->getPhoneNumber(), 'genre' => $customer->getGenre()];
            return new JsonResponse($client);
        } else {
            return new JsonResponse(false);
        }
    }

    /**
     * @Route("/uptache", name="up_tache")
     */
    public function upTache()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $allRepair = $entityManager->getRepository(Repair::class)
                                ->findAll();
        return $this->render('front/tache_up.html.twig', [
            'allrepair' => $allRepair
        ]);
    }
}
