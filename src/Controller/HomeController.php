<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Security $security, ?User $user) : Response
    {
        $user = $security->getUser();

        return $this->render('home/index.html.twig', [
            'isAuthenticated' => $user !== null,
            'user' => $user
        ]);
    }
}