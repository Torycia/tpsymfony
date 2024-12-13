<?php

// src/Controller/UserController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class UserController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/profile', name: 'user_profile')]
    public function userProfile(): Response
    {
        $session = $this->requestStack->getSession();
        $roles = $session->get('roles', []);

        if (!in_array('ROLE_USER', $roles)) {
            return new Response('Access Denied: You must be a user to access this page.', 403);
        }

        // Code pour afficher le profil de l'utilisateur
        return new Response('<html><body>User Profile</body></html>');
    }

    #[Route('/reservations', name: 'user_reservations')]
    public function userReservations(): Response
    {
        $session = $this->requestStack->getSession();
        $roles = $session->get('roles', []);

        if (!in_array('ROLE_USER', $roles)) {
            return new Response('Access Denied: You must be a user to access this page.', 403);
        }

        // Code pour afficher les réservations de l'utilisateur
        return new Response('<html><body>User Reservations</body></html>');
    }
}
