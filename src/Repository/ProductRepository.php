<?php
namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository{

    public function getProduct(){

        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('p')
            ->from(Product::class, 'p');

        $query = $qb->getQuery();

        return $query->getResult();
    }
}