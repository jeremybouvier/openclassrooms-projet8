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

        $this->assertNull($user->getId());
        $user->setUsername('test');
        $this->assertSame('test', $user->getUsername());
        $user->setPassword('test');
        $this->assertSame('test', $user->getPassword());
        $user->setEmail('test@email.com');
        $this->assertSame('test@email.com', $user->getEmail());
        $user->setRoles('ROLE_USER');
        $this->assertSame('ROLE_USER', $user->getRoles());
        $user->setRoles('ROLE_USER');
        $this->assertSame('ROLE_USER', $user->getRoles());
        $user->addChat($task);
        $this->assertNotEmpty($user->getChats());
        $this->assertNull($user->getSalt());
    }

}