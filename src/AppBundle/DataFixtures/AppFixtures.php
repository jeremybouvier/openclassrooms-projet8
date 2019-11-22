<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var array
     */
    private $tasks;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * AppFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Modèle de construction de données utilisateurs en base de donnée
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $this->loadTask($manager);
        $this->loadUsers($manager);
        $manager->flush();
    }

    /**
     * Création des utilisateurs
     * @param $manager
     */
    public function loadUsers($manager)
    {
        $this->setUser($manager, 'admin');
        for ($i = 0; $i < 10; $i++) {
            $this->setUser($manager, 'user', $i);
        }
    }

    private function setUser($manager, $name , $i = null)
    {
        $user = new User();
        $user->setUserName($name.$i);
        $user->setEmail($name.$i.'@gmail.com');
        $user->setPassword($this->encoder->encodePassword($user,$name.$i));
        if ($name=='admin') {
            $user->setRoles(['ROLE_ADMIN']);
        }
        else {
            $user->setRoles(['ROLE_USER']);
        }
        $this->loadTask($manager, $user);
        $manager->persist($user);

    }

    /**
     * Création des tâches
     * @param $manager
     */
    private function loadTask($manager, $user = null)
    {
        for ($i = 0; $i < 10; $i++) {
            $task = new Task();
            $task->setTitle('task'.$i);
            $task->setContent('task'.$i);
            if ($user) {
                $user->addChat($task);
            }
            $manager->persist($task);
        }
    }
}