<?php

namespace Tests\AppBundle\Handler;

use AppBundle\Entity\User;
use AppBundle\Handler\UserHandler;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserHandlerTest extends TestCase
{
    /**
     * @var UserHandler
     */
    private $userHandler;

    /**
     * UserHandlerTest constructor.
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
        $encoder = $this->createMock(UserPasswordEncoderInterface::class);
        $this->userHandler = new UserHandler($entityManager, $flashbag, $encoder);
    }

    /**
     * Test de la méthode handle
     */
    public function testHandle()
    {
        $this->assertTrue($this->userHandler->handle($this->submitForm(true), new User));
        $this->assertFalse($this->userHandler->handle($this->submitForm(false), new User));
    }

    /**
     * Test de la méthode CreateView
     */
    public function testCreateView()
    {
        $this->userHandler->handle($this->submitForm(true), new User);
        $this->assertNull($this->userHandler->createView());

    }

    /**
     * Test de méthode GetData
     */
    public function testGetData()
    {
        $this->userHandler->handle($this->submitForm(true), new User);
        $this->assertInstanceOf(User::class, $this->userHandler->getData());
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
        $this->userHandler->setFormFactory($formFactory);
        $request = Request::create("/");
        return $request;
    }
}