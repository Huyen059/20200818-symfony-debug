<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(RoomRepository $roomRepository)
    {
        return $this->render('homepage/index.html.twig', [
            'rooms' => $roomRepository->findAll(),
        ]);
    }
}
