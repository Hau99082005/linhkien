<?php include_once 'views/partials/header.php'; ?>

<style>
    /* gioi han hien thi description */
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
                <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Tên khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>địa chỉ</th>
                        <th>Ghi chú</th>
                        <th>Tổng tiền</th>
                        <th>Thời gian</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($orders as  $order): ?>
                            <tr>
                                <td><?php echo $order['customer_name']; ?></td>
                                <td><?php echo $order['customer_phone']; ?></td>
                                <td><?php echo $order['customer_address']; ?></td>
                                <td><?php echo $order['note']; ?></td>
                                <td>
                                <?php echo number_format($order['total_amount'], 0, ',', '.'); ?>
                                </td>
                                <td><?php echo $order['created_at']; ?></td>
                                <td>
                                    <a href="order-detail?id=<?php echo $order['id']; ?>" class="btn btn-dark">View</a>
                                    <a href="<?php echo APPURL_ADMIN . 'order-delete?id=' . $order['id']; ?>" class="btn btn-primary"
               onclick="return confirm('Are you sure you want to delete this order?');">
               Delete
            </a>

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