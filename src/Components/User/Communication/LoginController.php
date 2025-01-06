<?php

declare(strict_types=1);

namespace App\Components\User\Communication;

use App\Components\User\Communication\Form\Type\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
   /* #[Route('/login', name: 'login_page', methods: ['GET'])]
    public function page(): Response
    {
        $form = $this->createForm(LoginForm::class);

        return $this->render('login/login.html.twig', ['form' => $form, 'error' => null]);
    }

    #[Route('/login', name: 'login_form', methods: ['POST'])]
    public function form(AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(LoginForm::class);

        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('login/login.html.twig', [
            'form' => $form,
            'error' => $error,
        ]);
    }*/

    // todo add logout route
    // todo login authenticator is not supported
    // todo classes in twig dont apply
}
