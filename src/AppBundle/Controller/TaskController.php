<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use AppBundle\Handler\TaskHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    const SUCCESS = 'success';
    const TASK_LIST = 'task_list';

    /**
     * @Route("/tasks/list/{toggle}", name="task_list")
     * @param int $toggle
     * @return Response
     */
    public function listAction($toggle = 0)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render(
            'task/list.html.twig',
            [
                'tasks' => $this->getDoctrine()
                    ->getRepository('AppBundle:Task')
                    ->findBy(['isDone' => $toggle])
            ]
        );
    }

    /**
     * @Route("/tasks/create", name="task_create")
     * @param Request $request
     * @param TaskHandler $taskHandler
     * @return Response
     */
    public function newAction(Request $request, TaskHandler $taskHandler)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($taskHandler->handle($request, new Task())) {
            return $this->redirectToRoute(self::TASK_LIST);
        }

        return $this->render('task/create.html.twig', [
            'form' => $taskHandler->createView()
        ]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     * @param Task $task
     * @param Request $request
     * @param TaskHandler $taskHandler
     * @return Response
     */
    public function editAction(Task $task, Request $request, TaskHandler $taskHandler)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($taskHandler->handle($request, $task)) {
            return $this->redirectToRoute(self::TASK_LIST);
        }

        return $this->render('task/edit.html.twig', [
            'form' => $taskHandler->createView(),
            'task' => $task
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     * @param Task $task
     * @return RedirectResponse
     */
    public function toggleTaskAction(Task $task)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash(self::SUCCESS, sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute(self::TASK_LIST);
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     * @param Task $task
     * @return RedirectResponse
     */
    public function deleteTaskAction(Task $task)
    {
        $this->denyAccessUnlessGranted('delete', $task);

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash(self::SUCCESS, 'La tâche a bien été supprimée.');

        return $this->redirectToRoute(self::TASK_LIST);
    }
}
