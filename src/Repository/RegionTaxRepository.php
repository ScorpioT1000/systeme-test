<?php
namespace App\Repository;

use App\Entity\RegionTax;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method RegionTax|null find($id, $lockMode = null, $lockVersion = null)
 * @method RegionTax|null findOneBy(array $criteria, array $orderBy = null)
 * @method RegionTax[]    findAll()
 * @method RegionTax[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RegionTaxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RegionTax::class);
    }   
}