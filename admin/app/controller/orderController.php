<?php

require_once 'app/model/orderModel.php';
require_once 'app/model/orderDetailModel.php';
require_once 'app/model/productModel.php';

class orderController
{
    public function index()
    {
        // get all order
        $order = new orderModel();
        $orders = $order->getAllOrder();

        require_once 'views/pages/order/order.php';
    }

    public function show($id)
    {
        //get order by id
        $order = new orderModel();
        $orderdt = $order->getOrderById($id);


        
        //get order detail by order_id
        $orderDetail = new orderDetailModel();
        $orderDetails = $orderDetail->getOrderDetailById($id);

        $prd = new productModel();
        foreach($orderDetails as $ord){
            $ord['product_id'] = $prd->getProductById($ord['product_id']);
        }
        // var_dump($orderDetails);


        require_once 'views/pages/order/show.php';
    }
    public function delete() {
        if (isset($_GET['id'])) {
            $order_id = $_GET['id'];
            
            $order = new orderModel();
            
            // Call deleteOrder method
            $order->deleteOrder($order_id);
            
            // Redirect to the order list page after deletion
            header('Location: ' . APPURL_ADMIN . 'order');
            exit;
        } else {
            die("Order ID not specified.");
        }
    }
    
}