<?php

namespace AppBundle\Handler;

use AppBundle\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class TaskHandler extends AbstractHandler
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * TrickHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param FlashBagInterface $flashBag
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag,
        TokenStorageInterface $tokenStorage
    ) {
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Donne le type de formulaire
     * @return string
     */
    protected function getFormType()
    {
        return TaskType::class;
    }

    /**
     * @param null $param
     */
    protected function process($param = null)
    {
        if ($this->entityManager->getUnitOfWork()->getEntityState($this->data) === UnitOfWork::STATE_NEW) {
            $this->flashBag->add('success', 'La taĉhe a bien été ajouté');
            $this->data->setUser($this->tokenStorage->getToken()->getUser());
            $this->entityManager->persist($this->data);
        } else {
            $this->flashBag->add('success', 'La taĉhe a bien été modifié');
            $this->entityManager->persist($this->data);
        }
        $this->entityManager->flush();
    }
}
