<?php include 'views/partials/header.php'; ?>


<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create Product</h4>
                    <p class="card-description">
                        Create new product
                    </p>
                    <form class="forms-sample" method="POST" action="" enctype="multipart/form-data">
                        <?php if (!empty($err)): ?>
                            <div class="alert alert-danger">
                                <?php foreach ($err as $key => $value): ?>
                                    <li><?php echo $value; ?></li>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="form-group">
                            <label for="exampleInputName1">Name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputName1"
                                placeholder="Name" value="<?php echo isset($data['name']) ? htmlspecialchars($data['name']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label>File upload</label>
                            <input type="file" name="thumbnail" class="file-upload-default">
                            <div class="input-group col-xs-12">
                                <input type="text" name="thumbnailtext" class="form-control file-upload-info" disabled
                                    placeholder="Upload Image">
                                <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                              <label for="id_category">Category</label>
                             <select name="id_category" id="id_category" class="form-control">
                              <!-- Populate with categories from the database -->
                              <?php
                              $categories = Database::query("SELECT * FROM categories");
                             while ($category = $categories->fetch_assoc()) {
                                   $selected = isset($productData) && $productData['id_category'] == $category['id'] ? 'selected' : '';
                                    echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                                  }
                                 ?>
                                 </select>
                              </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" value="<?php echo isset($data['price']) ? htmlspecialchars($data['price']) : ''; ?>" class="form-control" name="price" id="price" placeholder="Price">
                        </div>
                        <div class="form-group">
                            <label for="status">status</label>
                            <input type="number" value="<?php echo isset($data['status']) ? htmlspecialchars($data['status']) : ''; ?>" class="form-control" name="status" id="status" placeholder="status">
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="product"><span class="btn btn-light">Cancel</span></a>
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