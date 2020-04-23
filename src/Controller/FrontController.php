<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Repair;
use App\Entity\Repstatus;
use App\Form\EditTacheType;
use App\Form\RepStatusType;
use App\Form\TacheType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class FrontController extends AbstractController
{
    
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('/uptache');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('front/connection.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/editrepair/{id}", name="editrepair")
     */
    public function editRepair(Request $request, Repair $repair, FileUploader $fileUploader)
    {
        $idrepair = $repair->getId();
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Repstatus::class)
                                ->findBy(['rep' => $idrepair]);
        $formRepair = $this->createForm(EditTacheType::class, $repair);
        $formRepair->handleRequest($request);
        if ($formRepair->isSubmitted() && $formRepair->isValid()) {
            /** @var UploadedFile $image */
            $image = $formRepair['image']->getData();
            if ($image) {
                $imageFileName = $fileUploader->upload($image);
                $repair->setImage($imageFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($repair);
            $entityManager->flush();
            //return new JsonResponse(true);
        }
        return $this->render('front/edit_repair.html.twig', [
            'repair' => $repair, 'comment' => $comment, 'formrepair' => $formRepair->createView()
        ]);
    }

    /**
     * @Route("/addtache", name="add_tache")
     */
    public function addTache(Request $request, FileUploader $fileUploader)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $employee = $this->getUser();
        $repair = new Repair();
        $repair->setEmp($employee);
        $form = $this->createForm(TacheType::class, $repair);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $image */
            $image = $form['image']->getData();
            if ($image) {
                $imageFileName = $fileUploader->upload($image);
                $repair->setImage($imageFileName);
            }
            $email = $repair->getClient()->getEmail();
            $entityManager = $this->getDoctrine()->getManager();
            $customer = $entityManager->getRepository(Client::class)
                ->findBy(['email' => $email])[0] ?? null;
            if ($customer !== null) {
                $tmpClient = $repair->getClient();
                $customer->setLastName($tmpClient->getLastname());
                $customer->setFirstName($tmpClient->getFirstname());
                $customer->setPhoneNumber($tmpClient->getPhoneNumber());
                $customer->setGenre($tmpClient->getGenre());
                $repair->setClient($customer);
            }
            $entityManager->persist($repair);
            $entityManager->flush();
            return new JsonResponse(true);
        }
        return $this->render('admin/add_tache.html.twig', [
            'form' => $form->createView()
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
                ->findBy(['email' => $email])[0] ?? null;
            if ($customer == null) {
                $customer = new Client();
                $customer->setEmail($email)
                    ->setFirstname('')
                    ->setLastname('')
                    ->setPhoneNumber('')
                    ->setGenre('');
            }
            $client = ['id' => $customer->getId(), 'lastname' => $customer->getLastname(), 'firstname' => $customer->getFirstname(), 'email' => $customer->getEmail(), 'phonenumber' => $customer->getPhoneNumber(), 'genre' => $customer->getGenre()];

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

    /**
     * @Route("/details/{id}", name="front_details_repair")
     */

    public function detailsRepair(Request $request, Repair $repair)
    {
        $idrepair = $repair->getId();
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Repstatus::class)
                                ->findBy(['rep' => $idrepair]);
        $commentForm = new Repstatus();
        $formComment = $this->createForm(RepStatusType::class, $commentForm);
        $formComment->handleRequest($request);
        $commentForm->setRep($repair);
        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentForm);
            $entityManager->flush();
            return new JsonResponse(true);
        }
        return $this->render('front/detailsrepair.html.twig', ['repair' => $repair,
            'commentform' => $commentForm, 'formcomment' => $formComment->createView(),'comment' => $comment
        ]);
    }
}
