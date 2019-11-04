<?php


namespace AppBundle\Security;


use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class DeleteVoter extends Voter
{
    protected function supports($attribute, $subject)
    {

        if (!($attribute === 'delete')) {
            return false;
        }

        if (!$subject instanceof Task) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        if ($user === $subject->getUser()) {
            return true;
        }

        return false;
    }

}