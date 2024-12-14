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
                <h4 class="card-title">Product</h4>
                <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="description">Name</th>
                        <th>image</th>
                        <th>id_products</th>
                        <th>status</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $product): ?>
                            <tr>
                                <td class="description"><?php echo $product['name']; ?></td>
                                <td><img src="<?php echo APPURL . "img/" . $product['image']; ?>" alt="" width="100"></td>
                                <td><?php echo intval($product['id_category']) ?></td>
                                <td><?php echo $product['status']; ?></td>
                                <td><?php echo $product['price']; ?></td>
                                <td>
                                    <a href="edit-product?id=<?php echo $product['id']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete-product?id=<?php echo $product['id']; ?>" class="btn btn-danger">Delete</a>
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