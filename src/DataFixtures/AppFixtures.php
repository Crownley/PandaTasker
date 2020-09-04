<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $task = new Task();
            $task->setName($faker->realText($maxNbChars = 50, $indexSize = 2));
            $task->setPositive($faker->boolean($chanceOfGettingTrue = 50));
            $task->setEasy($faker->numberBetween($min = 5, $max = 100));
            $task->setmedium($faker->numberBetween($min = 101, $max = 200));
            $task->setHard($faker->numberBetween($min = 201, $max = 300));
            $task->setDescription($faker->text($maxNbChars = 200));
            $manager->persist($task);
        }

        $manager->flush();
    }
}
