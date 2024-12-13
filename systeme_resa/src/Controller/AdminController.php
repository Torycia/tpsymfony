<?php
// src/Controller/AdminController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class AdminController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/admin', name: 'admin_dashboard')]
    public function adminDashboard(): Response
    {
        $session = $this->requestStack->getSession();
        $roles = $session->get('roles', []);

        if (!in_array('ROLE_ADMIN', $roles)) {
            return new Response('Access Denied: You must be an admin to access this page.', 403);
        }

        // Code pour le tableau de bord admin
        return new Response('<html><body>Admin Dashboard</body></html>');
    }
}
