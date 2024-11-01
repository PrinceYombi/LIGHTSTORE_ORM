<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: "App\Repository\ProductRepository")]
#[ORM\Table(name : 'products')]
class Product{

    #[ORM\Id]
    #[ORM\Column(type :'integer')]
    #[ORM\GeneratedValue]
    private $id;

    #[ORM\Column(type :'string')]
    private $name;
    #[ORM\Column(type :'text')]
    private $description;
    #[ORM\Column(type :'float')]
    private $price;
    #[ORM\Column(type :'integer')]
    private $stock;
    #[ORM\Column(type :'string')]
    private $image_url;


    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: "products")]
    private $categories;


    #[ORM\Column(type :'datetime')]
    private $created_at;


    public function __construct(){

        $this->created_at = new \DateTime();
        $this->categories = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }


    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;
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

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock): self
    {   
        $this->stock = $stock;
        return $this;
    }


    public function getImageUrl()
    {
        return $this->image_url;
    }

    public function setImageUrl($image_url): self
    {
        $this->image_url = $image_url;
        return $this;
    }

     /**
     * get Category
     */
    public function getCategories()
    {
        return $this->categories;
    }

     //Ajouter une category dans la Table Article
     public function addCategory(Category $category): self
     {
         if (!$this->categories->contains($category)) {
            
             $this->categories->add($category);
             $category->addProduct($this);
         }
 
         return $this;
     }

     //Suppression d'une Category dans la Table Article
     public function removeCategory(Category $category): self
     {
         if ($this->categories->removeElement($category)) {
             
             if ($category->getProducts()->contains($this)) {
              
                 $category->removeProduct($this);
             }
         }
 
         return $this;
     }

     public function getOrder()
     {
         return $this->orders;
     }
 
     public function addOrder(Product $order): self{

        if (!$this->orders->contains($order)) {
            
            $this->orders->add($order);

            if (!$order->getProduct()->contains($this)) {
                
                $order->setProduct($this);
            }
        }

        return $this;
        
    }

  
     public function getCreatedAt()
     {
         return $this->created_at;
     }

}