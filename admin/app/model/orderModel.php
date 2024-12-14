<?php


require_once '../config/connect.php';


class orderModel {

    public function getAllOrder(){
        $sql = "SELECT * FROM `orders` ORDER BY id DESC";
        $result = Database::query($sql);
        $res = $result->fetch_all(MYSQLI_ASSOC);
        return $res;
    }

    public function getOrderById($id){
        $sql = "SELECT * FROM `orders` WHERE id = $id";
        $result = Database::query($sql);
        $res = $result->fetch_assoc();
        return $res;
    }
    public function deleteOrder($id) {
        $connection = Database::getConnection();
        if (!$connection->ping()) {
            $connection->connect();
        }
        $connection->begin_transaction();
    
        try {
            $sqlDeleteItems = "DELETE FROM `order_items` WHERE order_id = ?";
            $stmtItems = $connection->prepare($sqlDeleteItems);
            $stmtItems->bind_param("i", $id);
            if (!$stmtItems->execute()) {
                throw new Exception($stmtItems->error);
            }
            $stmtItems->close();
            $sqlDeleteOrder = "DELETE FROM `orders` WHERE id = ?";
            $stmtOrder = $connection->prepare($sqlDeleteOrder);
            $stmtOrder->bind_param("i", $id);
            if (!$stmtOrder->execute()) {
                throw new Exception($stmtOrder->error);
            }
            $stmtOrder->close();
            $connection->commit();
            return true;
        } catch (Exception $e) {
            $connection->rollback();
            die("Delete failed: " . $e->getMessage());
        }
    }
    
    
}