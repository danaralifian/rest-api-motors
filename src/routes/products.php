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