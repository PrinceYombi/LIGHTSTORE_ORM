<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


#[ORM\Entity(repositoryClass : "App\Repository\CustomerRepository")]
#[ORM\Table(name : "customers")]
class Customer
{
    
     #[ORM\Id]
     #[ORM\Column(type :'integer')]
     #[ORM\GeneratedValue]
    private $id;
   
    #[ORM\Column(type :'string', nullable : true)]
    private $sexe;

    #[ORM\Column(type :'string', nullable : true)]
    private $pseudo;
   
    #[ORM\Column(type :'string', nullable : true)]
    private $full_name;

    #[ORM\Column(type :'string', nullable : true)]
    private $adresse_facturation;

    #[ORM\Column(type :'string', nullable : true)]
    private $adresse_livraison;

    #[ORM\Column(type :'integer', nullable : true)]
    private $telephone;
  
    #[ORM\Column(type :'string')]
    private $email;

    #[ORM\Column(type :'string')]
    private $password;

    #[ORM\Column(type :'datetime')]
    private $created_at;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: "customer")]
    private $orders;


    public function __construct(){

        $this->created_at = new \DateTime(); //Iniatilisation du temps
        $this->orders = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getSexe()
    {
        return $this->sexe;
    }

    public function setSexe($sexe): self
    {
        $this->sexe = $sexe;
        return $this;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo): self
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    
    public function getFullName()
    {
        return $this->full_name;
    }

    public function setFullName($full_name): self
    {
        $this->full_name = $full_name;
        return $this;
    }

    public function getAdresseFacturation()
    {
        return $this->adresse_facturation;
    }

    public function setAdresseFacturation($adresse_facturation): self
    {
        $this->adresse_facturation = $adresse_facturation;
        return $this;
    }

    public function getAdresseLivaison()
    {
        return $this->adresse_livraison;
    }

    public function setAdresseLivaison($adresse_livraison): self
    {
        $this->adresse_livraison = $adresse_livraison;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function addOrder(Product $order): self{

        if (!$this->orders->contains($order)) {
            
            $this->orders->add($order);

            if (!$order->getCustomer()->contains($this)) {
                
                $order->setCustomer($this);
            }
        }

        return $this;
        
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

}

