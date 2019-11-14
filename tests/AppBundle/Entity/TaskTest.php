<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    /**
     * test unitaire de la class Task
     */
    public function testTask()
    {
        $task = new Task();

        $task->setCreatedAt(new \DateTime());
        $this->assertNotEmpty($task->getCreatedAt());

    }
}
