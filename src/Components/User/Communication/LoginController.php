<?php

declare(strict_types=1);

namespace App\Components\User\Communication;

use App\Components\User\Business\Model\UserValidation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints as Assert;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['POST', 'GET'])]
    public function index(Request $request, UserValidation $validator): Response
    {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'border border-gray-300 rounded-lg px-4 py-2 text-green-800 font-normal focus:outline-none focus:ring-2 focus:ring-green-400',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Email is required']),
                    new Assert\Email(['message' => 'Email is not valid']),
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'attr' => [
                    'class' => 'border border-gray-300 rounded-lg px-4 py-2 text-green-800 font-normal focus:outline-none focus:ring-2 focus:ring-green-400',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Password is required']),
                    new Assert\Regex(['pattern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/", 'message' => 'Password is not valid']),
                ],
            ])
            ->add('login', SubmitType::class, [
                'label' => 'Log in!',
                'attr' => [
                    'class' => 'bg-green-400 text-white px-4 py-2 rounded-lg hover:bg-green-500',
                ],
            ])
            ->add('reset', SubmitType::class, [
                'label' => 'Forgot your password?',
                'attr' => [
                    'class' => 'border border-green-300 text-green-900 px-4 py-2 rounded-lg hover:bg-green-300',
                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $user = $validator->verifyUser($data['email'], $data['password']);
            if (null !== $user) {
                $this->addFlash('loggedUser', $user->name);

                return $this->redirectToRoute('account');
            }
        }

        return $this->render('user/login.html.twig', [
            'form' => $form->createView(),
            'err' => '',
        ]);
    }
}
