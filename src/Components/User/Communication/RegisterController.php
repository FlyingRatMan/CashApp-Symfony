<?php

declare(strict_types=1);

namespace App\Components\User\Communication;

use App\Components\User\Persistence\Mapper\UserMapper;
use App\Components\User\Persistence\UserEntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    public function __construct(
        private UserMapper $mapper,
        private UserEntityManager $entityManager,
    ) {
    }

    #[Route('/register', name: 'register', methods: ['POST', 'GET'])]
    public function index(Request $request, ValidatorInterface $validator): Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'class' => 'border border-gray-300 rounded-lg px-4 py-2 text-green-800 font-normal focus:outline-none focus:ring-2 focus:ring-green-400',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'border border-gray-300 rounded-lg px-4 py-2 text-green-800 font-normal focus:outline-none focus:ring-2 focus:ring-green-400',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    // or add here custom assert
                ],
            ])
            ->add('password', RepeatedType::class, [
                'label' => 'Password',
                'attr' => [
                    'class' => 'border border-gray-300 rounded-lg px-4 py-2 text-green-800 font-normal focus:outline-none focus:ring-2 focus:ring-green-400',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
            ->add('register', SubmitType::class, [
                'label' => 'Sign in!',
                'attr' => [
                    'class' => 'bg-green-400 text-white px-4 py-2 rounded-lg hover:bg-green-500',
                ],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $newUser = [
                'id' => 1,
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ];

            $userDTO = $this->mapper->createUserDTO($newUser);

            // either call validation method from another class

            $this->entityManager->save($userDTO);
            $this->redirectToRoute('login');
        }

        /*if ($request->isMethod('POST')) {
            $newUser = [
                'id' => 1,
                'name' => $request->request->get('name'),
                'email' => $request->request->get('email'),
                'password' => $request->request->get('password'),
            ];

            $userDTO = $this->mapper->createUserDTO($newUser);

            $violations = $validator->validate($userDTO);

            if (count($violations) > 0) {
                $errors = [];
                foreach ($violations as $violation) {
                    $errors[$violation->getPropertyPath()] = $violation->getMessage();
                }

                return $this->render('user/register.html.twig', ['userName' => $userDTO->name, 'userEmail' => $userDTO->email, 'errors' => $errors]);
            }

            $this->entityManager->save($userDTO);
            $this->redirectToRoute('login');
        }*/

        return $this->render('user/register.html.twig', ['userName' => '', 'userEmail' => '', 'errors' => []]);
    }
}
