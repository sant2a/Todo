<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FullHomeController extends AbstractController
{
    /**
     * @Route("/full/home", name="full_home")
     */
    public function index()
    {
        return $this->render('full_home/index.html.twig', [
            'controller_name' => 'FullHomeController',
        ]);
    }
}
