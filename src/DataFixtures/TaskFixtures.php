<?php
/**
 * Task fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TaskFixtures.
 */
class TaskFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(100, 'tasks', function ($i) {
            $task = new Task();
            $task->setContent($this->faker->text($maxNbChars = 50));
            $task->setPriority($this->faker->numberBetween($min = 1, $max = 5));
            $task->setDeadline($this->faker->dateTimeBetween('-100 days', '+15 days'));
            $task->setRegister($this->getRandomReference('registers'));

            return $task;
        });

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
