<?php

namespace App\Repository;

use App\Entity\PersonalTask;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PersonalTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalTask[]    findAll()
 * @method PersonalTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalTaskRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Task::class);
        $this->manager = $manager;
    }

    public function savePersonalTask($name, $userName, $difficulty, $value, $taskId)
    {
        $newPersonalTask = new PersonalTask();

        $newPersonalTask
            ->setName($name)
            ->setValue($value)
            ->setDifficulty($difficulty)
            ->setUser($userName)
            ->setTask($taskId);

        $this->manager->persist($newPersonalTask);
        $this->manager->flush();
    }

}
