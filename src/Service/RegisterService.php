<?php
/**
 * Register service.
 */

namespace App\Service;

use App\Entity\Register;
use App\Entity\User;
use App\Repository\RegisterRepository;
use Doctrine\Common\Collections\Collection;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class RegisterService.
 */
class RegisterService
{
    /**
     * Register repository.
     *
     * @var \App\Repository\RegisterRepository
     */
    private $registerRepository;

    /**
     * Paginator.
     *
     * @var \Knp\Component\Pager\PaginatorInterface
     */
    private $paginator;

    /**
     * Category service.
     *
     * @var \App\Service\CategoryService
     */
    private $categoryService;

    /**
     * RegisterService constructor.
     *
     * @param \App\Repository\RegisterRepository      $registerRepository Register repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator          Paginator
     * @param \App\Service\CategoryService            $categoryService Category service
     */
    public function __construct(RegisterRepository $registerRepository, PaginatorInterface $paginator, CategoryService $categoryService)
    {
        $this->registerRepository = $registerRepository;
        $this->paginator = $paginator;
        $this->categoryService = $categoryService;
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
        if (isset($filters['category_id']) && is_numeric($filters['category_id'])) {
            $category = $this->categoryService->findOneById(
                $filters['category_id']
            );
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        return $resultFilters;
    }

    /**
     * Create paginated list.
     *
     * @param int                                                 $page    Page number
     * @param \Symfony\Component\Security\Core\User\UserInterface $user    User entity
     * @param array                                               $filters Filters array
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface Paginated list
     */
    public function createPaginatedList(int $page, UserInterface $user, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->registerRepository->queryByAuthor($user, $filters),
            $page,
            RegisterRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save register.
     *
     * @param \App\Entity\Register $register Register entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Register $register): void
    {
        $this->registerRepository->save($register);
    }

    /**
     * Delete register.
     *
     * @param \App\Entity\Register $register Register entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Register $register): void
    {
        $this->registerRepository->delete($register);
    }

    /**
     * Find register by Id.
     *
     * @param int $id Register Id
     *
     * @return \App\Entity\Register|null Register entity
     */
    public function findOneById(int $id): ?Register
    {
        return $this->registerRepository->findOneById($id);
    }


    /**
     * @param User $user
     * @return Register[]
     */
    public function findByAuthor(User $user): array
    {
        return $this->registerRepository->findByAuthor($user);
    }
}
