<?php

use App\Entity\Product;
use App\Entity\Category;


require_once "bootstrap.php";

$categories = [
    (new Category())->setName("Talons femmes"),
    (new Category())->setName("Robes femmes"),
    (new Category())->setName("Pantalons femmes"),

];

foreach ($categories as $category) {
    
    $entityManager->persist($category);
}

$entityManager->flush();

$products = [

    (new Product())->setName('talons hauts')
    ->setDescription('SARAIRIS 2020 mode été plate-forme talons hauts compensés décontracté confortable lumière loisirs chaussures femme sandales femmes chaussures femme')
    ->setPrice(78.98)->setStock(200)
    ->addCategory($categories[0])
    ->setImageUrl('b4.png'),
    (new Product())->setName('sandales compensées')
    ->setDescription('DAHOOD sandales compensées pour femme mi-talon été sans lacet boucle dames chaussures artificiel bout ouvert décontracté pompes de mariage femmes Sandalias')
    ->setPrice(78.98)->setStock(200)
    ->addCategory($categories[0])
    ->setImageUrl('b3.png'),
    (new Product())->setName('chaussures à semelles')
    ->setDescription('INS loisirs grande taille 43 femmes confortables chaussures à semelles compensées 2020 en Stock été sandales femme plate-forme talons hauts chaussures femme')
    ->setPrice(23.98)->setStock(200)
    ->addCategory($categories[0])
    ->setImageUrl('b1.png'),
    (new Product())->setName('Sandales femmes')
    ->setDescription('Sandales femmes nouvelles chaussures d\'été femme grande taille 46 talons sandales pour chaussures à semelles compensées femme chaussures décontractées gladiateur Sandalias Mujer')
    ->setPrice(23.98)->setStock(200)
    ->addCategory($categories[0])
    ->setImageUrl('b2.png'),
    (new Product())->setName('Direct talons bas')
    ->setDescription('Usine Direct talons bas sandales femmes bride à la cheville chaussures d\'été femme grande taille 43 bloc talons femmes chaussures 2019 sandales décontractées')
    ->setPrice(23.89)->setStock(0)
    ->addCategory($categories[0])
    ->setImageUrl('b5.png'),
    (new Product())->setName('Élégant robe longue')
    ->setDescription('Élégant robe longue femmes printemps Plaid imprimer robe de soirée irrégulière Vintage robes dames bouton a-ligne 2020 nouvelle robe de mode')
    ->setPrice(54.99)->setStock(200)
    ->addCategory($categories[1])
    ->setImageUrl('c2.png'),
    (new Product())->setName('robe de bureau Sexy')
    ->setDescription('Grande taille 2019 mode été Patchwork pli travail robe de bureau Sexy moulante sans manches femmes décontracté tenue de fête robe de fête')
    ->setPrice(34.99)->setStock(500)
    ->addCategory($categories[1])
    ->setImageUrl('c3.png'),
    (new Product())->setName('Bandage moulante à manches')
    ->setDescription('Recherché nouveau femmes Bandage moulante à manches courtes robe de soirée Midi')
    ->setPrice(56.99)->setStock(200)
    ->addCategory($categories[1])
    ->setImageUrl('c4.png'),
    (new Product())->setName('mode femmes Sexy dames')
    ->setDescription('Marque nouvelle mode femmes Sexy dames o-cou robe noire pansement moulante à manches longues soirée Cocktail courte Mini robe')
    ->setPrice(165.99)->setStock(200)
    ->addCategory($categories[1])
    ->setImageUrl('c5.png'),
    (new Product())->setName('Robe femmes grande')
    ->setDescription('Robe femmes grande taille 3XL 11 couleur Sexy col en v solide paillettes couture brillant Club gaine')
    ->setPrice(29.99)->setStock(100)
    ->addCategory($categories[1])
    ->setImageUrl('c7.png'),
    (new Product())->setName('cuir pantalon noir')
    ->setDescription('Pantalon femmes taille haute PU cuir pantalon noir Leggings femme brillant Stretch crayon pantalon élastique pantalon femme vêtements')
    ->setPrice(45.9)->setStock(150)
    ->addCategory($categories[2])
    ->setImageUrl('p4.png'),
    (new Product())->setName('pantalon large jambe')
    ->setDescription('Toplook Neon pantalon large jambe 2019 été femmes taille haute Streetwear Festival pantalon lâche noir vêtements bureau dames ceinture')
    ->setPrice(29.99)->setStock(100)
    ->addCategory($categories[2])
    ->setImageUrl('p2.png'),
    (new Product())->setName('Flare pantalon femme')
    ->setDescription('Taille haute décontracté Flare pantalon femme mode nouveau pantalon femmes cheville-longueur femmes vêtements 2018')
    ->setPrice(29.99)->setStock(100)
    ->addCategory($categories[2])
    ->setImageUrl('p3.png'),
    (new Product())->setName('Skinny Slim pantalon')
    ->setDescription('Femmes Stretch taille haute Jegging Denim Jeans Skinny Slim pantalon pantalons Leggings décontracté quotidien vêtements Skinny crayon')
    ->setPrice(29.99)->setStock(100)
    ->addCategory($categories[2])
    ->setImageUrl('p1.png'),
    (new Product())->setName('Rayonne tricoté Sexy')
    ->setDescription('couleurs de haute qualité crayon femmes pantalon rayonne tricoté Sexy & Club pantalon de pansement vêtements de fête')
    ->setPrice(29.99)->setStock(100)
    ->addCategory($categories[2])
    ->setImageUrl('p5.png'),
    (new Product())->setName('Pantalon élastique')
    ->setDescription('Grande taille femmes pantalon élastique taille haute pantalon femmes pantalon Patchwork Capris pantalons de survêtement Joggers mode décontracté femmes vêtements')
    ->setPrice(29.99)->setStock(100)
    ->addCategory($categories[2])
    ->setImageUrl('p6.png'),
   

];

foreach ($products as $product) {
    
    $entityManager->persist($product);
}

$entityManager->flush();

