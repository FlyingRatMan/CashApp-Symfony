<?php

namespace App\Tests\User\Communication;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testLoginSuccessful(): void
    {
        $this->client->request('GET', '/login');
        $this->client->submitForm('Log in', [
            '_username' => 'user1@example.com',
            '_password' => 'password1',
        ]);

        self::assertResponseRedirects('/register');
        $this->client->followRedirect();

        self::assertSelectorNotExists('.alert-danger');
        self::assertResponseIsSuccessful();
    }

    public function testLoginWithWrongEmail(): void
    {
        $this->client->request('GET', '/login');
        self::assertResponseIsSuccessful();

        $this->client->submitForm('Log in', [
            '_username' => 'doesNotExist@example.com',
            '_password' => 'password',
        ]);

        self::assertResponseRedirects('/login');
        $this->client->followRedirect();

        self::assertSelectorTextContains('.alert-danger', 'Invalid credentials.');
    }

    public function testLoginWithWrongPassword(): void
    {
        $this->client->request('GET', '/login');
        self::assertResponseIsSuccessful();

        $this->client->submitForm('Log in', [
            '_username' => 'user1@example.com',
            '_password' => 'bad-password',
        ]);

        self::assertResponseRedirects('/login');
        $this->client->followRedirect();

        self::assertSelectorTextContains('.alert-danger', 'Invalid credentials.');
    }
}
