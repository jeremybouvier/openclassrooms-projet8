<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use AppBundle\Handler\TaskHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends Controller
{
    /**
     * @Route("/tasks/list/{toggle}", name="task_list")
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
     */
    public function newAction(Request $request, TaskHandler $taskHandler)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($taskHandler->handle($request, new Task())) {
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', [
            'form' => $taskHandler->createView()
        ]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request, TaskHandler $taskHandler)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($taskHandler->handle($request, $task)) {
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $taskHandler->createView(),
            'task' => $task
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task)
    {
        $this->denyAccessUnlessGranted('delete', $task);

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
