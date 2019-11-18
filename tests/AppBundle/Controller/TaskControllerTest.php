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
        $crawler = $client->request('GET', '/tasks');
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
        $this->assertSame(1, $crawler->filter('html:contains("test content")')->count());
    }

    /**
     * test de l'affichage du formulaire de modification d'une tâche
     */
    public function testShowEditTask()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/tasks/1/edit');
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
        $crawler = $client->request('GET', '/tasks/22/edit');
        $form = $crawler->selectButton('Modifier')->form(['task[title]'=>'test titre', 'task[content]'=>'test content new']);
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('html:contains("test content new")')->count());
    }

    /**
     * test de validation d'une tâche
     */
    public function testValidTask()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/tasks');
        $form = $crawler->selectButton('Marquer comme faite')->form();
        $client->submit($form);
        $crawler= $client->followRedirect();
        $this->assertNotEquals(0, $crawler->filter('html:contains("Marquer non terminée")')->count());
    }

    /**
     * test de dévalidation d'une tâche
     */
    public function testUnvalidTask()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/tasks');
        $form = $crawler->selectButton('Marquer non terminée')->form();
        $client->submit($form);
        $crawler= $client->followRedirect();
        $this->assertNotEquals(0, $crawler->filter('html:contains("Marquer comme faite")')->count());
    }

    /**
     * test de la suppression d'une tâche
     */
    public function testDeleteTask()
    {
        $client = $this->createAuthenticatedClient();
        $crawler = $client->request('GET', '/tasks');
        $form = $crawler->selectButton('Supprimer')->form();
        $client->submit($form);
        $crawler= $client->followRedirect();
        $this->assertEquals(10, $crawler->filter('html div.caption:contains("Créé par admin")')->count());
    }
}