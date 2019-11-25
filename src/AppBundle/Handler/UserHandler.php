<?php

namespace AppBundle\Handler;

use AppBundle\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserHandler extends AbstractHandler
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

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
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        FlashBagInterface $flashBag,
        UserPasswordEncoderInterface $userPasswordEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->flashBag = $flashBag;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * Donne le type de formulaire
     * @return string
     */
    protected function getFormType()
    {
        return UserType::class;
    }

    /**
     * @param null $param
     */
    protected function process($param = null)
    {
        if ($this->entityManager->getUnitOfWork()->getEntityState($this->data) === UnitOfWork::STATE_NEW) {
            $this->flashBag->add('success', 'L\'utilisateur a bien été ajouté.');
            $this->data->setRoles(['ROLE_USER']);
            $this->data->setPassword(
                $this->userPasswordEncoder->encodePassword($this->data, $this->data->getPassword())
            );
            $this->entityManager->persist($this->data);
        } else {
            $this->flashBag->add('success', 'L\'utilisateur a bien été modifié.');
            $this->data->setPassword(
                $this->userPasswordEncoder->encodePassword($this->data, $this->data->getPassword())
            );
            $this->entityManager->persist($this->data);
        }
        $this->entityManager->flush();
    }
}
