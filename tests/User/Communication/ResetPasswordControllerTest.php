<?php

declare(strict_types=1);

namespace App\Tests\User\Communication;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class ResetPasswordControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ResetPasswordHelperInterface $resetPasswordHelper;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->resetPasswordHelper = $this->client->getContainer()->get(ResetPasswordHelperInterface::class);
    }

    public function testRenderForm(): void
    {
        $this->client->request('GET', '/reset-password');

        self::assertResponseIsSuccessful();
        self::assertPageTitleSame('Reset your password');
        self::assertSelectorExists('form.form');
        self::assertSelectorExists('input[name="reset_password_link_request_form[email]"]');
        self::assertSelectorExists('button.form_primary-btn');
    }

    public function testRequestRedirectsToCheckEmailOnValidEmail(): void
    {
        $this->client->request('GET', '/reset-password');
        $this->client->submitForm('Send password reset email', [
            'reset_password_link_request_form[email]' => 'user1@example.com',
        ]);

        self::assertResponseRedirects('/reset-password/check-email');
        $this->client->followRedirect();
        self::assertPageTitleSame('Password Reset Email Sent');
        self::assertSelectorExists('div.page');
    }

    public function testRequestRedirectsToCheckEmailOnInvalidEmail(): void
    {
        $this->client->request('GET', '/reset-password');
        $this->client->submitForm('Send password reset email', [
            'reset_password_link_request_form[email]' => 'invalid@email.com',
        ]);

        self::assertResponseRedirects('/reset-password/check-email');
        $this->client->followRedirect();
        self::assertPageTitleSame('Password Reset Email Sent');
        self::assertSelectorExists('div.page');
    }

    public function testCheckEmailRendersPage(): void
    {
        $this->client->request('GET', '/reset-password/check-email');

        self::assertSelectorExists('div.page');
        self::assertPageTitleSame('Password Reset Email Sent');
    }

    public function testResetWithNoTokenInSession(): void
    {
        $this->client->request('GET', '/reset-password/reset');

        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
        self::assertSelectorNotExists('form');
    }

    /*public function testReset(): void
    {
        $user = new User();
        $user->setName('Name');
        $user->setEmail('email@gmail.com');
        $user->setPassword('password');

        $entityManager = self::getContainer()->get('doctrine')->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $resetToken = $this->resetPasswordHelper->generateResetToken($user)->getToken();

        $this->client->request('GET', '/reset-password/reset/'.$resetToken);

        $session = $this->client->getRequest()->getSession();
        $session->start();
        $session->set('ResetPasswordPublicToken', $resetToken);

        $this->client->request('GET', '/reset-password/reset/'.$resetToken);
        self::assertResponseRedirects();
        self::assertResponseIsSuccessful();

        self::assertSelectorExists('form[name="change_password"]');

        $this->client->submitForm('Reset password', [
            'change_password[plainPassword][first]' => 'newpassword',
            'change_password[plainPassword][second]' => 'newpassword',
        ]);
        self::assertResponseRedirects('/login');
    }*/
}
