<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table("user")
 * @ORM\Entity
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Email(message="Le format de l'adresse n'est pas correcte.")
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Task", mappedBy="user")
     */
    private $tasks;

    /**
     * @ORM\Column(type="array")
     */
    private $roles=[];

    /**
     * Task constructor.
     */
    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ArrayCollection
     */
    public function getChats()
    {
        return $this->tasks;
    }

    /**
     * @param Task $tasks
     * @return User
     */
    public function addChat(Task $tasks)
    {
        if (!$this->tasks->contains($tasks)) {
            $this->tasks[] = $tasks;
            $tasks->setUser($this);
        }

        return $this;
    }

    /**
     * @param Task $tasks
     * @return User
     *
     */
    public function removeChat(Task $tasks)
    {
        if ($this->tasks->contains($tasks)) {
            $this->tasks->removeElement($tasks);
            // set the owning side to null (unless already changed)
            if ($tasks->getUser() === $this) {
                $tasks->setUser(null);
            }
        }

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }
}
