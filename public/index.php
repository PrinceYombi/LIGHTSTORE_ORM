<?php
session_start();

use Slim\Views\Twig;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Customer;
use Slim\Factory\AppFactory;
use Slim\Views\TwigMiddleware;

require_once dirname(__DIR__)."/bootstrap.php";

$app = AppFactory::create();

// Create Twig
$twig = Twig::create(dirname(__DIR__)."/templates", ['cache' => false]);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));

// Add error middleware
$app->addErrorMiddleware(true, true, true);

//Toutes les categories
$categories = $entityManager->getRepository(Category::class)->findAll();

/**
 * PRODUITS
 */
$app->get('/', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    $entityManager = $GLOBALS['entityManager'];
    $productRepository = $entityManager->getRepository(Product::class);

    $products = $productRepository->getProduct();

    return $view->render($response, 'product/product.html.twig', [
        'products' => $products,
        'categories' => $GLOBALS['categories'],
        'customer' => $_SESSION['customer']
    ]);

});

/**
 * PRODUITS SELON LES CATEGORIES
 */
$app->get('/product/by/category/{name}', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    $entityManager = $GLOBALS['entityManager'];

    $productRepository = $entityManager->getRepository(Product::class);
    
    $categoryRepository = $entityManager->getRepository(Category::class);
    $name = $args['name'];
    $category = $categoryRepository->findOneByName($name);

    if (!$category) {
        return $view->render($response, 'error/error404.html.twig');

    }
    
    $products = $category->getProduct()->getValues();

    return $view->render($response, 'product/product.html.twig', [
        'products' => $products,
        'category' => $category,
        'categories' => $GLOBALS['categories'],
        'customer' => $_SESSION['customer']
    ]);

});

/**
 * ACCUEIL PERMETTANT L'INSCRIPTION POUR UN CUSTOMER NON INSCRIT
 */
$app->get('/accueil', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    $entityManager = $GLOBALS['entityManager'];


    return $view->render($response, 'accueil/accueil.html.twig', [
       'customer' => $_SESSION['customer'],
       'categories' => $GLOBALS['categories'],
    ]);

});

/**
 * TRAITEMENT DE L'INSCRIPTION DU CUSTOMER
 */
$app->get('/inscription', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);

    $entityManager = $GLOBALS['entityManager'];
    $customerRepository = $entityManager->getRepository(Customer::class);
    $productRepository = $entityManager->getRepository(Product::class);
    $products = $productRepository->getProduct();

    if (!empty($_GET)) {
        $pseudo = $_GET['pseudo'];
        $email = $_GET['email'];
        $password = sha1($_GET['password']);
    }

    $customer = (new Customer())->setPseudo($pseudo)
                            ->setEmail($email)
                            ->setPassword($password);

    $entityManager->persist($customer);

    $entityManager->flush();

    //var_dump($customer); exit();
    $customerAuthen = $customerRepository->authenCustomer($email);


    if ($customerAuthen->getPassword() === $password) {
        
        $_SESSION['customer'] = [$customerAuthen->getId(),$customerAuthen->getSexe(), $customerAuthen->getPseudo(), 
        $customerAuthen->getFullName(),$customerAuthen->getAdresseFacturation(), $customerAuthen->getAdresseLivaison(),
        $customerAuthen->getTelephone(), $customerAuthen->getEmail()];

        return $view->render($response, 'product/product.html.twig', [

            'customer' => $_SESSION['customer'],
            'products' => $products,
            'categories' => $GLOBALS['categories'],

        ]);

    }else{

        return $view->render($response, 'error/error404.html.twig');
    }


});

/**
 * TRAITEMENT DE LA CONNEXION DU CUSTOMER DEJA INSCRIT
 */
$app->get('/connexion', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);

    $entityManager = $GLOBALS['entityManager'];
    $customerRepository = $entityManager->getRepository(Customer::class);
    $productRepository = $entityManager->getRepository(Product::class);
    $products = $productRepository->getProduct();

    if (!empty($_GET)) {
        $email = $_GET['email'];
        $password = sha1($_GET['password']);
    }

    //var_dump($customer); exit();
    $customerAuthen = $customerRepository->authenCustomer($email);


    if ($customerAuthen->getPassword() === $password) {
        
        $_SESSION['customer'] = [$customerAuthen->getId(),$customerAuthen->getSexe(), $customerAuthen->getPseudo(), 
        $customerAuthen->getFullName(),$customerAuthen->getAdresseFacturation(), $customerAuthen->getAdresseLivaison(),
        $customerAuthen->getTelephone(), $customerAuthen->getEmail()];

        return $view->render($response, 'product/product.html.twig', [

            'customer' => $_SESSION['customer'],
            'products' => $products,
            'categories' => $GLOBALS['categories'],

        ]);

    }else{

        return $view->render($response, 'error/error404.html.twig');
    }

});

/**
 * DECONNEXION DU CUSTOMER
 */
$app->get('/deconnexion', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);

    $entityManager = $GLOBALS['entityManager'];
    $productRepository = $entityManager->getRepository(Product::class);
    $products = $productRepository->getProduct();

    unset($_SESSION['customer']);

    return $view->render($response, 'product/product.html.twig', [

         'products' => $products,
         'categories' => $GLOBALS['categories'],
]);
    
});

/**
 * LE PROFIL DU CUSTOMER
 */
$app->get('/profil', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);


    return $view->render($response, 'profil/profil.html.twig', [

         'customer' => $_SESSION['customer'],
         'categories' => $GLOBALS['categories'],
]);
    
});

/**
 * PAGE DE MISE A JOUR PROFIL CUSTOMER
 */
