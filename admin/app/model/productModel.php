<?php

include '../config/connect.php';


class productModel {

    // get all product
    public function getAllProduct() {
        $sql = "SELECT * FROM products";
        $result = Database::query($sql);
        return $result;
    }

    // get product by id
    public function getProductById($id) {
        $sql = "SELECT * FROM products WHERE id = $id";
        $result = Database::query($sql);
        $result = $result->fetch_array();
        return $result;
    }
    public function addProduct($product_name, $price, $images_products, $status,$id_category) {
        $sql = "INSERT INTO products (image, name, price,status,id_category) VALUES ('$images_products', '$product_name', '$price','$status' ,'$id_category')";
        $result = Database::query($sql);
        return $result;
    }
    

    // edit product
    public function editProduct($id, $product_name, $price,$images_products,$status,$id_category) {
        $sql = "UPDATE products SET image = '$images_products', name = '$product_name',price = '$price',status = $status,id_category = '$id_category' WHERE id = $id";
        $result = Database::query($sql);
        return $result;
    }
    

    // delete product
    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id = $id";
        $result = Database::query($sql);
        return $result;
    }
}