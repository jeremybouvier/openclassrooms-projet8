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
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TaskHandlerTest extends TestCase
{
    /**
     * @var TaskHandler
     */
    private $taskHandler;

    /**
     * TaskHandlerTest constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $unitOfWork = $this->createMock(UnitOfWork::class);
        $unitOfWork->method("getEntityState")->willReturn(UnitOfWork::STATE_NEW);
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->method('getUnitOfWork')->willReturn($unitOfWork);
        $flashbag = $this->createMock(FlashBagInterface::class);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $token = $this->createMock(AbstractToken::class);
        $token->method('getUser')->willReturn(new User);
        $tokenStorage->method('getToken')->willReturn($token);
        $this->taskHandler = new TaskHandler($entityManager, $flashbag, $tokenStorage);
    }

    /**
     * Test de la méthode handle
     */
    public function testHandle()
    {
        $this->assertTrue($this->taskHandler->handle($this->submitForm(true), new Task()));
        $this->assertFalse($this->taskHandler->handle($this->submitForm(false), new Task()));
    }

    /**
     * Test de la méthode CreateView
     */
    public function testCreateView()
    {
        $this->taskHandler->handle($this->submitForm(true), new Task());
        $this->assertNull($this->taskHandler->createView());

    }

    /**
     * Test de méthode GetData
     */
    public function testGetData()
    {
        $this->taskHandler->handle($this->submitForm(true), new Task());
        $this->assertInstanceOf(Task::class, $this->taskHandler->getData());
    }

    /**
     * Création et soumission du formulaire
     * @param $validation
     * @return Request
     */
    private function submitForm($validation)
    {
        $form = $this->createMock(FormInterface::class);
        $form->method("isSubmitted")->willReturn($validation);
        $form->method("isValid")->willReturn($validation);
        $form->method("handleRequest")->willReturnSelf();
        $formFactory = $this->createMock(FormFactoryInterface::class);
        $formFactory->method('create')->willReturn($form);
        $this->taskHandler->setFormFactory($formFactory);
        $request = Request::create("/");
        return $request;
    }
}