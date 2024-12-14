<?php

require_once 'app/model/productModel.php';

class productController
{
    public function index()
    {
        $product = new productModel();
        $products = $product->getAllProduct();

        include_once 'views/pages/product/product.php';
    }

    public function create() {
        $err = [];
        $data = $_POST;
        
        if (isset($_POST['submit'])) {
            $product_name = $_POST['name'];
            $price = $_POST['price'];
            $status = $_POST['status'];
            $id_category = $_POST['id_category'];
            $thumbnail = $_FILES['thumbnail']['name'];
    
            // Validate required fields
            if (empty($product_name)) $err[] = 'Product name is required.';
            if (empty($price)) $err[] = 'Price is required.';
            if (empty($id_category)) $err[] = 'Category is required.';
    
            if (empty($err)) {
                $product = new productModel();
                $product->addProduct($product_name, $price,$thumbnail, $status,$id_category);
    
                // Upload file
                $file = '../assets/images/' . $_FILES['thumbnail']['name'];
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], $file);
    
                header('Location:' . APPURL_ADMIN . 'product');
            }
        }
        include_once 'views/pages/product/create.php';
    }
    
    //edit product
    public function edit() {
        $product_id = $_GET['id'];
        $product = new productModel();
        $productData = $product->getProductById($product_id);
        $err = [];
    
        if (isset($_POST['submit'])) {
            $product_name = $_POST['name'];
            $price = $_POST['price'];
            $status = $_POST['status'];
            $id_category = $_POST['id_category'];
            $thumbnail = $productData['image'];
    
            if ($_FILES['thumbnail']['error'] == 0) {
                $thumbnail = $_FILES['thumbnail']['name'];
                $file = '../assets/images/' . $_FILES['thumbnail']['name'];
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], $file);
            }
    
            if (empty($err)) {
                $product->editProduct($product_id, $product_name, $price,$thumbnail,$status, $id_category);
                header('Location:' . APPURL_ADMIN . 'product');
            }
        }
        include_once 'views/pages/product/edit.php';
    }

    //delete product
    public function delete() {
        $product_id = $_GET['id'];
        $product = new productModel();
        $product->deleteProduct($product_id);
        header('Location:' . APPURL_ADMIN . 'product');
    }
}