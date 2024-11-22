<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;

class RegisterTest extends WebTestCase
{
    private $client;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();


        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
    }

    protected function tearDown(): void
    {

        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => 'jane.doe@example.com']);

        if ($user) {
            $this->entityManager->remove($user);
            $this->entityManager->flush();
        }


        $this->client = null;

        parent::tearDown();
    }

    public function testSuccessfullRegister(): void
    {
        $crawler = $this->client->request('GET', '/register');

        $form = $crawler->selectButton("Register")->form([
            'registration_form[email]' => 'jane.doe@mail.com',
            'registration_form[plainPassword]' => 'password',
            'registration_form[firstName]' => 'Jane',
            'registration_form[lastName]' => 'Doe',
            'registration_form[agreeTerms]' => true,
        ]);
        $this->client->submit($form);

        $this->assertResponseRedirects('/login');

        $this->client->followRedirect();

        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => 'jane.doe@mail.com']);

        $this->assertNotNull(
            $user,
            'L\'utilisateur n\'a pas été créé en base de données.'
        );
        $this->assertEquals(
            'Jane',
            $user->getFirstname(),
            'Le prénom enregistré dans la base ne correspond pas.'
        );
        $this->assertEquals(
            'Doe',
            $user->getLastname(),
            'Le nom de famille enregistré dans la base ne correspond pas.'
        );

        $this->assertContains(
            'ROLE_USER',
            $user->getRoles(),
            'Le rôle de l\'utilisateur n\'a pas été défini correctement.'
        );
    }
}
