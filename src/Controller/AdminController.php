<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Client;
use App\Entity\Repair;
use App\Entity\ProviderDevice;
use App\Entity\Repstatus;
use App\Entity\ServiceProvider;
use App\Entity\Status;
use App\Entity\Users;
use App\Form\AddressType;
use App\Form\ClientType;
use App\Form\EditTacheType;
use App\Form\ProviderDeviceType;
use App\Form\RepStatusType;
use App\Form\TacheType;
use App\Form\UserType;
use App\Repository\DeviceRepository;
use App\Repository\RepairRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

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
        $allEmployee = $entityManager->getRepository(Users::class)
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
     * @Route("/admin/provider", name="admin_provider")
     */
    public function provider()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $allProvider = $entityManager->getRepository(Users::class)->findBy(['role' => 'ROLE_PROVIDER']);
        return $this->render('admin/provider.html.twig', [
            'allprovider' => $allProvider
        ]);
    }

    /**
     * @Route("/admin/addemployee", name="admin_addemployee")
     */
    public function addEmployee(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $addUsers = new Address();
        $userPassword = new Users();
        $form = $this->createForm(AddressType::class, $addUsers);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($userPassword, $addUsers->getUsers()->getPassword());
            $userPassword->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($addUsers);
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
        $entityManager = $this->getDoctrine()->getManager();
        $employee = $this->getUser();
        $repair = new Repair();
        $repair->setUsers($employee);
        $form = $this->createForm(TacheType::class, $repair);
        $form->handleRequest($request);
        $errors = $form->getErrors();
        $status = $entityManager->getRepository(Status::class)
            ->find(['id' => 1]);
        $repair->setStatus($status);
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
            'error' => $errors,
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
    public function editIntervention(Request $request, Repair $repair, FileUploader $fileUploader, $id)
    {
        $idrepair = $repair->getId();
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Repstatus::class)
            ->findBy(['rep' => $idrepair]);
        $formRepair = $this->createForm(EditTacheType::class, $repair);
        $formRepair->handleRequest($request);
        // $status = $entityManager->getRepository(Status::class)
        //                     ->find(['id' => $id->getId()]);
        // dd($idrepair);
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
        $employee = $entityManager->getRepository(Users::class)
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
     * @Route("/admin/editprovider/{id}", name="admin_editprovider")
     */
    public function editProvider(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $provider = $entityManager->getRepository(Users::class)
            ->find($id);
        $form = $this->createForm(UserType::class, $provider);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($provider);
            $entityManager->flush();
            return new JsonResponse(true);
        }
        return $this->render('admin/edit_provider.html.twig', [
            'provider' => $provider, 'form' => $form->createView(),
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
        $employee = $entityManager->getRepository(Users::class)
            ->find($id);
        if (!$employee) {
            return new JsonResponse(false);
        }
        $employee->setIsActive(!$employee->getIsActive());
        $entityManager->persist($employee);
        $entityManager->flush();
        return new JsonResponse(true);
    }

    /**
     * @Route("/admin/repairisactive/{id}", name="repairisactive")
     */

    public function repairIsActive($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $repair = $entityManager->getRepository(Repair::class)
            ->find($id);
        if (!$repair) {
            return new JsonResponse(false);
        }
        $repair->setIsActive(!$repair->getIsActive());
        $entityManager->persist($repair);
        $entityManager->flush();
        return new JsonResponse(true);
    }

    /**
     * @Route("/admin/providerisactive/{id}", name="providerisactive")
     */
    public function providerIsActive($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $provider = $entityManager->getRepository(ServiceProvider::class)
            ->find($id);
        if (!$provider) {
            return new JsonResponse(false);
        }
        $provider->setIsActive(!$provider->getIsActive());
        $entityManager->persist($provider);
        $entityManager->flush();
        return new JsonResponse(true);
    }

    /**
     * @Route("/admin/details/{id}", name="details_repair")
     */
    public function detailsRepair(Request $request, Repair $repair)
    {
        $idrepair = $repair->getId(); //for the view
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Repstatus::class)
            ->findBy(['rep' => $idrepair]);
        $idrep = new Repstatus(); //for update
        $formComment = $this->createForm(RepStatusType::class, $idrep);
        $formComment->handleRequest($request);
        $idrep->setRep($repair);
        $repair->setStatus($idrep->getStatus());
        if ($formComment->isSubmitted() && $formComment->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($idrep);
            $entityManager->flush();
            return new JsonResponse(true);
        }
        return $this->render('admin/detailsrepair.html.twig', [
            'repair' => $repair,
            'commentform' => $idrep, 'formcomment' => $formComment->createView(), 'comment' => $comment
        ]);
    }

    /**
     * @Route("/admin/addprovider", name="admin_addprovider")
     */
    public function addProvider(Request $request)
    {
        $provider = new ServiceProvider();
        $form = $this->createForm(UserType::class, $provider);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($provider);
            $entityManager->flush();
            return new JsonResponse(true);
        }
        return $this->render('admin/add_provider.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/sendinterprovider", name="admin_sendintervention")
     */
    public function sendIntervention(DeviceRepository $deviceRepository, RepairRepository $repair, Request $request, MailerInterface $mailer)
    {
        //affiche les intervention ayant pour status en cours
        $entityManager = $this->getDoctrine()->getManager();
        $inter = $entityManager->getRepository(Repair::class)
            ->findBy(['status' => 2]);
        
        // crée le formulaire pour enregistré dans ProviderDevice
        $providerDevice = new ProviderDevice();
        $form = $this->createForm(ProviderDeviceType::class, $providerDevice);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $repair = $repair->find($form->get('repair_id')->getData());
            $device = $deviceRepository->find($repair->getDevice()->getId());
            $providerDevice->setDevice($device);
            // pour modifier le statut 
            $status = $entityManager->getRepository(Status::class)
                ->find(['id' => 3]);
            $repair->setStatus($status);
            $repStatus = new Repstatus();
            $repStatus->setStatus($status);
            $providerDevice->setUsers($form->get('users')->getData());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($providerDevice);
            $entityManager->flush();
            //envoie email automatique pour prévenir de l'expédition d'une intervention au prestataire choisi
            $toAddress = $providerDevice->getUsers()->getEmail();
            $toName = $providerDevice->getUsers()->getName();
            $ref = new Repair();
            $toRef = $ref->getReference();
            $email = (new TemplatedEmail())
                ->from('projetwebafpa@gmail.com')
                ->to($toAddress)
                ->subject('Nous vous avons envoyer une intervention :-)')
                ->htmlTemplate('/emails/inter.html.twig')
                ->context([
                        'name' => $toName,
                        'ref' => $toRef
                ])
                ;
            $mailer->send($email);
        }
        return $this->render('admin/sendinter.html.twig', [
            'inter' => $inter, 'form' => $form->createView()
        ]);
    }
}
