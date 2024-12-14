<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="views/vendors/feather/feather.css">
    <link rel="stylesheet" href="views/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="views/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="views/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="views/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="views/images/logo.svg" alt="logo">
                            </div>
                            <h4>Hello! let's get started</h4>
                            <h6 class="font-weight-light">Sign in to continue.</h6>
                            <form class="pt-3" method="post" action="">
                                <div class="form-group">
                                    <input type="number" name="phone" class="form-control form-control-lg" id="exampleInputEmail1"
                                        placeholder="0123456789">
                                </div>
                                <div class="mt-3">
                                    <button type="submit" name="submit" class="btn btn-primary mr-2">Sign In</button>
                                </div>
                                <h4 class="mt-3 text-danger " id="text-error"></h4>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="views/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="views/js/off-canvas.js"></script>
    <script src="views/js/hoverable-collapse.js"></script>
    <script src="views/js/template.js"></script>
    <script src="views/js/settings.js"></script>
    <script src="views/js/todolist.js"></script>
    <!-- endinject -->

    <script>
        document.getElementById('text-error').innerHTML = '<?= $error ?>';
    </script>
</body>

</html>