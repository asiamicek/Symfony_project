<?php

namespace App\Repository;

use App\Entity\Task;


/**
 * Class TaskRepository.
 */
class TaskRepository
{
    /**
     * Items per page.
     *
     * Use constants to define configuration options that rarely change instead
     * of specifying them in app/config/config.yml.
     * See https://symfony.com/doc/current/best_practices.html#configuration
     *
     * @constant int
     */
    const PAGINATOR_ITEMS_PER_PAGE = 3;

    /**
     * Data.
     *
     * @var array
     */
    private $data = [
        1 => [
            'id' => 1,
            'content' => 'Pick up a kitten from the cat`s kindergarten and buy him a treat.',
            'priority' => 3,
            'createdAt'=> '18-04-2021',
            'deadline' => '19-04-2021',
        ],
        2 => [
            'id' => 2,
            'content' => 'Buy diesel fuel and replace the coolant.',
            'priority' => 1,
            'createdAt'=> '10-02-2021',
            'deadline' => '27-06-2021',
        ],
        3 => [
            'id' => 3,
            'content' => 'Bake an apple pie for Grandma`s visit.',
            'priority' => 5,
            'createdAt'=> '16-04-2021',
            'deadline' => '21-05-2021',
        ],
        4 => [
            'id' => 4,
            'content' => 'To pack a baby for an educational trip.',
            'priority' => 2,
            'createdAt'=> '01-04-2021',
            'deadline' => '21-05-2021',
        ],
        5 => [
            'id' => 5,
            'content' => 'Wash uncle Kazio`s car.',
            'priority' => 1,
            'createdAt'=> '11-05-2021',
            'deadline' => '26-05-2021',
        ],
        6 => [
            'id' => 6,
            'content' => 'Write an essay on the influence of spaghetti on ancient culture.',
            'priority' => 5,
            'createdAt'=> '16-04-2021',
            'deadline' => '31-05-2021',
        ],
        7 => [
            'id' => 7,
            'content' => 'Paint a picture of Vangogh in the bathtub.',
            'priority' => 3,
            'createdAt'=> '06-01-2021',
            'deadline' => '21-06-2021',
        ],
        8 => [
            'id' => 8,
            'content' => 'Install new extensions for the Sims.',
            'priority' => 2,
            'createdAt'=> '11-03-2021',
            'deadline' => '24-07-2021',
        ],
        9 => [
            'id' => 9,
            'content' => 'Sell Opel fast and expensive.',
            'priority' => 1,
            'createdAt'=> '15-04-2021',
            'deadline' => '02-06-2021',
        ],
        10 => [
            'id' => 10,
            'content' => 'Choose a dress and shoes for a date with John.',
            'priority' => 4,
            'createdAt'=> '06-02-2021',
            'deadline' => '20-05-2021',
        ],
    ];
    /**
     * Find all.
     *
     * @return array Result
     */
    public function findAll(): array
    {
        return $this->data;
    }

    /**
     * Find one by Id.
     *
     * @param int $id Id
     *
     * @return array|null Result
     */
    public function findById(int $id): ?array
    {
        return isset($this->data[$id]) && count($this->data)
            ? $this->data[$id] : null;
    }
}
