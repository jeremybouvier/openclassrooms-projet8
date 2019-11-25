<?php


namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    use AuthenticationTrait;

    /**
     * test de l'affichage des utilisateurs
     */
    public function testShowUsers()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/admin/users');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('html:contains("Liste des utilisateurs")')->count());
    }

    /**
     * test de l'ajout d'un utilisateur
     */
    public function testAddUser()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/users/create');
        $form = $crawler->selectButton('Ajouter')->form([
            'user[username]'=>'usertest1',
            'user[password][first]'=>'usertest1',
            'user[password][second]'=>'usertest1',
            'user[email]'=>'usertest1@gmail.com']);
        $client->submit($form);
        $crawler= $client->followRedirect();
        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $crawler= $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('html:contains("utilisateur a bien été ajouté.")')->count());
    }

    /**
     * test de modification d'un utilisateur
     */
    public function testEditUser()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/admin/users/2/edit');
        $form = $crawler->selectButton('Modifier')->form([
            'user[username]'=>'usertest2',
            'user[password][first]'=>'usertest2',
            'user[password][second]'=>'usertest2',
            'user[email]'=>'usertest2@gmail.com']);
        $client->submit($form);
        $crawler= $client->followRedirect();
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('html:contains("utilisateur a bien été modifié")')->count());

    }

    /**
     * test des droits d'accès des utilisateurs
     */
    public function testAccessUsers()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/admin/users');
        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('html:contains("Mot de passe")')->count());

        $crawler = $client->request('GET', '/tasks');
        $this->assertSame(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertEquals(1, $crawler->filter('html:contains("Mot de passe")')->count());

        $client = $this->createAuthenticatedClient('usertest1');
        $crawler = $client->request('GET', '/admin/users');
        $this->assertSame(403, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/tasks/2/delete');
        $this->assertSame(403, $client->getResponse()->getStatusCode());

        $crawler = $client->request('GET', '/admin/users/5/edit');
        $this->assertSame(403, $client->getResponse()->getStatusCode());
    }
}