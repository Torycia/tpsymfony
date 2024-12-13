<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('login.html.twig');
    }

    #[Route('/login_check', name: 'login_check', methods: ['POST'])]
    public function loginCheck(Request $request, SessionInterface $session): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user && password_verify($password, $user->getPassword())) {
            $session->set('user_id', $user->getId());
            $session->set('roles', $user->getRoles());
            return $this->redirectToRoute('user_profile');
        }

        return $this->render('login.html.twig', [
            'error' => 'Email ou mot de passe incorrect.',
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(SessionInterface $session): Response
    {
        $session->clear();
        return $this->redirectToRoute('login');
    }
}
