<?php
/**
 * Task service.
 */

namespace App\Service;

use App\Entity\Task;
use App\Entity\Register;
use App\Repository\TaskRepository;
use App\Repository\RegisterRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Class TaskService.
 */
class TaskService
{
    /**
     * Task repository.
     *
     * @var \App\Repository\TaskRepository
     */
    private $taskRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * Register service.
     *
     * @var \App\Service\RegisterService
     */
    private $registerService;

    /**
     * TaskService constructor.
     *
     * @param \App\Repository\TaskRepository      $taskRepository Task repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator          Paginator
     * @param \App\Service\RegisterService $registerService Register service
     */
    public function __construct(TaskRepository $taskRepository, PaginatorInterface $paginator, RegisterService $registerService)
    {
        $this->taskRepository = $taskRepository;
        $this->paginator = $paginator;
        $this->registerService = $registerService;
    }

    /**
     * Prepare filters for the tasks list.
     *
     * @param array $filters Raw filters from request
     *
     * @return array Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (isset($filters['register_id']) && is_numeric($filters['register_id'])) {
            $register = $this->registerService->findOneById(
                $filters['register_id']
            );
            if (null !== $register) {
                $resultFilters['register'] = $register;
            }
        }

        return $resultFilters;
    }

    /**
     * Create paginated list.
     *
     * @param int $page Page number
     * @param UserInterface $user
     * @param array $filters Filters array
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, UserInterface $user, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->taskRepository->queryByAuthor($user, $filters),
            $page,
            TaskRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
//    public function createPaginatedList(int $page, RegisterRepository $registerRepository, array $filters = []): PaginationInterface
//    {
//        $filters = $this->prepareFilters($filters);
//
//        return $this->paginator->paginate(
//                $this->registerRepository->getTasks(),
//        //    $this->taskRepository->queryByRegister($register, $filters),
//            $page,
//            TaskRepository::PAGINATOR_ITEMS_PER_PAGE
//        );
//    } [ @param \App\Repository\RegisterRepository registerRepository    RegisterRepository ]

    /**
     * Save task.
     *
     * @param \App\Entity\Task $task Task entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Task $task): void
    {
        $this->taskRepository->save($task);
    }

    /**
     * Delete task.
     *
     * @param \App\Entity\Task $task Task entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Task $task): void
    {
        $this->taskRepository->delete($task);
    }
}
