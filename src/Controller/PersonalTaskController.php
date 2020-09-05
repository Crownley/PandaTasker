<?php

namespace App\Controller;

use App\Repository\PersonalTaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\TaskRepository;

class PersonalTaskController extends AbstractController
{
    private $personalTaskRepository;
    private $taskRepository;

    public function __construct(PersonalTaskRepository $personalTaskRepository, TaskRepository $taskRepository)
    {
        $this->personalTaskRepository = $personalTaskRepository;
        $this->taskRepository = $taskRepository;
    }

    // HAVE TO FIX THE ROUTING IN FUTURE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    /**
     * @Route("/personaltasks", name="add_personal_task", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $taskId = $data['taskId'];
        $difficulty = $data['difficulty'];
        var_dump($difficulty);

        if (empty($difficulty) || empty($taskId)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $task = $this->taskRepository->findOneBy(['id' => $taskId]);

        $user = $this->getUser();
        $userName = $user;
        $name = $task->getName();
        if ($difficulty == "easy") {
            $value = $task->getEasy();
        } else if ($difficulty == "medium") {
            $value = $task->getMedium();
        } else if ($difficulty == "hard") {
            $value = $task->getHard();
        }

        $this->personalTaskRepository->savePersonalTask($name, $userName, $difficulty, $value, $task);

        return new JsonResponse(['status' => 'Customer created!'], Response::HTTP_CREATED);
    }
}
