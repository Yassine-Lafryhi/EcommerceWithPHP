<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require("../database/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $get = $_GET['get'];
    if ($get === 'products') {
        if (isset($_GET['offset']))
            $offset = $_GET['offset'];
        if (isset($_GET['number']))
            $number = $_GET['number'];
        if (isset($offset)) {
            $elements = R::find('products', ' id >= :id LIMIT :limit', array(':id' => $offset, ':limit' => 10 + (int)$offset));
            $array = [];
            $array = array_merge($array, $elements);
            header('Content-Type: application/json');
            echo json_encode($array, JSON_PRETTY_PRINT);
        } else if (isset($number)) {
            $number_of_products = R::count('products');
            header('Content-Type: application/json');
            echo json_encode(['message' => $number_of_products], JSON_PRETTY_PRINT);
        }
    }
}
