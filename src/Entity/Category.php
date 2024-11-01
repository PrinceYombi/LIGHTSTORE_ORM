<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name : 'categories')]
class Category{

    #[ORM\Id]
    #[ORM\Column(type :'integer')]
    #[ORM\GeneratedValue]
    private $id;

    #[ORM\Column(type :'string', length: 255)]
    private $name;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: "categories")]
    private $products;

    #[ORM\Column(type :'datetime')]
    private $created_at;


    public function __construct(){

        $this->created_at = new \DateTime();
        $this->products = new ArrayCollection();
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

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at): self
    {
        $this->created_at = $created_at;
        return $this;
    }

    
    public function getProduct()
    {
        return $this->products;
    }

    //Ajout d'un Produit dans la table Category
    public function addProduct(Product $product): self{

        if (!$this->products->contains($product)) {
            
            $this->products->add($product);

            if (!$product->getCategories()->contains($this)) {
                
                $product->addCategory($this);
            }
        }

        return $this;
        
    }

}