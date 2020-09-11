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
        parent::__construct($registry, PersonalTask::class);
        $this->manager = $manager;
    }

    public function savePersonalTask($name, $user, $difficulty, $value, $taskId)
    {
        $newPersonalTask = new PersonalTask();

        $newPersonalTask
            ->setName($name)
            ->setValue($value)
            ->setDifficulty($difficulty)
            ->setUser($user)
            ->setTask($taskId);

        $this->manager->persist($newPersonalTask);
        $this->manager->flush();
    }

    public function updatePersonalTask(PersonalTask $personalTask): PersonalTask
    {
        $this->manager->persist($personalTask);
        $this->manager->flush();

        return $personalTask;
    }
    public function removePersonalTask(PersonalTask $personalTask)
    {
        $this->manager->remove($personalTask);
        $this->manager->flush();
    }

}
