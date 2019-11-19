<?php


namespace Tests\AppBundle\Handler;


use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Handler\TaskHandler;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TaskHandlerTest extends TestCase
{
    /**
     * Test du handle d'un user
     */
    public function testTaskHandle()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $flashbag = $this->createMock(FlashBagInterface::class);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $taskHandler = new TaskHandler($entityManager, $flashbag, $tokenStorage);

        $form = $this->createMock(FormInterface::class);
        $form->method("isSubmitted")->willReturn(true);
        $form->method("isValid")->willReturn(true);
        $form->method("handleRequest")->willReturnSelf();


        $formFactory = $this->createMock(FormFactoryInterface::class);
        $formFactory->method('create')->willReturn($form);
        $taskHandler->setFormFactory($formFactory);



    }

}