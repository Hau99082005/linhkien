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
                <h4 class="card-title">contact</h4>
                <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="description">email</th>
                        <th>created_at</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($contacts as $contact): ?>
                            <tr>
                                <td class="description"><?php echo $contact['email']; ?></td>
                                <td><?php echo $contact['created_at'] ?></td>
                                <td>
                                    <a href="edit-contact?id=<?php echo $contact['id']; ?>" class="btn btn-primary">Edit</a>
                                    <a href="delete-contact?id=<?php echo $contact['id']; ?>" class="btn btn-danger">Delete</a>
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