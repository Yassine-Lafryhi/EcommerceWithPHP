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
    if ($get === 'search') {
        $query = $_GET['query'];
        $elements = R::find('products', ' name LIKE :element1 OR description LIKE :element2', array(':element1' => '%' . $query . '%', ':element2' => '%' . $query . '%'));
        $array = [];
        $array = array_merge($array, $elements);
        header('Content-Type: application/json');
        echo json_encode($array, JSON_PRETTY_PRINT);
    } else if ($get === 'product') {
        $id = $_GET['id'];
        $elements = R::find('products', ' sku= :id', array(':id' => $id));
        $array = [];
        $array = array_merge($array, $elements);
        header('Content-Type: application/json');
        echo json_encode($array[0], JSON_PRETTY_PRINT);
    } else if ($get === 'cart') {
        if (empty($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        $cart = $_SESSION['cart'];
        header('Content-Type: application/json');
        echo json_encode($cart, JSON_PRETTY_PRINT);
    } else if ($get === 'cartCount') {
        $cart = $_SESSION['cart'];
        $counter = 0;
        foreach ($cart as $key => &$value) {
            $counter += 1;
        }
        header('Content-Type: application/json');
        echo json_encode(array('number' => $counter), JSON_PRETTY_PRINT);
    } else if ($get === 'emptyCart') {
        $cart = $_SESSION['cart'];
        foreach ($cart as $key => &$value) {
            unset($cart[$key]);
        }
        $_SESSION['cart'] = $cart;
        $array = array("code" => 1);
        header('Content-Type: application/json');
        echo json_encode($array, JSON_PRETTY_PRINT);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = json_decode(file_get_contents('php://input'), true);
    $post = $_POST['post'];
    if ($post === 'cart') {
        $product = $_POST['product'];
        $quantity = $_POST['quantity'];
        if (empty($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        $cart = $_SESSION['cart'];
        array_push($cart, array("product" => $product, "quantity" => $quantity));
        $_SESSION['cart'] = $cart;
        $array = array("code" => 1);
        header('Content-Type: application/json');
        echo json_encode($array, JSON_PRETTY_PRINT);
    } else if ($post === 'increment') {
        $product = $_POST['product'];
        if (empty($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        $cart = $_SESSION['cart'];
        $newQuantity = 0;
        foreach ($cart as $key => &$value) {
            if ($value['product'] == $product) {
                $value['quantity'] += 1;
                $newQuantity = $value['quantity'];
            }
        }
        $_SESSION['cart'] = $cart;
        $array = array("code" => 1, "quantity" => $newQuantity);
        header('Content-Type: application/json');
        echo json_encode($array, JSON_PRETTY_PRINT);
    } else if ($post === 'decrement') {
        $product = $_POST['product'];
        if (empty($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        $cart = $_SESSION['cart'];
        $newQuantity = 0;
        foreach ($cart as $key => &$value) {
            if ($value['product'] == $product) {
                $value['quantity'] -= 1;
                $newQuantity = $value['quantity'];
                if ($value['quantity'] == 0) {
                    unset($cart[$key]);
                }
            }
        }
        $_SESSION['cart'] = $cart;
        $array = array("code" => 1, "quantity" => $newQuantity);
        header('Content-Type: application/json');
        echo json_encode($array, JSON_PRETTY_PRINT);
    } else if ($post === 'delete') {
        $product = $_POST['product'];
        $cart = $_SESSION['cart'];
        foreach ($cart as $key => &$value) {
            if ($value['product'] == $product) {
                unset($cart[$key]);
            }
        }
        $_SESSION['cart'] = $cart;
        $array = array("code" => 1);
        header('Content-Type: application/json');
        echo json_encode($array, JSON_PRETTY_PRINT);
    } else if ($post === 'register') {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $element = R::dispense('clients');
        $element->firstName = $firstName;
        $element->lastName = $lastName;
        $element->email = $email;
        $element->phoneNumber = $phoneNumber;
        $element->password = sha1($password);
        $element->address = $address;
        $id = R::store($element);
        if ($id > 0) {
            $array = array("code" => 1);
            header('Content-Type: application/json');
            echo json_encode($array, JSON_PRETTY_PRINT);
        }
    } else if ($post === 'login') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $message = array();
        $element = R::findOne('clients', "email = ?", array($email));
        if ($element !== null) {
            $retrieved_password = $element->password;
            if (sha1($password) === $retrieved_password) {
                $message = array(
                    "code" => 1,
                    "id" => $element->id
                );
            } else {
                $message = array(
                    "code" => 2
                );
            }
        }
        header('Content-Type: application/json');
        echo json_encode($message, JSON_PRETTY_PRINT);
    } else if ($post === 'command') {
        $element = R::dispense('commands');
        $element->date = date('d-m-Y');
        $element->time = date('H:i:s');
        $element->status = "PENDING";
        $id = R::store($element);
        if ($id > 0) {
            $message = array(
                "code" => 1,
                "id" => $id,
            );
            header('Content-Type: application/json');
            echo json_encode($message, JSON_PRETTY_PRINT);
        }
    } else if ($post === 'checkout') {
        $element = R::dispense('commanditem');
        $element->client = $_POST['client'];
        $element->command = $_POST['command'];
        $element->product = $_POST['product'];
        $element->quantity = $_POST['quantity'];
        $id = R::store($element);
        if ($id > 0) {
            $message = array(
                "code" => 1,
            );
            header('Content-Type: application/json');
            echo json_encode($message, JSON_PRETTY_PRINT);
        }
    }
}
