<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Employee;
use App\Form\ClientType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
        $allEmployee = $entityManager->getRepository(Employee::class)->findAll();
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
        return $this->render('admin/intervention.html.twig', [
            'controller_name' => 'AdminController',
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
        return $this->render('admin/add_employee.html.twig', [ 'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/addtache", name="admin_addtache")
     */
    public function addTache()
    {
        return $this->render('admin/add_tache.html.twig', [
            'controller_name' => 'AdminController',
        ]);
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
            'customer' => $customer, 'form'=>$formClient->createView(),
        ]);
    }

    /**
     * @Route("/admin/editintervention", name="admin_editintervention")
     */
    public function editIntervention()
    {
        return $this->render('admin/edit_intervention.html.twig', [
            'controller_name' => 'AdminController',
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
            'employee' => $employee, 'form'=>$form->createView(),
        ]);
    }
}
