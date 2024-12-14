
<?php
session_start();

require_once 'app/controller/productController.php';
require_once 'app/controller/auth/loginController.php';
require_once 'app/controller/orderController.php';
require_once 'app/controller/categoriesController.php';
require_once 'app/controller/contactController.php';

define('APPURL_ADMIN', '/thanh/admin/');
define('APPURL', '/thanh/');

$url = $_SERVER['REQUEST_URI'];
$url = explode('/', trim($url, '/')); 

$url = explode('?', $url[2]);
// echo var_dump($url);
if (!isset($_SESSION['user-admin'])) {
    if ($url[0] == 'login') {
        $login = new loginController();
        $login->index();
    } else {
        header('Location:' . APPURL_ADMIN . 'login');
    }
}


//init controller
$product = new productController();
$orderCtl = new orderController();
$categories = new CategoriesController();
$contact = new contactController();

switch ($url[0]) {    
    case '':
        require_once 'views/home.php';
        break;
    //auth route
    case 'login':
        $login = new loginController();
        $login->index();
        break;
    case 'logout':
        session_destroy();
        header('Location:' . APPURL_ADMIN . 'login');
        break;

    //product route
    case 'product':
        $product->index();
        break;
    case 'create-product':
        $product->create();
        break;
    case 'edit-product':
        $product->edit();
        break;
    case 'delete-product':
        $product->delete();
        break;
 //oder route
 case 'order':
    $orderCtl->index();
    break;
case 'order-detail':
    if (isset($_GET['id'])) {
        $orderCtl->show($_GET['id']);
    }else{
        header('Location:' . APPURL_ADMIN . 'order');
    }
    break;
// Check for the 'delete' action in the URL and call the delete method in the controller
case 'order-delete':
if (isset($_GET['id'])) {
    $orderCtl->delete();
} else {
    header('Location: ' . APPURL_ADMIN . 'order');
}
break;
    //categories route
    case 'categories':
        $categories->index();
        break;
    case 'create-categories':
        $categories->create();
        break;
    case 'edit-categories':
        $categories->edit();
        break;
    case 'delete-categories':
        $categories->delete();
        break;
 
    case 'contact':
        $contact->index();
        break;
    case 'create-contact':
        $contact->create();
        break;
    case 'edit-contact':
        $contact->edit();
        break;
    case 'delete-contact':
        $contact->delete();
        break;
    default:
        require_once 'views/404.php';
        break;
}
