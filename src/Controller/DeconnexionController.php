<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

class DeconnexionController extends AbstractController
{
    #[Route('/deconnexion', name: 'deconnexion')]
    public function deconnecterUtilisateur(SessionInterface $session, Request $request): RedirectResponse
    {
        $session->remove('user');

        // Rafraîchir la demande actuelle pour recharger la page sans la session ouverte
        return $this->redirect($request->headers->get('referer'));
    }
}