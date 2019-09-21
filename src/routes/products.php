<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = new \Slim\App;

// GET All Products
$app->get('/api/products', function(Request $request, Response $response){
    $sql = 'SELECT * FROM products LIMIT 0,20';
    try {
        // GET DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($products);
    } catch (PDOException $e) {
        echo '{"Error": {"text": '.$e->getMessage().'}';
    }
});

// GET Single Product
$app->get('/api/products/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');

    $sql = 'SELECT * FROM products WHERE productCode = "'.$id.'"';
    try {
        // GET DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($products);
    } catch (PDOException $e) {
        echo '{"Error": {"text": '.$e->getMessage().'}';
    }
});

// GET Single Product
$app->post('/api/products/add', function(Request $request, Response $response){
    $productCode = $request->getParam('productCode');
    $productName = $request->getParam('productName');
    $productLine = $request->getParam('productLine');
    $productScale = $request->getParam('productScale');
    $productVendor = $request->getParam('productVendor');
    $productDescription = $request->getParam('productDescription');
    $quantityInStock = $request->getParam('quantityInStock');
    $buyPrice = $request->getParam('buyPrice');
    $MSRP = $request->getParam('MSRP');

    $sql = 'INSERT INTO products (productCode,productName,productLine,productScale,productVendor,
            productDescription,quantityInStock,buyPrice,MSRP) VALUES 
            (:productCode,:productName,:productLine,:productScale,:productVendor,:productDescription,
            :quantityInStock,:buyPrice,:MSRP)';
    try {
        // GET DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':productCode', $productCode);
        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':productLine', $productLine);
        $stmt->bindParam(':productScale', $productScale);
        $stmt->bindParam(':productVendor', $productVendor);
        $stmt->bindParam(':productDescription', $productDescription);  
        $stmt->bindParam(':quantityInStock', $quantityInStock);
        $stmt->bindParam(':buyPrice', $buyPrice);
        $stmt->bindParam(':MSRP', $MSRP);

        $stmt->execute();

        echo '{"message" : {"text" : "Product Added"}';
    } catch (PDOException $e) {
        echo '{"Error": {"text": '.$e->getMessage().'}';
    }
});