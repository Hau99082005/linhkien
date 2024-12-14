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
                <h4 class="card-title">categories</h4>
                <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="description">Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categoriess as $categories): ?>
                            <tr>
                                <td class="description"><?php echo $categories['name']; ?></td>
                                <td>
                                    <a href="edit-categories?id=<?php echo $categories['id']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete-categories?id=<?php echo $categories['id']; ?>" class="btn btn-danger">Delete</a>
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