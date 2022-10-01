<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\PaginationResult;
use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 *
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    public function save(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Book $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function paginate(int $page = 1, int $step = 15)
    {
        $query = $this->createQueryBuilder('book');

        $paginationQuery = (new Paginator(clone $query))
            ->getQuery()
            ->setFirstResult($step * ($page - 1))
            ->setMaxResults($step);

        $totalItems = $query
            ->select('count(book.id)')
            ->getQuery()
            ->getResult()[0][1];

        return new PaginationResult(
            page: $page,
            step: $step,
            totalItems: $totalItems,
            totalPages: (int) ceil($totalItems / $step),
            items: $paginationQuery->getResult(),
        );
    }
}
