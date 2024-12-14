<?php

require_once 'app/model/categoriesModel.php';

class CategoriesController
{
    public function index()
    {
        $categories = new categoriesModel();
        $categoriess = $categories->getAllCategories();

        include_once 'views/pages/categories/categories.php';
    }

    public function create() {
        $err = [];
        $data = $_POST;
        
        if (isset($_POST['submit'])) {
            $product_name = $_POST['name'];
            if (empty($err)) {
                $categories = new categoriesModel();
                $categories->addCategories($product_name);
    
                header('Location:' . APPURL_ADMIN . 'categories');
            }
        }
        include_once 'views/pages/categories/create.php';
    }
    
    //edit product
    public function edit() {
        $categories_id = $_GET['id'];
        $categories = new categoriesModel();
        $categoriesData = $categories->getCategoriesById($categories_id)->fetch_assoc();
        $err = [];
    
        if (isset($_POST['submit'])) {
            $product_name = $_POST['name'];
    
            if (empty($err)) {
                $categories->editCategories($categories_id, $product_name);
                header('Location:' . APPURL_ADMIN . 'categories');
            }
        }
        include_once 'views/pages/categories/edit.php';
    }

    //delete product
    public function delete() {
        $categories_id = $_GET['id'];
        $categories = new categoriesModel();
        $categories->deleteCategories($categories_id);
        header('Location:' . APPURL_ADMIN . 'categories');
    }
}