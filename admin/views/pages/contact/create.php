<?php include 'views/partials/header.php'; ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create Contact</h4>
                    <p class="card-description">
                        Create a new contact
                    </p>
                    <form class="forms-sample" method="POST" action="" enctype="multipart/form-data">
                        <!-- Display errors if any -->
                        <?php if (!empty($err)): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($err as $value): ?>
                                        <li><?php echo htmlspecialchars($value); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Email field -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input 
                                type="email" 
                                class="form-control" 
                                name="email" 
                                id="email" 
                                placeholder="Enter email" 
                                value="<?php echo isset($contactData['email']) ? htmlspecialchars($contactData['email']) : ''; ?>">
                        </div>

                        <!-- Created At field -->
                        <div class="form-group">
                            <label for="created_at">Created At</label>
                            <input 
                                type="date" 
                                class="form-control" 
                                name="created_at" 
                                id="created_at" 
                                value="<?php echo isset($contactData['created_at']) ? htmlspecialchars($contactData['created_at']) : ''; ?>">
                        </div>

                        <!-- Submit and Cancel buttons -->
                        <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                        <a href="contact" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vendor JS -->
<script src="views/vendors/js/vendor.bundle.base.js"></script>
<script src="views/vendors/typeahead.js/typeahead.bundle.min.js"></script>
<script src="views/vendors/select2/select2.min.js"></script>

<!-- Custom JS -->
<script src="views/js/file-upload.js"></script>
<script src="views/js/typeahead.js"></script>
<script src="views/js/select2.js"></script>

<?php include_once 'views/partials/_footer.php'; ?>
