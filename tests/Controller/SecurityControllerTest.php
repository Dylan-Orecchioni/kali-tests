<?php

namespace App\Service\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->client = null;
    }
    public function testLoginPageIsRendered(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('button', "Se connecter");
    }

    public function testSuccessfulLogin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'jdoe@mail.com',
            '_password' => 'password',
        ]);

        $this->client->submit($form);

        $this->assertResponseRedirects('/');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('p', "Vous êtes connecté en tant que");
    }

    public function testWrongLogin(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'wrong@example.com',
            '_password' => 'wrongpassword',
        ]);

        $this->client->submit($form);

        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
    }


    public function testLogout(): void
    {
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'jdoe@mail.com',
            '_password' => 'password',
        ]);

        $this->client->submit($form);

        $this->assertResponseRedirects('/');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('p', "Vous êtes connecté en tant que");

        $crawler = $this->client->request('GET', '/logout');

        $this->assertResponseRedirects('/login');
        $this->client->followRedirect();
        $this->assertSelectorTextContains('button', "Se connecter");
        $this->assertNull($this->client->getContainer()->get('security.token_storage')->getToken());

    }
}
