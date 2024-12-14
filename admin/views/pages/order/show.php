<?php include_once 'views/partials/header.php'; ?>

<style>
    .description {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Order</h4>
                        <form action="" method="POST">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tên khách hàng</th>
                                        <th>Số điện thoại</th>
                                        <th>địa chỉ</th>
                                        <th>ghi chú</th>
                                        <th>Tổng tiền</th>
                                        <th>status</th>
                                        <th>Thời gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr>
                                            <td><?php echo $orderdt['customer_name']; ?></td>
                                            <td><?php echo $orderdt['customer_phone']; ?></td>
                                            <td><?php echo $orderdt['customer_address']; ?></td>
                                            <td><?php echo $orderdt['note']; ?></td>
                                            <td>
                                                <?php echo number_format($orderdt['total_amount'], 0, ',', '.'); ?>
                                            </td>
                                            <td><?php echo $orderdt['status'] ?></td>
                                            <td><?php echo $orderdt['created_at'] ?></td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Order Detail</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orderDetails as $orderDetail): ?>
                                        <tr>
                                            <td><?php 
                                            echo $prd->getProductById($orderDetail['product_id'])['name']
                                            ?></td>
                                            <td><?php echo $orderDetail['quantity']; ?></td>
                                            <td>
                                                <?php echo number_format($orderdt['total_amount'], 0, ',', '.'); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
    </script>

<?php include_once 'views/partials/_footer.php'; ?>
