<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Task::class);
        $this->manager = $manager;
    }

    public function saveTask($name, $positive, $easy, $medium, $hard, $description)
    {
        $newTask = new Task();

        $newTask
            ->setName($name)
            ->setPositive($positive)
            ->setEasy($easy)
            ->setMedium($medium)
            ->setHard($hard)
            ->setDescription($description);

        $this->manager->persist($newTask);
        $this->manager->flush();
    }

    public function updateTask(Task $task): Task
    {
        $this->manager->persist($task);
        $this->manager->flush();

        return $task;
    }

    public function removeTask(Task $task)
    {
        $this->manager->remove($task);
        $this->manager->flush();
    }
}
