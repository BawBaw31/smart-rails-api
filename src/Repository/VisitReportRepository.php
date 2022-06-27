<?php

namespace App\Repository;

use App\Entity\VisitReport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VisitReport>
 *
 * @method VisitReport|null find($id, $lockMode = null, $lockVersion = null)
 * @method VisitReport|null findOneBy(array $criteria, array $orderBy = null)
 * @method VisitReport[]    findAll()
 * @method VisitReport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VisitReportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VisitReport::class);
    }

    public function add(VisitReport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VisitReport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @override
     * @return VisitReport[]
     */
    public function findAll() {
        return $this->findBy(array(), array('createdAt' => 'DESC'));
    }

//    /**
//     * @return VisitReport[] Returns an array of VisitReport objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VisitReport
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
