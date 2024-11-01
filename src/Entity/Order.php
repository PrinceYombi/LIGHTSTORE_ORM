<?php
namespace App\Entity;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name : 'orders')]
class Order{

    #[ORM\Id]
    #[ORM\Column(type :'integer')]
    #[ORM\GeneratedValue]
    private $id;

    #[ORM\Column(type :'text')]
    private $name_product;
    #[ORM\Column(type :'float')]
    private $price;
    #[ORM\Column(type :'integer')]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: "order")]
    private $customer;



    #[ORM\Column(type :'datetime')]
    private $created_at;


    public function __construct(){

        $this->created_at = new \DateTime();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNameProduct()
    {
        return $this->name_product;
    }

    public function setNameProduct($name_product): self
    {
        $this->name_product = $name_product;

        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity): self
    {        
        $this->quantity = $quantity;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {        
        $this->price = $price;
        return $this;
    }



    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer($customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    
    
     public function getCreatedAt()
     {
         return $this->created_at;
     }

}