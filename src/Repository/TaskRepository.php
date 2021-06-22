<?php
/**
 * Task repository.
 */

namespace App\Repository;

use App\Entity\Task;
use App\Entity\Register;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * Class TaskRepository.
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
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
    const PAGINATOR_ITEMS_PER_PAGE = 10;



//    /**
//     * TaskRepository constructor.
//     *
//     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
//     */
//    public function __construct(ManagerRegistry $registry)
//    {
//        parent::__construct($registry, Task::class);
//    }


    /**
     * TaskRepository constructor.
     *
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry Manager registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }
    /**
     * Query all records.
     * @param array $filters
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial task.{id, content, priority, deadline}',
                'partial register.{id, title}'
            )
            ->join('task.register', 'register')
            ->orderBy('task.deadline', 'DESC');
        $queryBuilder = $this->applyFiltersToList($queryBuilder, $filters);

//        if(array_key_exists('register_id',$filters) && $filters['register_id'] > 0 ) {
//            $qb->where('task.register = :register_id')
//                ->setParameter('register_id', $filters ['register_id']);
//        }


        return $queryBuilder;
    }

//    /**
//     * Query tasks by register.
//     *
//     * @param \App\Entity\Register $register    Register entity
//     * @param array            $filters Filters array
//     *
//     * @return \Doctrine\ORM\QueryBuilder Query builder
//     */
//    public function queryByRegister(array $filters = []): QueryBuilder
//    {
//        $queryBuilder = $this->queryAll($filters);
//
//        $queryBuilder->andWhere('task.register = :register')
//            ->setParameter('register', $register);
//
//        return $queryBuilder;
//    }

    /**
     * Apply filters to paginated list.
     *
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder Query builder
     * @param array                      $filters      Filters array
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function applyFiltersToList(QueryBuilder $queryBuilder, array $filters = []): QueryBuilder
    {
        if (isset($filters['register']) && $filters['register'] instanceof Register) {
            $queryBuilder->andWhere('register = :register')
                ->setParameter('register', $filters['register']);
        }

        return $queryBuilder;
    }

    /**
     * Get or create new query builder.
     *
     * @param \Doctrine\ORM\QueryBuilder|null $queryBuilder Query builder
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null): QueryBuilder
    {
        return $queryBuilder ?? $this->createQueryBuilder('task');
    }

    public function save(Task $task): void
    {
        $this->_em->persist($task);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Task $task Task entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Task $task): void
    {
        $this->_em->remove($task);
        $this->_em->flush();
    }
}

