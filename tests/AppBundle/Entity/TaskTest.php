<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    /**
     * test unitaire de la class Task
     */
    public function testTask()
    {
        $task = new Task();
        $user = new User();

        $this->assertNull($task->getId());
        $task->setTitle('test');
        $this->assertSame('test', $task->getTitle());
        $task->setContent('test');
        $this->assertSame('test', $task->getContent());
        $task->toggle(true);
        $this->assertTrue( $task->isDone());
        $task->setUser($user);
        $this->assertNotEmpty('test', $task->getUser());

        $task->setCreatedAt(new \DateTime());
        $this->assertNotEmpty($task->getCreatedAt());
    }
}
