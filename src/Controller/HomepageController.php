<?php

namespace App\Controller;

use App\Entity\User;
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
        $user = new User();
        if($this->getUser() !== null) {
            $user = $this->getUser();
        }
        return $this->render('homepage/index.html.twig', [
            'rooms' => $roomRepository->findAll(),
            'user' => $user
        ]);
    }
}
