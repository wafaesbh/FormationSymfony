<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Response;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * Get all products with a quantity higher than 0
     * @return mixed
     */
    public function getProductWithHeigherQuantity(int $min = -1 , int $max = -1)
    {
        $queryBuilder = $this->createQueryBuilder('p');
        if($min > 0){
            $queryBuilder->where('p.quantity > :min')
                        ->setParameter('min' , $min);
        }
        if($max > 0){
            $queryBuilder->where('p.quantity > :max')
                ->setParameter('max' , $max);
        }
        return $queryBuilder
                ->getQuery()
                ->getResult();


    }
    public function getRelatedProducts(Product $product):array
    {
        $stmt = $this->getEntityManager()
                     ->prepare('SELECT * FROM product where id in {
                                    select product_id from category_product 
                                    where category_id
                                        IN {
                                            SELECT category_id FROM category_product WHERE product_id = :p))'
                        );

        $stmt->excute([
            'p' => $product->getId(),
        ]);
        return $stmt->fetchAllAssociative();
    }

    /**
     * @Route("/search" , name ="search")
     * @param string $term
     * @return int|mixed|string
     */
    public function search(string $term)
    {
        $qb = $this->createQueryBuilder('p');
        $expr = $qb->expr();

        return $qb->where(
            $expr->like('p.label' ,$expr->literal('%'.$term.'%'))
        )
           // ->setParameter('t' , $term)
            ->getQuery()
            ->getResult();
    }

}
