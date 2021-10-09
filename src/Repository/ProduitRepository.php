<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Model\Filter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function getAvecCategories(Filter  $filter)
    {
        $qb = $this->createQueryBuilder('p');
        // On fait une jointure avec l'entité Categorie, avec pour alias « c »
        $qb ->join('p.Categorie', 'c')
            ->where($qb->expr()->in('c.name', $filter)); // Puis on filtre sur le nom des catégories à l'aide d'un IN
        // Enfin, on retourne le résultat
        return $qb->getQuery()
            ->getResult();
    }

    public function getPaginatorProduit(int $page, int $length){
        $queryBuilder= $this->createQueryBuilder('p')
            //->join('p.Categorie', 'c')
            ->orderBy('p.createdAt','desc')
            ->setFirstResult(($page - 1) * $length)
            ->setMaxResults($length)
        ;
        return  $queryBuilder->getQuery()->getResult();
    }
    public function coutProd(){
        return $this->createQueryBuilder('p')
            ->select('COUNT(p.id)')
            ->getQuery()
            ->getScalarResult()
        ;

    }

    public function getFilterProd(Filter $filter)
    {
        $queryBuilder =  $this->createQueryBuilder('p');
            if($filter !== null ){
                $queryBuilder->where('p.Categorie = :categories')
                    ->setParameter('categories',$filter->getCategories())
                ;

            }
        if($filter->getKeyWord() !== null ) {
            $queryBuilder
                ->andWhere('p.designation LIKE :keyWord')
                ->setParameter('keyWord', '%' . $filter->getKeyWord() . '%');
        }

         return $queryBuilder->getQuery()->getResult();


            }

    // /**
    //  * @return Produit[] Returns an array of Produit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Produit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
