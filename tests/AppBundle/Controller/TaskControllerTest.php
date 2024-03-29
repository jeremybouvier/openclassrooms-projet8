<?php

namespace Tests\AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    use AuthenticationTrait;

    /**
     * test de l'affichage des tâches
     */
    public function testShowTasks()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/tasks/list/0');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('html:contains("Créer une tâche")')->count());
    }


    /**
     * test de l'ajout d'une tâche
     */
    public function testAddTask()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form(['task[title]'=>'test titre', 'task[content]'=>'test content']);
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("test content")')->count());
    }

    /**
     * test de l'affichage du formulaire de modification d'une tâche
     */
    public function testShowEditTask()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/tasks/11/edit');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('html:contains("Title")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Content")')->count());
        $this->assertEquals(1, $crawler->filter('html:contains("Modifier")')->count());
    }

    /**
     * test de modification d'une tâche
     */
    public function testEditTask()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/tasks/11/edit');
        $form = $crawler->selectButton('Modifier')->form(['task[title]'=>'test titre', 'task[content]'=>'test content new']);
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("test content new")')->count());
    }

    /**
     * test de validation d'une tâche
     */
    public function testValidTask()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/tasks/list');
        $form = $crawler->selectButton('Marquer comme faite')->eq(1)->form();
        $client->submit($form);
        $crawler= $client->followRedirect();
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/tasks/list/1');
        $this->assertEquals(1, $crawler->filter('html:contains("Marquer non terminée")')
            ->count()
        );
    }

    /**
     * test de dévalidation d'une tâche
     */
    public function testUnValidTask()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/tasks/list/1');
        $form = $crawler->selectButton('Marquer non terminée')->form();
        $client->submit($form);
        $crawler= $client->followRedirect();
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/tasks/list/0');
        $this->assertNotEquals(101, $crawler->filter('html:contains("Marquer non terminée")')->count());
    }

    /**
     * test de la suppression d'une tâche
     */
    public function testDeleteTask()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/tasks/list/0');
        $form = $crawler->selectButton('Supprimer')->eq(20)->form();
        $client->submit($form);
        $crawler= $client->followRedirect();
        $this->assertSame(200, $client->getResponse()->getStatusCode());

        $this->assertEquals(20, $crawler->filter('html button:contains("Supprimer")')->count());
    }
}