<?php
/**
 * Register fixture.
 */

namespace App\DataFixtures;

use App\Entity\Register;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class RegisterFixtures.
 */
class RegisterFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(15, 'registers', function ($i) {
            $register = new Register();
            $register->setTitle($this->faker->word);
            $register->setCategory($this->getRandomReference('categories'));
            return $register;
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
