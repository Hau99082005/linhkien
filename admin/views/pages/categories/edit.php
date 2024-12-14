<?php include 'views/partials/header.php'; ?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit categories</h4>
                    <p class="card-description">
                        Edit categories
                    </p>
                    <form class="forms-sample" method="POST" action="edit-categories?id=<?php echo $_GET['id']  ?>" enctype="multipart/form-data">
                        <?php if (!empty($err)): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($err as $key => $value): ?>
                                    <li><?php echo $value; ?></li>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="exampleInputName1">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" 
                            value="<?php echo isset($categoriesData['name']) ?  $categoriesData['name'] : ''; ?>">
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="categories"><span class="btn btn-light">Cancel</span></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="views/vendors/js/vendor.bundle.base.js"></script>
<script src="views/vendors/typeahead.js/typeahead.bundle.min.js"></script>
<script src="views/vendors/select2/select2.min.js"></script>


<script src="views/js/file-upload.js"></script>
<script src="views/js/typeahead.js"></script>
<script src="views/js/select2.js"></script>




<?php include_once 'views/partials/_footer.php'; ?>