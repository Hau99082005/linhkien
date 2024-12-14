<?php


require_once '../config/connect.php';

class orderDetailModel {
    //order_id	product_id	number	price	total_price	payment_method	
    // get all order detail
    public function getAllOrderDetail(){
        $sql = "SELECT * FROM `order_items` ORDER BY order_id  DESC";
        $result = Database::query($sql);
        $res = $result->fetch_all(MYSQLI_ASSOC);
        return $res;
    }

    // get order detail by order_id
    public function getOrderDetailById($id){
        $sql = "SELECT * FROM `order_items` WHERE order_id = $id";
        $result = Database::query($sql);
        $res = $result->fetch_all(MYSQLI_ASSOC);
        return $res;
    }



}