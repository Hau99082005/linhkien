<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
require_once 'inc/database.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $note = isset($_POST['note']) ? trim($_POST['note']) : '';
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $total_amount = 0;

    if (empty($cart)) {
        die('Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi đặt hàng.');
    }

    foreach ($cart as $item) {
        $total_amount += $item->quantity * $item->price * 1000;
    }

    if (empty($name) || empty($address) || empty($phone)) {
        die('Vui lòng nhập đầy đủ thông tin bắt buộc.');
    }

    $db = Database::getConnection();
    if (!$db) {
        die('Không thể kết nối cơ sở dữ liệu.');
    }

    $db->begin_transaction();
    try {
        $stmt = $db->prepare("INSERT INTO `orders` (customer_name, customer_address, customer_phone, note, total_amount, created_at)  VALUES (?, ?, ?, ?, ?, NOW())");
        if (!$stmt) {
            throw new Exception('Lỗi chuẩn bị câu lệnh: ' . $db->error);
        }
        $stmt->bind_param('ssssd', $name, $address, $phone, $note, $total_amount);
        if (!$stmt->execute()) {
            throw new Exception('Lỗi thực thi câu lệnh: ' . $stmt->error);
        }

        $order_id = $stmt->insert_id;
        $stmt_item = $db->prepare("INSERT INTO `order_items` (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        if (!$stmt_item) {
            throw new Exception('Lỗi chuẩn bị câu lệnh (order_items): ' . $db->error);
        }
        foreach ($cart as $item) {
            $stmt_item->bind_param('iiid', $order_id, $item->id, $item->quantity, $item->price);
            if (!$stmt_item->execute()) {
                throw new Exception('Lỗi thực thi câu lệnh (order_items): ' . $stmt_item->error);
            }
        }

        unset($_SESSION['cart']);
        $db->commit();

        // Giao diện hiển thị thành công
        echo '!DOCTYPE html>
      <html lang="vi">
       <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to bottom right, #8e44ad, #3498db);
            font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
        }
        .success-container {
            text-align: center;
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: translateY(-50px);
            opacity: 0;
            animation: fadeInUp 1s ease forwards;
        }
        .success-icon {
            font-size: 100px;
            color: #27ae60;
            margin-bottom: 20px;
            animation: pulse 1.5s infinite;
        }
        .message {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            animation: slideIn 0.8s ease forwards;
        }
        .details {
            font-size: 18px;
            color: #7f8c8d;
            margin-bottom: 25px;
            animation: slideIn 1s ease forwards;
        }
        .btn {
            display: inline-block;
            padding: 15px 30px;
            background-color: #2980b9;
            color: white;
            text-decoration: none;
            font-size: 20px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background-color: #1abc9c;
            transform: translateY(-3px);
        }
        .confetti {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }
        @keyframes fadeInUp {
            0% {
                transform: translateY(50px);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }
        @keyframes slideIn {
            0% {
                opacity: 0;
                transform: translateX(-20px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            for (let i = 0; i < 100; i++) {
                let confetti = document.createElement(div);
                confetti.className = confetti-piece;
                document.body.appendChild(confetti);
                confetti.style.left = Math.random() * window.innerWidth + px;
                confetti.style.animationDuration = Math.random() * 3 + 2 + s;
                confetti.style.animationDelay = Math.random() * 2 + s;
            }
        });
    </script>
</head>
<body>
    <div class="confetti"></div>
    <div class="success-container">
        <div class="success-icon">&#10004;</div>
        <div class="message">Đặt hàng thành công!</div>
        <div class="details">Cảm ơn bạn đã mua hàng! Chúng tôi sẽ liên hệ bạn sớm nhất.</div>
        <a href="index.php" class="btn">Quay lại trang chủ</a>
    </div>
</body>
</html';
    } catch (Exception $e) {
        $db->rollback();
        die('Có lỗi xảy ra trong quá trình xử lý đơn hàng: ' . $e->getMessage());
    } finally {
        $db->close();
    }
} else {
    die('Yêu cầu không hợp lệ.');
}
?>
