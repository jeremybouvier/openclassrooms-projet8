<?php


namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * test unitaire de la class Task
     */
    public function testUser()
    {
        $user = new User();
        $task =new Task();
        $user->addChat($task);
        $this->assertNotEmpty($user->getChats());
    }

}