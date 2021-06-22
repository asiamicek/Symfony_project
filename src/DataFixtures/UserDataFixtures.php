<?php
/**
 * UserData fixtures.
 */

namespace App\DataFixtures;

use App\Entity\UserData;
use Doctrine\Persistence\ObjectManager;

/**
 * Class UserDataFixtures.
 */
class UserDataFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(7, 'usersdata', function ($i) {
            $userdata = new UserData();
            $userdata->setFirstName($this->faker->name);
            $userdata->setLastName($this->faker->lastName);

            return $userdata;
        });

        $manager->flush();
    }
}
