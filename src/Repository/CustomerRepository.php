<?php
namespace App\Repository;

use App\Entity\Customer;
use Doctrine\ORM\EntityRepository;

class CustomerRepository extends EntityRepository{

    public function authenCustomer($email)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select("c")
            ->from(Customer::class, "c")
            ->where("c.email = ?1")
            ->setParameter(1, $email);

        $query = $qb->getQuery();

        return $query->getSingleResult();
    }

    public function updateCustomer($id, $sexe, $pseudo, $full_name, $adresse_facturation, $adresse_livraison, $telephone, $email,)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->update(Customer::class, "c")
            ->set("c.sexe", "?2")
            ->set("c.pseudo", "?3")
            ->set("c.full_name", "?4")
            ->set("c.adresse_facturation", "?5")
            ->set("c.adresse_livraison", "?6")
            ->set("c.telephone", "?7")
            ->set("c.email", "?8")
            ->where("c.id = ?1")
            ->setParameter(1, $id)
            ->setParameter(2, $sexe)
            ->setParameter(3, $pseudo)
            ->setParameter(4, $full_name)
            ->setParameter(5, $adresse_facturation)
            ->setParameter(6, $adresse_livraison)
            ->setParameter(7, $telephone)
            ->setParameter(8, $email);


        $query = $qb->getQuery();

        $query->execute();
    }

    public function getCustomerById($id)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select("c")
            ->from(Customer::class, "c")
            ->where("c.id = ?1")
            ->setParameter(1, $id);

        $query = $qb->getQuery();

        return $query->getSingleResult();
    }
}