$app->get('/miseAjour', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);


    //print_r($_SESSION['customer'][2]); exit();

    return $view->render($response, 'miseAjour/miseAjour.html.twig', [

         'customer' => $_SESSION['customer'],
         'categories' => $GLOBALS['categories'],
]);
    
});

/**
 * TRAITEMENT DE LA MISE A JOUR PROFIL CUSTOMER
 */
$app->get('/update', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    $entityManager = $GLOBALS['entityManager'];
    $customerRepository = $entityManager->getRepository(Customer::class);

    if (!empty($_GET)) {
        $sexe = $_GET['sexe'];
        $pseudo = $_GET['pseudo'];
        $full_name = $_GET['full_name'];
        $telephone = $_GET['telephone'];
        $email = $_GET['email'];
        $adresse_facturation = $_GET['adresse_facturation'];
        $adresse_livraison = $_GET['adresse_livraison'];

    }

    $id = $_SESSION['customer'][0];

    $customer = $customerRepository->updateCustomer($id, $sexe, $pseudo, $full_name, $adresse_facturation, $adresse_livraison, $telephone, $email);

    $customerById = $customerRepository->getCustomerById($id);

    $_SESSION['customer'] = [$customerById->getId(),$customerById->getSexe(), $customerById->getPseudo(), 
    $customerById->getFullName(),$customerById->getAdresseFacturation(), $customerById->getAdresseLivaison(),
    $customerById->getTelephone(), $customerById->getEmail()];
       
    

    //print_r($_SESSION['customer']); exit();
  
    return $view->render($response, 'profil/profil.html.twig', [
    
            'customer' => $_SESSION['customer'],
            'categories' => $GLOBALS['categories'],
    ]); 
    
});

/**
 * INSERER UN PRODUIT DANS LE PANIER
 */
$app->get('/panier/{id}', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    $entityManager = $GLOBALS['entityManager'];

    $productRepository = $entityManager->getRepository(Product::class);
    $id = $args['id'];
    $product = $productRepository->findOneById($id);

    //print_r($product->getId()); exit();

     if (!$product) {
       return $view->render($response, 'error/error404.html.twig');

    }
    $total_price = 0;
    define("TVA", 20);

    $_SESSION['panier'][] = [$product->getId(), $product->getName(), $product->getDescription(), $product->getPrice(), $product->getImageUrl()];
    //print_r($_SESSION['panier']); exit();

    foreach ($_SESSION['panier'] as $panier) {
        
        $total_price += $panier[3];
    }

    $total_price = number_format($total_price, 2);
    $total_tva = number_format($total_price*TVA/100, 2);
    $total_ttc = number_format($total_tva + $total_price, 2);
    
    return $view->render($response, 'panier/panier.html.twig', [
        'products' => $_SESSION['panier'],
        'total_price' => $total_price,
        'TVA' => TVA,
        'total_tva' => $total_tva,
        'total_ttc' => $total_ttc,
        'customer' => $_SESSION['customer'],
        'categories' => $GLOBALS['categories'],
    ]);

});

/**
 * AFFICHAGE DU PANIER
 */
$app->get('/panier', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    $entityManager = $GLOBALS['entityManager'];

    $productRepository = $entityManager->getRepository(Product::class);

    $total_price = 0;
    define("TVA", 20);

    foreach ($_SESSION['panier'] as $panier) {
        
        $total_price += $panier[3];
    }

    //print_r($_SESSION['panier'][1]);


    $total_price = number_format($total_price, 2);
    $total_tva = number_format($total_price*TVA/100, 2);
    $total_ttc = number_format($total_tva + $total_price, 2);
    
    return $view->render($response, 'panier/panier.html.twig', [
        'products' => $_SESSION['panier'],
        'total_price' => $total_price,
        'TVA' => TVA,
        'total_tva' => $total_tva,
        'total_ttc' => $total_ttc,
        'customer' => $_SESSION['customer'],
        'categories' => $GLOBALS['categories'],
    ]);

});

/**
 * DETAILS D4UN PRODUIT
 */
$app->get('/detail/{id}', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    $entityManager = $GLOBALS['entityManager'];
    $productRepository = $entityManager->getRepository(Product::class);
    $id = $args['id'];
    $product = $productRepository->findOneById($id);

    //print_r($product->getId()); exit();

     if (!$product) {
       return $view->render($response, 'error/error404.html.twig');

    }

    return $view->render($response, 'detail/detail.html.twig', [
        'id' => $product->getId(),
        'name' => $product->getName(),
        'description'=>$product->getDescription(),
        'image' => $product->getImageUrl(),
        'categories' => $GLOBALS['categories'],
        'product' => $product,
        'categories' => $GLOBALS['categories'],
    ]);

});

/**
 * VALIDATION DE LA COMMANDE DU CUSTOMER
 */
$app->get('/valider', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    $entityManager = $GLOBALS['entityManager'];
    $productRepository = $entityManager->getRepository(Product::class);
    $customerRepository = $entityManager->getRepository(Customer::class);

    $id = $_SESSION['customer'][0];
    $customerById = $customerRepository->getCustomerById($id);

    //print_r($_SESSION['order'][0]); exit();

    if (isset($_SESSION['panier'])) {
        foreach ($_SESSION['panier'] as $product) {
        
            $order = (new Order())->setNameProduct($product[1])
                                ->setprice($product[3])
                                ->setQuantity(1)
                                ->setCustomer($customerById);          
            $entityManager->persist($order);
        }
    }
    $entityManager->flush();

   if (isset($order)) {
    
        unset($_SESSION['panier']);
        return $view->render($response, 'valider/valider.html.twig', [
        
            'customer' => $_SESSION['customer']
        ]);
   }

});


// Run app
$app->run();


