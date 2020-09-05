<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    /**
     * @Route("/tasks", name="add_task", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];
        $positive = $data['positive'];
        $easy = $data['easy'];
        $medium = $data['medium'];
        $hard = $data['hard'];
        $description = $data['description'];

        if (empty($name) || empty($easy) || empty($medium) || empty($hard)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->taskRepository->saveTask($name, $positive, $easy, $medium, $hard, $description);

        return new JsonResponse(['status' => 'Task Created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/tasks/{id}", name="get_one_task", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function get($id): JsonResponse
    {
        $task = $this->taskRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $task->getId(),
            'name' => $task->getName(),
            'positive' => $task->getPositive(),
            'easy' => $task->getEasy(),
            'medium' => $task->getMedium(),
            'hard' => $task->getHard(),
            'description' => $task->getDescription()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/tasks", name="get_all_tasks", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $customers = $this->taskRepository->findAll();
        $data = [];

        foreach ($customers as $task) {
            $data[] = [
                'name' => $task->getName(),
                'positive' => $task->getPositive(),
                'easy' => $task->getEasy(),
                'medium' => $task->getMedium(),
                'hard' => $task->getHard(),
                'description' => $task->getDescription()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/tasks/{id}", name="update_task", methods={"PUT"})
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request): JsonResponse
    {
        $task = $this->taskRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $task->setName($data['name']);
        empty($data['positive']) ? true : $task->setPositive($data['positive']);
        empty($data['easy']) ? true : $task->setEasy($data['easy']);
        empty($data['medium']) ? true : $task->setMedium($data['medium']);
        empty($data['hard']) ? true : $task->setHard($data['hard']);
        empty($data['description']) ? true : $task->setDescription($data['description']);


        $updatedCostumer = $this->taskRepository->updateTask($task);

        return new JsonResponse($updatedCostumer->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/tasks/{id}", name="delete_task", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $task = $this->taskRepository->findOneBy(['id' => $id]);

        $this->taskRepository->removeTask($task);

        return new JsonResponse(['status' => 'Customer deleted'], Response::HTTP_NO_CONTENT);
    }
}

