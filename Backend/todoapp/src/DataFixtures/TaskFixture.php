<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
            
        for ($i =1; $i <= 10; $i++ ){
            $task = new Task();
            $task->setTitle("Tâche n°$i")
            ->setStatus("En cours")
            ->setPriority("Haute")
            ->setTaskDate(new \DateTime())
            ->setCreatedAt((new \DateTime()));
            
            $manager->persist($task); // Prépare à persister dans le temps

        }

        $manager->flush(); // Aplique dans la BDD
    }
}
