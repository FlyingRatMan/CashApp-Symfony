<?php

declare(strict_types=1);

namespace App\Components\Account\Communication;

use App\Components\Account\Communication\Form\AccountForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'account_page', methods: ['GET'])]
    public function index(): Response
    {
        $form = $this->createForm(AccountForm::class);

        return $this->render('account/account.html.twig', [
            'form' => $form,
        ]);
    }
}
