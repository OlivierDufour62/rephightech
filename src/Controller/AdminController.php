<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Employee;
use App\Entity\Repair;
use App\Entity\Repstatus;
use App\Entity\Status;
use App\Form\ClientType;
use App\Form\EditTacheType;
use App\Form\RepStatusType;
use App\Form\TacheType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/admin/employee", name="admin_employee")
     */
    public function employee()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $allEmployee = $entityManager->getRepository(Employee::class)
            ->findAll();
        return $this->render('admin/employee.html.twig', [
            'allEmployee' => $allEmployee,
        ]);
    }

    /**
     * @Route("/admin/customer", name="admin_customer")
     */
    public function customer()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $allCustomer = $entityManager->getRepository(Client::class)->findAll();
        return $this->render('admin/customer.html.twig', [
            'allCustomer' => $allCustomer,
        ]);
    }

    /**
     * @Route("/admin/intervention", name="admin_intervention")
     */
    public function intervention()
    {
        
        $entityManager = $this->getDoctrine()->getManager();
        $allRepair = $entityManager->getRepository(Repair::class)->findAll();
        return $this->render('admin/intervention.html.twig', [
            'allrepair' => $allRepair
        ]);
    }

    /**
     * @Route("/admin/addemployee", name="admin_addemployee")
     */
    public function addEmployee(Request $request)
    {
        $employee = new Employee();
        $form = $this->createForm(UserType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employee);
            $entityManager->flush();
            return new JsonResponse(true);
        }
        return $this->render('admin/add_employee.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/addtache", name="admin_addtache")
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
            return new JsonResponse(true);
        }
        return $this->render('admin/add_tache.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/searchcustomer", name="admin_search_customer")
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
     * @Route("/admin/editcustomer/{id}", name="admin_editcustomer")
     */
    public function editCustomer(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $customer = $entityManager->getRepository(Client::class)
            ->find($id);
        $formClient = $this->createForm(ClientType::class, $customer);
        $formClient->handleRequest($request);
        if ($formClient->isSubmitted() && $formClient->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();
            return new JsonResponse(true);
        }
        return $this->render('admin/edit_customer.html.twig', [
            'customer' => $customer, 'form' => $formClient->createView(),
        ]);
    }

    /**
     * @Route("/admin/editintervention/{id}", name="admin_editintervention")
     */
    public function editIntervention(Request $request, Repair $repair, FileUploader $fileUploader)
    {
        $idrepair = $request->query->get('rep');
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Repstatus::class)
                                ->findBy(['id' => $idrepair]);
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
            return new JsonResponse(true);
        }
        return $this->render('admin/edit_intervention.html.twig', [
            'repair' => $repair, 'comment' => $comment, 'formrepair' => $formRepair->createView()
        ]);
    }

    /**
     * @Route("/admin/editemployee/{id}", name="admin_editemployee")
     */
    public function editEmployee(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $employee = $entityManager->getRepository(Employee::class)
            ->find($id);
        $form = $this->createForm(UserType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employee);
            $entityManager->flush();
            return new JsonResponse(true);
        }
        return $this->render('admin/edit_employee.html.twig', [
            'employee' => $employee, 'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/customerisactive/{id}", name="customerisactive")
     */

    public function customerIsActive($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $customer = $entityManager->getRepository(Client::class)
            ->find($id);
        if (!$customer) {
            return new JsonResponse(false);
        }
        $customer->setIsActive(!$customer->getIsActive());
        $entityManager->persist($customer);
        $entityManager->flush();
        return new JsonResponse(true);
    }

    /**
     * @Route("/admin/employeeisactive/{id}", name="employeeisactive")
     */

    public function employeeIsActive($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $customer = $entityManager->getRepository(Employee::class)
            ->find($id);
        if (!$customer) {
            return new JsonResponse(false);
        }
        $customer->setIsActive(!$customer->getIsActive());
        $entityManager->persist($customer);
        $entityManager->flush();
        return new JsonResponse(true);
    }

    /**
     * @Route("/admin/repairisactive/{id}", name="repairisactive")
     */

    public function repairIsActive($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $customer = $entityManager->getRepository(Repair::class)
            ->find($id);
        if (!$customer) {
            return new JsonResponse(false);
        }
        $customer->setIsActive(!$customer->getIsActive());
        $entityManager->persist($customer);
        $entityManager->flush();
        return new JsonResponse(true);
    }


    /**
     * @Route("/admin/details/{id}", name="details_repair")
     */

    public function detailsRepair(Request $request, $id)
    {
        
        $entityRepair = $this->getDoctrine()->getManager();
        $repair = $entityRepair->getRepository(Repair::class)
                                ->find($id);
        $comment = new Repstatus();
        $formComment = $this->createForm(RepStatusType::class, $comment);
        $formComment->handleRequest($request);
        $comment->setRep($repair);
        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
            return new JsonResponse(true);
        }
        return $this->render('admin/detailsrepair.html.twig', ['repair' => $repair,
            'comment' => $comment, 'formcomment' => $formComment->createView(),
        ]);
    }
}
