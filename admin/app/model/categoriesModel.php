<?php

require_once '../config/connect.php';


class categoriesModel {
    public function getAllCategories() {
        $sql = "SELECT * FROM categories";
        $result = Database::query($sql);
        return $result;
    }
    public function getCategoriesById($id) {
        $sql = "SELECT * FROM categories WHERE id = $id";
        $result = Database::query($sql);
        return $result;
    }
    public function addCategories($product_name) {
        $sql = "INSERT INTO categories(name) VALUES ('$product_name')";
        $result = Database::query($sql);
        return $result;
    }
    
    public function editCategories($id, $product_name) {
        $sql = "UPDATE categories SET name = '$product_name' WHERE id = $id";
        $result = Database::query($sql);
        return $result;
    }
    
    public function deleteCategories($id) {
        $sql = "DELETE FROM categories WHERE id = $id";
        $result = Database::query($sql);
        return $result;
    }
}