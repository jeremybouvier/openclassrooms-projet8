<?php


namespace Tests\AppBundle\Handler;

use AppBundle\Entity\User;
use AppBundle\Handler\UserHandler;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserHandlerTest extends TestCase
{
    /**
     * Test du handle d'un user
     */
    public function testUserHandle()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        //$entityManager->method('getEntityState')->willReturn('STATE_NEW');
        $flashbag = $this->createMock(FlashBagInterface::class);
        $encoder = $this->createMock(UserPasswordEncoderInterface::class);
        $userHandler = new UserHandler($entityManager, $flashbag, $encoder);

        $form = $this->createMock(FormInterface::class);
        $form->method("isSubmitted")->willReturn(true);
        $form->method("isValid")->willReturn(true);
        $form->method("handleRequest")->willReturnSelf();


        $formFactory = $this->createMock(FormFactoryInterface::class);
        $formFactory->method('create')->willReturn($form);
        $userHandler->setFormFactory($formFactory);
        $request = Request::create("/");

        $this->assertTrue($userHandler->handle($request, new User()));


    }

}