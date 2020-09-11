<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PersonalTaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PersonalTaskController extends AbstractController
{
    private $personalTaskRepository;
    private $taskRepository;
    private $userRepository;
    public function __construct(PersonalTaskRepository $personalTaskRepository, TaskRepository $taskRepository, UserRepository $userRepository)
    {
        $this->personalTaskRepository = $personalTaskRepository;
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/{u}/tasks", name="add_personal_task", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function add(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $taskId = $data['taskId'];
        $difficulty = $data['difficulty'];

        if (empty($difficulty) || empty($taskId)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $task = $this->taskRepository->findOneBy(['id' => $taskId]);
        $name = $task->getName();

        if ($difficulty == "easy") {
            $value = $task->getEasy();
        } else if ($difficulty == "medium") {
            $value = $task->getMedium();
        } else if ($difficulty == "hard") {
            $value = $task->getHard();
        }

        $user = $this->getUser();

        $this->personalTaskRepository->savePersonalTask($name, $user, $difficulty, $value, $task);

        return new JsonResponse(['status' => 'Personal Task created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/{u}/tasks/{id}", name="get_one_personal_task", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function get($id): JsonResponse
    {
        $personalTask = $this->personalTaskRepository->findOneBy(['id' => $id]);

        $data = [
            'value' => $personalTask->getValue(),
            'name' => $personalTask->getName(),
            'difficulty' => $personalTask->getDifficulty()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/{u}/tasks", name="get_all_personal_tasks", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function getAll($u): JsonResponse
    {
        $author = $this->userRepository->findOneBy(['username' => $u])->getId();

        $personalTasks = $this->personalTaskRepository->findBy(['user' => $author]);
        $data = [];


            foreach ($personalTasks as $personalTask) {

                    $data[] = [
                        'value' => $personalTask->getValue(),
                        'name' => $personalTask->getName(),
                        'difficulty' => $personalTask->getDifficulty()
                    ];
            }
            return new JsonResponse($data, Response::HTTP_OK);


    }

    /**
     * @Route("/{u}/tasks/{id}", name="update_personal_task", methods={"PUT"})
     * @IsGranted("ROLE_USER")
     */
    public function update($id, Request $request): JsonResponse
    {
        $personalTask = $this->personalTaskRepository->findOneBy(['id' => $id]);

        $taskId = $personalTask->getTask();
        $task = $this->taskRepository->findOneBy(['id' => $taskId]);
        $data = json_decode($request->getContent(), true);

        empty($data['difficulty']) ? true : $personalTask->setDifficulty($data['difficulty']);

        if ($data['difficulty'] == "easy") {
            $value = $task->getEasy();
        } else if ($data['difficulty'] == "medium") {
            $value = $task->getMedium();
        } else if ($data['difficulty'] == "hard") {
            $value = $task->getHard();
        }

        $personalTask->setValue($value);
        $updatedPersonalTask = $this->personalTaskRepository->updatePersonalTask($personalTask);

        return new JsonResponse($updatedPersonalTask->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/{u}/tasks/{id}", name="delete_personal_task", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete($id): JsonResponse
    {
        $personalTask = $this->personalTaskRepository->findOneBy(['id' => $id]);

        $this->personalTaskRepository->removePersonalTask($personalTask);

        return new JsonResponse(['status' => 'Your task has been deleted'], Response::HTTP_NO_CONTENT);
    }

}