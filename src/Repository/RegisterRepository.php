<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Register;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Registry;

/**
 * @method Register|null find($id, $lockMode = null, $lockVersion = null)
 * @method Register|null findOneBy(array $criteria, array $orderBy = null)
 * @method Register[]    findAll()
 * @method Register[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegisterRepository extends ServiceEntityRepository
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

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Register::class);
    }

    // /**
    //  * @return Register[] Returns an array of Register objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Register
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * Save record.
     *
     * @param \App\Entity\Register $register Register entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Register $register): void
    {
        $this->_em->persist($register);
        $this->_em->flush();
    }

    /**
     * Delete record.
     *
     * @param \App\Entity\Register $register Register entity
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Register $register): void
    {
        $this->_em->remove($register);
        $this->_em->flush();
    }

//    public function TitleByAuthor(User $user): QueryBuilder
//    {
//
//        $qb = $this-> queryAll($filters)
//        $qb->andWhere('register.author = :author')
//            ->setParameter('author', $user);
//
//        return $qb;
//    }


    /**
     * Query all records.
     *
     * @param array $filters Filters array
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryAll(array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->select(
                'partial register.{id, title}',
                'partial category.{id, title}',

            )
            ->join('register.category', 'category')
            ->orderBy('register.id', 'DESC');
        $queryBuilder = $this->applyFiltersToList($queryBuilder, $filters);

        return $queryBuilder;
    }


    /**
     * Query register by author.
     *
     * @param \App\Entity\User $user    User entity
     * @param array            $filters Filters array
     *
     * @return \Doctrine\ORM\QueryBuilder Query builder
     */
    public function queryByAuthor(User $user, array $filters = []): QueryBuilder
    {
        $queryBuilder = $this->queryAll($filters);
        $queryBuilder->andWhere('register.author = :author')
            ->setParameter('author', $user);

        return $queryBuilder;
    }

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
        if (isset($filters['category']) && $filters['category'] instanceof Category) {
            $queryBuilder->andWhere('category = :category')
                ->setParameter('category', $filters['category']);
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
        return $queryBuilder ?? $this->createQueryBuilder('register');
    }

    /**
     * @param User $user
     * @return Collection|null
     */
    public function findByAuthor(User $user): ?Collection
    {

        $queryBuilder = $this->getOrCreateQueryBuilder()
            ->andWhere('register.author = :user')
            ->setParameter('user', $user);

        return $queryBuilder->getQuery()->getResult();

    }

//    /**
//     * @param User $user
//     * @return int|mixed|string|object
//     */
//    public function TitleByAuthor(User $user)
//    {
//
//        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
//        $queryBuilder
//            ->select(['register.title'])
//            ->from(Register::class, 'register')
//            ->andWhere('register.author = :user')
//            ->setParameter('user', $user);
//
//        $result = $queryBuilder->getQuery()->getResult();
//
//        return $result;
//
//    }

//        $result = $queryBuilder->getQuery()->getResult();
//
//        return $result;
//    }

}
