<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function addTache()
    {
        return $this->render('front/add_tache.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }

    /**
     * @Route("/uptache", name="up_tache")
     */
    public function upTache()
    {
        return $this->render('front/tache_up.html.twig', [
            'controller_name' => 'FrontController',
        ]);
    }
}
