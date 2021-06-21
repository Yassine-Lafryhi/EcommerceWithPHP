<?php
require("database/connection.php");
ini_set('memory_limit', '1024M');
$content = file_get_contents("./products.json");
if ($content) {
    $json = json_decode($content);
    unset($content);
    $counter = 0;
    foreach ($json as $product) {
        $element = R::dispense('products');
        $element->sku = $product->sku;
        $element->name = $product->name;
        $element->type = $product->type;
        $element->price = $product->price;
        $element->upc = $product->upc;
        $element->shipping =  $product->shipping . " ";
        $element->description = $product->description;
        $element->manufacturer = $product->manufacturer ? $product->manufacturer : NULL;
        $element->model = $product->model ? $product->model : NULL;
        $element->url = $product->url;
        $element->image = $product->image;
        $id = R::store($element);
        $product_id = $product->sku;
        foreach ($product->category as $category){
            try {
                $category_id = $category->id." ";
                $category_name = $category->name." ";

                $element = R::dispense('categories');
                $element->category = $category_id;
                $element->category_name = $category_name;
                $id = R::store($element);

                $element = R::dispense('prodcats');
                $element->product = $product_id;
                $element->category = $category_id;
                $id = R::store($element);
            }catch(Exception $e) {
                echo 'Message: ' .$e->getMessage();
                continue;
            }
        }

        $counter += 1;
        if ($counter === 100) {
            break;
        }
    }
}
