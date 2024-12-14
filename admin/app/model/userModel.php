<?php

require_once '../config/connect.php';

class userModel {
    public function getUserByPhone($phone) {
        $conn = Database::getConnection();
        if (!$conn) {
            die("Lỗi: Không thể kết nối tới cơ sở dữ liệu.");
        }
        $stmt = $conn->prepare("SELECT * FROM users WHERE phone = ?");
        $stmt->bind_param("s", $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null; 
        }
    }
}
