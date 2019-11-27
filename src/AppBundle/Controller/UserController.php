<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Handler\UserHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    /**
     * @Route("/admin/users", name="user_list")
     */
    public function listAction()
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render(
            'user/list.html.twig',
            ['users' => $this->getDoctrine()->getRepository('AppBundle:User')->findAll()]
        );
    }

    /**
     * @Route("/users/create", name="user_create")
     */
    public function createAction(Request $request, UserHandler $userHandler)
    {
        if ($userHandler->handle($request, new User())) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('user/create.html.twig', ['form' => $userHandler->createView()]);
    }

    /**
     * @Route("/admin/users/{id}/edit", name="user_edit")
     */
    public function editAction(User $user, Request $request, UserHandler $userHandler)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        if ($userHandler->handle($request, $user)) {
            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', ['form' => $userHandler->createView(), 'user' => $user]);
    }
}
