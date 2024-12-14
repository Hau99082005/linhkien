<?php 
 include 'config/connect.php';
 session_start();

 class cart {
    public $id, $name, $image, $price, $quantity;
    function __construct($id, $name, $image, $price, $quantity) {
      $this->id = $id;
      $this->name = $name;
      $this->image = $image;
      $this->price = $price;
      $this->quantity = $quantity;

    }
}
 function _header($title) {
    $s = '
    <!DOCTYPE html>
    <html lang="en">

   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>'.$title.'</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="css/slick.css" />
    <link type="text/css" rel="stylesheet" href="css/slick-theme.css" />
    <link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="css/style.css" />

     </head>

     <body>
    ';
    echo $s;
 }

 function _navbar() {
    if(isset($_GET['id_product']))addtoCartProduct($_GET['id_product']);
    if(isset($_GET['clear']))unset($_SESSION['cart']);
    $total = 0.0;
    // Xử lý xóa từng sản phẩm
    if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
        $deleteIndex = (int)$_GET['delete'];
        if (isset($_SESSION['cart'][$deleteIndex])) {
            unset($_SESSION['cart'][$deleteIndex]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reset lại index
        }
    }
    // Xử lý cập nhật số lượng
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_cart'])) {
        foreach ($_POST['quantities'] as $index => $quantity) {
            if (isset($_SESSION['cart'][$index]) && is_numeric($quantity) && $quantity > 0) {
                $_SESSION['cart'][$index]->quantity = (int)$quantity;
            }
        }
    }
    // Tính tổng tiền
    if (isset($_SESSION['cart'])) {
        $a = $_SESSION['cart'];
        foreach ($a as $item) {
            $item_total = $item->quantity * $item->price * 1000;
            $total += $item_total;
        }
    }
    $s = '
    <header>
        <div id="top-header" style="background: #fff;">
            <div class="container">
                <ul class="header-links pull-left">
                    <li><a href="#" style="color: #000;"><i class="fa fa-phone" style="color: #000;"></i> +021-95-51-84</a></li>
                    <li><a href="#" style="color: #000;"><i class="fa fa-envelope-o" style="color: #000;"></i> email@email.com</a></li>
                    <li><a href="#" style="color: #000;"><i class="fa fa-map-marker" style="color: #000;"></i> 1734 Stonecoal Road</a></li>
                </ul>
                <ul class="header-links pull-right">';
                    if(!isset($_SESSION['user']))
                    $s .= '<li><a href="dangnhap.php" style="color: #000;"><i class="fa fa-user-o"></i> My Account</a></li>';
                    else 
                    $s .= '<li><i class="fa fa-user-o"></i>Chào <p style="color: #000;">'.splitName($_SESSION['user']['name']).'</p>
                           <a class="fa fa-sign-out" style="color: #000;" href="dangxuat.php"></a>
                         </li>';
                $s .= '</ul>
            </div>
        </div>
        <div id="header">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <!-- LOGO -->
                    <div class="col-md-3">
                        <div class="header-logo">
                            <a href="index.php" class="logo">
                                <img src="./img/logo.png" alt="">
                            </a>
                        </div>
                    </div>
                    <!-- /LOGO -->

                    <!-- SEARCH BAR -->
                    <div class="col-md-6">
                        <div class="header-search">
                            <form>
                                <select class="input-select">';
                                 $q = Database::query("SELECT * FROM `categories`");
                                 while($r = $q->fetch_array()) {
									$s .= '<option value="">
                                      <a href="index.php?id_category=' . $r['id'] . '">'.$r['name'].'</a>
                                    </option>';
                                 }
									$s .= '</select>
                                <input class="input" placeholder="Search here">
                                <button class="search-btn">Search</button>
                            </form>
                        </div>
                    </div>
                    <!-- /SEARCH BAR -->

                    <!-- ACCOUNT -->
                    <div class="col-md-3 clearfix">
                        <div class="header-ctn">
                            <!-- Cart -->
                            <div class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span>Your Cart</span>
                                    <div class="qty">';
                                    if(!isset($_SESSION['cart'])) $s .= '0';
                                    else $s.= count($_SESSION['cart']);
                                    $s .='</div>
                                </a>
                                <div class="cart-dropdown">
                                    <div class="cart-list">';
                                    if (isset($_SESSION['cart'])) {
                                        $a = $_SESSION['cart'];
                                        foreach ($a as $index => $item) {
                                        $item_total = $item->quantity * $item->price * 1000;
                                        $s .= '<div class="product-widget">
                                            <div class="product-img">
                                                <img src="img/'.$item->image.'" alt="">
                                            </div>
                                            <div class="product-body">
                                                <h3 class="product-name"><p>'.$item->name.'</p></h3>
                                                <h4 class="product-price"><span class="qty">'.$item->quantity.'x</span>$'.$item->price.'</h4>
                                            </div>
                                             <a href="index.php?delete='.$index.'" class="delete"><i class="fa fa-close"></i></a>
                                        </div>';
                                        }
                                    }
                                    $s .= '</div>
                                    <div class="cart-summary">
                                        <h5>SUBTOTAL: '.number_format($total).'</h5>
                                    </div>
                                    <div class="cart-btns">
                                        <a href="checkout.php">Thanh Toán  <i class="fa fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Cart -->

                            <!-- Menu Toogle -->
                            <div class="menu-toggle">
                                <a href="#">
                                    <i class="fa fa-bars"></i>
                                    <span>Menu</span>
                                </a>
                            </div>
                            <!-- /Menu Toogle -->
                        </div>
                    </div>
                    <!-- /ACCOUNT -->
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- /MAIN HEADER -->
    </header>
     <nav id="navigation">
        <!-- container -->
        <div class="container">
            <!-- responsive-nav -->
            <div id="responsive-nav">
                <!-- NAV -->
                <ul class="main-nav nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>';
                $q = Database::query("SELECT * FROM `categories`");
                while($r = $q->fetch_array()) {
                    $s .= '<li><a href="index.php?id_category= '.$r['id'].'">'.$r['name'].'</a></li>';
                }
                $s .= '</ul>
                <!-- /NAV -->
            </div>
            <!-- /responsive-nav -->
        </div>
        <!-- /container -->
    </nav>
    ';
    echo $s;
 }

 function _section() {
    $s = '
     <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- shop -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="./img/shop01.png" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>Laptop<br>Collection</h3>
                            <a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /shop -->

                <!-- shop -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="./img/shop03.png" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>Accessories<br>Collection</h3>
                            <a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /shop -->

                <!-- shop -->
                <div class="col-md-4 col-xs-6">
                    <div class="shop">
                        <div class="shop-img">
                            <img src="./img/shop02.png" alt="">
                        </div>
                        <div class="shop-body">
                            <h3>Cameras<br>Collection</h3>
                            <a href="#" class="cta-btn">Shop now <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <!-- /shop -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    ';
    echo $s;
 }

 function _product() {
    $s = '
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">New Products</h3>
                        <div class="section-nav">
                            <ul class="section-tab-nav tab-nav">';
    $q = Database::query("SELECT * FROM `categories`");
    if ($q) {
        while ($r = $q->fetch_array()) {
            if ($r) {
                $s .= '<li><a data-toggle="tab" href="index.php?id_category=' . intval($r['id']) . '">' .$r['name'].'</a></li>';
            }
        }
    }

    $s .= '</ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <!-- tab -->
                            <div id="tab1" class="tab-pane active">
                                <div class="products-slick" data-nav="#slick-nav-1">';
    $query = "SELECT * FROM `products` WHERE status=true ";
    if (isset($_GET['id_category']) && is_numeric($_GET['id_category'])) {
        $query .= "AND id_category=" . intval($_GET['id_category']) . " ";
    }
    $query .= "ORDER BY RAND() LIMIT 4";
    $q1 = Database::query($query);
    if ($q1) {
        while ($r1 = $q1->fetch_array()) {
            if ($r1) {
                $s .= '<div class="product">
                            <div class="product-img">
                                <img src="img/'.$r1['image'].'" alt="">
                            </div>
                            <div class="product-body">
                                <h3 class="product-name"><a href="#">'.$r1['name'].'</a></h3>
                                <h4 class="product-price">$'.$r1['price'].'</h4>
                                <div class="product-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                            </div>
                            <div class="add-to-cart">
                                <a href="';
                if (!isset($_SESSION['user'])) {
                    $s .= 'dangnhap.php';
                } else {
                    $s .= 'index.php?id_product=' . intval($r1['id']);
                }
                $s .= '" class="add-to-cart-btn" style="height: 50px;"><i class="fa fa-shopping-cart"></i> add to cart</a>
                            </div>
                        </div>';
            }
        }
    }

    $s .= '</div>
                                <div id="slick-nav-1" class="products-slick-nav"></div>
                            </div>
                            <!-- /tab -->
                        </div>
                    </div>
                </div>
                <!-- Products tab & slick -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->';

    echo $s;
}

 function _deal() {
    $s = '
     <div id="hot-deal" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="hot-deal">
                        <ul class="hot-deal-countdown">
                            <li>
                                <div>
                                    <h3>02</h3>
                                    <span>Days</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3>10</h3>
                                    <span>Hours</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3>34</h3>
                                    <span>Mins</span>
                                </div>
                            </li>
                            <li>
                                <div>
                                    <h3>60</h3>
                                    <span>Secs</span>
                                </div>
                            </li>
                        </ul>
                        <h2 class="text-uppercase">hot deal this week</h2>
                        <p>New Collection Up to 50% OFF</p>
                        <a class="primary-btn cta-btn" href="#">Shop now</a>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /HOT DEAL SECTION -->

    <!-- SECTION -->
    ';
    echo $s;
 }

 function _top() {
    $s = '
     <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="title">Top selling</h3>
                        <div class="section-nav">
                            <ul class="section-tab-nav tab-nav">';
                            $q = Database::query("SELECT * FROM `categories`");
                            while($r = $q->fetch_array()) {
                                $s .= '<li><a data-toggle="tab" href="#tab2">'.$r['name'].'</a></li>';
                            }
                            $s .= '</ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="products-tabs">
                            <div id="tab2" class="tab-pane fade in active">
                                <div class="products-slick" data-nav="#slick-nav-2">';
                                  $q1 = Database::query("SELECT * FROM `products`");
                                  while($r1 = $q1->fetch_array()) {
                                    $s .= '<div class="product">
                                        <div class="product-img">
                                            <img src="img/'.$r1['image'].'" alt="">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name"><a href="#">'.$r1['name'].'</a></h3>
                                            <h4 class="product-price">$'.$r1['price'].'</h4>
                                            <div class="product-rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="product-btns">
                                                <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                                                <button class="add-to-compare"><i class="fa fa-exchange"></i><span class="tooltipp">add to compare</span></button>
                                                <button class="quick-view"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                                            </div>
                                        </div>
                                        <div class="add-to-cart">
                                           <a href="';
                if (!isset($_SESSION['user'])) {
                    $s .= 'dangnhap.php';
                } else {
                    $s .= 'index.php?id_product=' . intval($r1['id']);
                }
                $s .= '" class="add-to-cart-btn"><i class="fa fa-shopping-cart"></i> add to cart</a>
                                        </div>
                                    </div>';
                                  }
                                $s .= '</div>
                                <div id="slick-nav-2" class="products-slick-nav"></div>
                            </div>
                            <!-- /tab -->
                        </div>
                    </div>
                </div>
                <!-- /Products tab & slick -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-4 col-xs-6">
                    <div class="section-title">
                        <h4 class="title">Top selling</h4>
                        <div class="section-nav">
                            <div id="slick-nav-3" class="products-slick-nav"></div>
                        </div>
                    </div>

                    <div class="products-widget-slick" data-nav="#slick-nav-3">
                        <div>';
                         $q1 = Database::query("SELECT * FROM `products` ORDER BY RAND() LIMIT 3");
                         while($r1 = $q1->fetch_array()) {
                            $s .= '<div class="product-widget">
                                <div class="product-img">
                                    <img src="img/'.$r1['image'].'" alt="">
                                </div>
                                <div class="product-body">
                                    <h3 class="product-name"><a href="';
                if (!isset($_SESSION['user'])) {
                    $s .= 'dangnhap.php';
                } else {
                    $s .= 'index.php?id_product=' . intval($r1['id']);
                }
                $s .= '">'.$r1['name'].'</a></h3>
                                    <h4 class="product-price">$'.$r1['price'].'</h4>
                                </div>
                            </div>';
                         }
                        $s .= '</div>

                        <div>';
                           $q1 = Database::query("SELECT * FROM `products` ORDER BY RAND() LIMIT 3");
                           while($r1 = $q1->fetch_array()) {
                            $s .= '<div class="product-widget">
                                <div class="product-img">
                                    <img src="img/'.$r1['image'].'" alt="">
                                </div>
                                <div class="product-body">
                                    <h3 class="product-name"><a href="';
                if (!isset($_SESSION['user'])) {
                    $s .= 'dangnhap.php';
                } else {
                    $s .= 'index.php?id_product=' . intval($r1['id']);
                }
                $s .= '">'.$r1['name'].'</a></h3>
                                    <h4 class="product-price">$'.$r1['price'].'</h4>
                                </div>
                            </div>';
                           }
                        $s .= '</div>
                    </div>
                </div>

                <div class="col-md-4 col-xs-6">
                    <div class="section-title">
                        <h4 class="title">Top selling</h4>
                        <div class="section-nav">
                            <div id="slick-nav-4" class="products-slick-nav"></div>
                        </div>
                    </div>
                    <div class="products-widget-slick" data-nav="#slick-nav-4">
                         <div>';
                           $q1 = Database::query("SELECT * FROM `products` ORDER BY RAND() LIMIT 3");
                           while($r1 = $q1->fetch_array()) {
                            $s .= '<div class="product-widget">
                                <div class="product-img">
                                    <img src="img/'.$r1['image'].'" alt="">
                                </div>
                                <div class="product-body">
                                    <h3 class="product-name"><a href="';
                if (!isset($_SESSION['user'])) {
                    $s .= 'dangnhap.php';
                } else {
                    $s .= 'index.php?id_product=' . intval($r1['id']);
                }
                $s .= '">'.$r1['name'].'</a></h3>
                                    <h4 class="product-price">$'.$r1['price'].'</h4>
                                </div>
                            </div>';
                           }
                        $s .= '</div>

                        <div>';
                           $q1 = Database::query("SELECT * FROM `products` ORDER BY RAND() LIMIT 3");
                           while($r1 = $q1->fetch_array()) {
                            $s .= '<div class="product-widget">
                                <div class="product-img">
                                    <img src="img/'.$r1['image'].'" alt="">
                                </div>
                                <div class="product-body">
                                    <h3 class="product-name"><a href="';
                if (!isset($_SESSION['user'])) {
                    $s .= 'dangnhap.php';
                } else {
                    $s .= 'index.php?id_product=' . intval($r1['id']);
                }
                $s .= '">'.$r1['name'].'</a></h3>
                                    <h4 class="product-price">$'.$r1['price'].'</h4>
                                </div>
                            </div>';
                           }
                        $s .= '</div>
                    </div>
                </div>
                <div class="clearfix visible-sm visible-xs"></div>

                <div class="col-md-4 col-xs-6">
                    <div class="section-title">
                        <h4 class="title">Top selling</h4>
                        <div class="section-nav">
                            <div id="slick-nav-5" class="products-slick-nav"></div>
                        </div>
                    </div>

                    <div class="products-widget-slick" data-nav="#slick-nav-5">
                      <div>';
                           $q1 = Database::query("SELECT * FROM `products` ORDER BY RAND() LIMIT 3");
                           while($r1 = $q1->fetch_array()) {
                            $s .= '<div class="product-widget">
                                <div class="product-img">
                                    <img src="img/'.$r1['image'].'" alt="">
                                </div>
                                <div class="product-body">
                                    <h3 class="product-name"><a href="';
                if (!isset($_SESSION['user'])) {
                    $s .= 'dangnhap.php';
                } else {
                    $s .= 'index.php?id_product=' . intval($r1['id']);
                }
                $s .= '">'.$r1['name'].'</a></h3>
                                    <h4 class="product-price">$'.$r1['price'].'</h4>
                                </div>
                            </div>';
                           }
                        $s .= '</div>

                   <div>';
                           $q1 = Database::query("SELECT * FROM `products` ORDER BY RAND() LIMIT 3");
                           while($r1 = $q1->fetch_array()) {
                            $s .= '<div class="product-widget">
                                <div class="product-img">
                                    <img src="img/'.$r1['image'].'" alt="">
                                </div>
                                <div class="product-body">
                                    <h3 class="product-name"><a href="';
                if (!isset($_SESSION['user'])) {
                    $s .= 'dangnhap.php';
                } else {
                    $s .= 'index.php?id_product=' . intval($r1['id']);
                }
                $s .= '">'.$r1['name'].'</a></h3>
                                    <h4 class="product-price">$'.$r1['price'].'</h4>
                                </div>
                            </div>';
                           }
                        $s .= '</div>
                    </div>
                </div>

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->

    <!-- NEWSLETTER -->
    <div id="newsletter" class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="newsletter">
                        <p>Sign Up for the <strong>NEWSLETTER</strong></p>';
                         // Xử lý form email php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if (!$email) {
            $s .= "<script>displayNotification('Email không hợp lệ!', 'error');</script>";
        } else {
            $email = Database::getConnection()->real_escape_string($email);
            $sql = "INSERT INTO contacts (email) VALUES ('$email')";
            if (Database::query($sql) === TRUE) {
                $s .= "<script>displayNotification('Liên hệ đã gửi thành công!', 'success');</script>";
            } else {
                $s .= "<script>displayNotification('Lỗi: " . Database::getConnection()->error . "', 'error');</script>";
            }
        }
    }
                        $s .= '<form action="" method="POST">
                            <input class="input" name="email" type="email" placeholder="Enter Your Email">
                            <button type="submit" class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
                        </form>';
                        $s .= '<ul class="newsletter-follow">
                            <li>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fa fa-pinterest"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /NEWSLETTER -->
    ';
    echo $s;
 }

 function login(){
    if (isset($_POST['emailphone']) && isset($_POST['password'])) {
        if (is_numeric($_POST['emailphone'])) {
            $x = 'phone';
        } else {
            $x = 'email';
        }
        
        $q = Database::query("SELECT * FROM users WHERE $x = '{$_POST['emailphone']}' AND password = '{$_POST['password']}'");
        if ($r = $q->fetch_array()) {
            if ($r['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                $_SESSION['user'] = $r;
                if (isset($_POST['remember_me'])) {
                    setcookie('emailphone', $_POST['emailphone'], time() + (86400 * 30), "/"); 
                    setcookie('password', $_POST['password'], time() + (86400 * 30), "/"); 
                } else {
                    setcookie('emailphone', '', time() - 3600, "/");
                    setcookie('password', '', time() - 3600, "/");
                }
                
                header("Location: index.php");
            }
        } else {
            $_SESSION['login_fail'] = 'Dữ liệu nhập không chính xác!!!';
            header("Location: dangnhap.php");
        }
    }

    $saved_emailphone = isset($_COOKIE['emailphone']) ? $_COOKIE['emailphone'] : '';
    $saved_password = isset($_COOKIE['password']) ? $_COOKIE['password'] : '';

    $s = '
    <section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5">
            <img src="assets/images/Đặt Hàng Ngay (1).png"
            class="img-fluid" alt="Sample image">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form action="" method="post">
            <h2 style="padding: 40px 0 25px 0">Đăng Nhập</h2>';
           if (isset($_SESSION['login_fail'])) {
               $s .= '<div style="color: red;">'.$_SESSION['login_fail'].'</div>';
               unset($_SESSION['login_fail']); 
           }
           
            $s .= '<!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
                <input type="text" name="emailphone" class="form-control form-control-lg"
                placeholder="Nhập vào số điện thoại của bạn" value="' . htmlspecialchars($saved_emailphone) . '" style="width: 50%;"/>
            </div>
            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-3">
                <input type="password" name="password" class="form-control form-control-lg"
                placeholder="Nhập vào mật khẩu" id="password" value="' . htmlspecialchars($saved_password) . '" style="width: 50%;"/>
                <button type="button" onclick="togglePassword()" class="btn btn-secondary btn-sm mt-2">Hiện/Ẩn mật khẩu</button>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <!-- Remember Me Checkbox -->
                <div class="form-check mb-0">
                    <input class="form-check-input me-2" type="checkbox" name="remember_me" value="1" id="form2Example3"' . (!empty($saved_emailphone) ? ' checked' : '') . ' />
                    <label class="form-check-label" for="form2Example3">
                        ghi nhớ mật khẩu
                    </label>
                </div>
                <a href="#!" class="text-body">Quên mật khẩu?</a>
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng nhập</button>
                <p class="small fw-bold mt-2 pt-1 mb-0">bạn chưa có tài khoản? <a href="dangky.php"
                    class="link-danger">đăng ký</a></p>
            </div>
            </form>
        </div>
        </div>
    </div>
    
    </section>

    <script>
    function togglePassword() {
        var passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
    }
    </script>
    ';

    echo $s;
}

function _checkout() {
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $total = 0;
    foreach ($cart as $item) {
        $total += $item->quantity * $item->price * 1000;
    }
    $s = '
    <div class="section">
			<div class="container">
            <form action="process_order.php" method="post">
				<div class="row">
					<div class="col-md-7">
						<!-- Billing Details -->
						<div class="billing-details">
							<div class="section-title">
								<h3 class="title">Chi Tiết Thanh Toán</h3>
							</div>
							<div class="form-group">
								  <p>Họ Tên <span>*</span></p>
                                <input type="text" class="input" name="name" required>
							</div>
							<div class="form-group">
								 <p>Địa Chỉ <span>*</span></p>
                                <input type="text" class="input" name="address" placeholder="Nhập địa chỉ của bạn" required>
							</div>
							<div class="form-group">
								   <p>Số điện thoại <span>*</span></p>
                                <input type="text" class="input" name="phone" required>
							</div>
							<div class="form-group">
								 <p>Ghi chú</p>
                                <input type="text" class="input" name="note" placeholder="Ghi chú về đơn hàng (nếu có)">
							</div>
						</div>
					</div>
					<div class="col-md-5 order-details">
						<div class="section-title text-center">
							<h3 class="title">Your Order</h3>
						</div>
						<div class="order-summary">
							<div class="order-col">
								<div><strong>PRODUCT</strong></div>
								<div><strong>TOTAL</strong></div>
							</div>
							<div class="order-products">';
                            foreach ($cart as $item) {
                                $item_total = $item->quantity * $item->price * 1000;
								$s .= '<div class="order-col">
									<div>'.$item->quantity.'x'.$item->name.'</div>
									<div>$'.number_format($item_total).'</div>
								</div>';
                            }
							$s .= '</div>';
							$s .= '<div class="order-col">
								<div><strong>TOTAL</strong></div>
								<div><strong class="order-total">$'.number_format($total).'</strong></div>
							</div>';
						$s .= '</div>
						 <button type="submit" class="primary-btn order-submit">Đặt Đơn</button>
					</div>
					<!-- /Order Details -->
				</div>
				<!-- /row -->
            </form>
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->
    ';
    echo $s;
}

 function splitName($str){
        $rs = NULL;
        $word = mb_split(' ', $str);
        $n = count($word)-1;
        if ($n > 0) {$rs = $word[$n];}

        return $rs;
}
function register(){
    $errName = $errPhone = $errPass = $errRepass = '';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (empty($_POST['name'])) {
            $errName = "Vui lòng nhập vào tên của bạn!";
        }
        if (empty($_POST['phone'])) {
            $errPhone = "Cần có 1 số điện thoại!";
        } else {
            if (!preg_match('/^\d{10}$/', $_POST['phone'])) {
                $errPhone = "Số điện thoại phải có đúng 10 chữ số!";
            } else {
                $phoneCheckQuery = "SELECT COUNT(*) FROM users WHERE phone='" . $_POST['phone'] . "'";
                $phoneCheckResult = Database::query($phoneCheckQuery);
                $phoneExists = $phoneCheckResult->fetch_array()[0];

                if ($phoneExists > 0) {
                    $errPhone = "Số điện thoại đã tồn tại!";
                }
            }
        }
        if (empty($_POST['pass'])) {
            $errPass = "Vui lòng nhập mật khẩu!";
        }
        if (empty($_POST['repass'])) {
            $errRepass = "Vui lòng xác nhận mật khẩu!";
        } else {
            if ($_POST['pass'] != $_POST['repass']) {
                $errRepass = "Mật khẩu không khớp!";
            }
        }
        if ($errName == '' && $errPhone == '' && $errPass == '' && $errRepass == '') {
            $insertQuery = "INSERT INTO users(name, phone, password, role) VALUES('".$_POST['name']."', '".$_POST['phone']."', '".$_POST['pass']."', '')";
            Database::query($insertQuery);
            $userQuery = "SELECT * FROM users WHERE phone='" . $_POST['phone'] . "' AND password='" . $_POST['pass'] . "'";
            $userResult = Database::query($userQuery);
            $_SESSION['user'] = $userResult->fetch_array();
            header("location: index.php");
        }
    }

    $s = '
        <section class="vh-80" style="background-color: #eee; border: none; border-radius: none;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-12 col-xl-11">
                <div class="card text-black" style="border-radius: 25px;">
                <div class="card-body p-md-3">
                    <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                        <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Đăng Ký</p>

                        <form class="mx-1 mx-md-4" action="" method="post">

                        <div class="d-flex flex-row align-items-center mb-3">
                            <i class="fa fa-user"></i>
                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                            <label class="form-label" for="form3Example1c">Tên của bạn</label>
                            <input type="text" name="name" class="form-control" />
                            <span style="color: red;">'.$errName.'</span>
                            </div>
                        </div>
                        <div class="d-flex flex-row align-items-center mb-3">
                            <i class="fa fa-envelope"></i>
                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                            <label class="form-label" for="form3Example3c">Số điện thoại của bạn</label>
                            <input type="text" name="phone" class="form-control" />
                            <span style="color: red;">'.$errPhone.'</span>
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-3">
                            <i class="fa fa-lock"></i>
                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                            <label class="form-label" for="form3Example4c">Mật Khẩu</label>
                            <input type="password" id="pass" name="pass" class="form-control" />
                            <span style="color: red;">'.$errPass.'</span>
                            <input type="checkbox" onclick="togglePassword(\'pass\')"> Hiển thị mật khẩu
                            </div>
                        </div>

                        <div class="d-flex flex-row align-items-center mb-3">
                            <i class="fa fa-key"></i>
                            <div data-mdb-input-init class="form-outline flex-fill mb-0">
                            <label class="form-label" for="form3Example4cd">Xác nhận mật khẩu</label>
                            <input type="password" id="repass" name="repass" class="form-control" />
                            <span style="color: red;">'.$errRepass.'</span>
                            <input type="checkbox" onclick="togglePassword(\'repass\')"> Hiển thị mật khẩu
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg">Đăng ký</button>
                        </div>

                        </form>

                    </div>
                    <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                        <img src="assets/images/Đặt Hàng Ngay (2).png"
                        class="img-fluid" alt="Sample image">
                    </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </section>
        
        <script>
        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
            } else {
                field.type = "password";
            }
        }
        </script>
    ';
    echo $s;
}

 function _footer() {
    $s = '
     <footer id="footer">
        <!-- top footer -->
        <div class="section">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">About Us</h3>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>
                            <ul class="footer-links">
                                <li><a href="#"><i class="fa fa-map-marker"></i>1734 Stonecoal Road</a></li>
                                <li><a href="#"><i class="fa fa-phone"></i>+021-95-51-84</a></li>
                                <li><a href="#"><i class="fa fa-envelope-o"></i>email@email.com</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Categories</h3>
                            <ul class="footer-links">
                                <li><a href="#">Hot deals</a></li>
                                <li><a href="#">Laptops</a></li>
                                <li><a href="#">Smartphones</a></li>
                                <li><a href="#">Cameras</a></li>
                                <li><a href="#">Accessories</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="clearfix visible-xs"></div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Information</h3>
                            <ul class="footer-links">
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Orders and Returns</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-3 col-xs-6">
                        <div class="footer">
                            <h3 class="footer-title">Service</h3>
                            <ul class="footer-links">
                                <li><a href="#">My Account</a></li>
                                <li><a href="#">View Cart</a></li>
                                <li><a href="#">Wishlist</a></li>
                                <li><a href="#">Track My Order</a></li>
                                <li><a href="#">Help</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /top footer -->

        <!-- bottom footer -->
        <div id="bottom-footer" class="section">
            <div class="container">
                <!-- row -->
                <div class="row">
                    <div class="col-md-12 text-center">
                        <ul class="footer-payments">
                            <li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
                            <li><a href="#"><i class="fa fa-credit-card"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
                            <li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
                        </ul>
                        <span class="copyright">
								<!-- Link back to Colorlib cant be removed. Template is licensed under CC BY 3.0. -->
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
							<!-- Link back to Colorlib cant be removed. Template is licensed under CC BY 3.0. -->
							</span>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /bottom footer -->
    </footer>
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/nouislider.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/main.js"></script>

</body>

</html>
    ';
    echo $s;
 }
 function addtoCartProduct($id_product) {
    $q = Database::query("SELECT * FROM `products` WHERE id =". $id_product);
    $r = $q->fetch_array();
    if(isset($_SESSION['cart'])) {
        $a = $_SESSION['cart'];
        for($i = 0; $i <count($a); $i++) 
            if($r['id']==$a[$i]->id)break;
        if($i<count($a))$a[$i]->quantity++;
        else  $a[count($a)] = new cart($r['id'], $r['name'], $r['image'], $r['price'], 1);
        
    }else {
        $a = array();
        $a[0] = new cart($r['id'], $r['name'], $r['image'], $r['price'], 1);
    }
    $_SESSION['cart'] = $a;
}
?>