<?php 
require("includes/database.php");
session_start();
if(isset($_SESSION["email"])) {
    $localEmail = $_SESSION['email'];
} else {
    header("location: signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen Menu</title>
    <link rel="stylesheet" href="css/basic.css" type="text/css" />
    <link rel="stylesheet" href="css/cart.css" type="text/css" />
    <link rel="stylesheet" href="CDN/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- ICON -->
    <link rel="apple-touch-icon" sizes="180x180" href="images/siteImages/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/siteImages/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/siteImages/favicon-16x16.png">
    <link rel="manifest" href="images/siteImages/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark static-top" style="background-color: #e23744">
    <div class="container">
      <a class="navbar-brand" href="http://localhost/Canteen/"><img src="images/siteImages/android-chrome-192x192.png" width="35" height="35" class="d-inline-block align-top" alt=""> Canteen Menu</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="http://localhost/Canteen/">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <?php
          if(!isset($_SESSION['email'])) {
                echo "
            <li class='nav-item'><a class='nav-link' href='signin.php'>Sign In</a></li>
            <li class='nav-item'><a class='nav-link' href='signup.php'>Sign Up</a></li>";
            } else {
                echo "
            <li class='nav-item'><a class='nav-link' href='dashboard.php'>Dashboard</a></li>
            <li class='nav-item'>
            <a href='wallet.php' class='nav-link'><i class='fas fa-wallet'></i>"; ?>
            <?php
                $selUserPurchased = mysqli_query($conn, "SELECT * FROM client WHERE email='$localEmail'");
                if(mysqli_num_rows($selUserPurchased) > 0) {
                        $getAmount = mysqli_fetch_assoc($selUserPurchased);
                        echo $getAmount['wallet']. '₹';
                }
            ?>
            <?php
            echo "</a>
            </li>
            <li class='nav-item'><a class='nav-link' href='cart.php'><i class='fas fa-shopping-cart'></i></a></li>
            <li class='nav-item'><a class='nav-link' href='logout.php'>Sign Out</a></li>";
            }
            ?>
            <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
            </li>
        </ul>
      </div>
      </div>
    </nav>

        <!-- Purchased -->
        <?php
            if(isset($_REQUEST['purchased'])) {
                $selUserCart = mysqli_query($conn, "SELECT * FROM cart WHERE email = '$localEmail'");
                if(mysqli_num_rows($selUserCart) > 0) {
                    while($retrieveCart = mysqli_fetch_assoc($selUserCart)) {
                        $getWallet = mysqli_query($conn, "SELECT * FROM client WHERE email = '$localEmail'");
                        if(mysqli_num_rows($getWallet) > 0) {
                            while($retrieveWallet = mysqli_fetch_assoc($getWallet)) {
                            $iid = $retrieveCart['iid'];
                            $email = $retrieveCart['email'];
                            $image = $retrieveCart['image'];
                            $arttitle = $retrieveCart['arttitle'];
                            $artprice = $retrieveCart['artprice'];
                            $userWallet = $retrieveWallet['wallet'];
                            $date = date('d/m/y',time());
                            if($userWallet < $artprice) {
                                echo "<script>alert('Not Sufficient Cash.')</script>";
                            } else {
                            $userMinusWallet = $userWallet - $artprice;
                            $foodid = rand();
                            $insertCarttoPurchased = "INSERT INTO foodorder(fid, iid, email, image, title, price, status, date) VALUES 
                            ('$foodid', '$iid', '$email', '$image', '$arttitle', '$artprice', 'Pending', '$date')";
                            if(!mysqli_query($conn, $insertCarttoPurchased)) {
                                echo "<script>alert('Something Went Wrong')</script>";
                            }
                            $insertWalletMoney = "UPDATE client SET wallet = '$userMinusWallet' WHERE email = '$email'";
                            if(!mysqli_query($conn, $insertWalletMoney)) {
                                echo "<script>alert('Something Went Wrong')</script>";
                            }
                            
                            $adminWallet = mysqli_query($conn, "SELECT * FROM admin");
                            if(mysqli_num_rows($adminWallet) > 0){
                                $retrieveAdminWallet = mysqli_fetch_assoc($adminWallet)['wallet'] + $artprice;
                                if(!mysqli_query($conn, "UPDATE admin SET wallet='$retrieveAdminWallet'")) {
                                    echo "<script>alert('Something Went Wrong')</script>";
                                }
                            }

                            $removeIt = "DELETE FROM cart WHERE email='$email'";
                            if(!mysqli_query($conn, $removeIt)) {
                                echo "<script>alert('Something Went Wrong')</script>";
                            }}
                        }
                    }
            } } else {
                echo "<script>alert('Nothing in Cart')</script>";
            }
        }
        ?>

        <!-- User Cart -->
        <div style="margin: 10px">
        <h2>Cart</h2>
        <hr />
        <div class="row">
            <div class="col-md-6">
                <div>Items</div>
            </div>
            <div class="col-md-2">
                <div>Type</div>
            </div>
            <div class="col-md-2">
                <div>Amount</div>
            </div>
            <div class="col-md-2">
                <div>Remove</div>
            </div>
        </div>
        <br />
        <?php 
            if(isset($_REQUEST['removeCart'])) {
                $getUser = trim(htmlspecialchars(stripslashes($_REQUEST['getUser'])));
                $getToremove = trim(htmlspecialchars(stripslashes($_REQUEST['getToremove'])));
                $removeIt = "DELETE FROM cart WHERE iid='$getToremove' and uid='$getUser'";
                if(!mysqli_query($conn, $removeIt)) {
                    echo "<script>alert('Something Went Wrong.')</script>";
                }
            }
            $selUserCart = mysqli_query($conn, "SELECT * FROM cart WHERE email = '$localEmail'");
            if(mysqli_num_rows($selUserCart) > 0) {
                while($retrieveCart = mysqli_fetch_assoc($selUserCart)) {
                echo "
                    <div class='row' style='margin: 10px'>
                    <div class='col-md-6'>
                        <a href='menu.php?img=". $retrieveCart['iid'] ."&imgname=". $retrieveCart['arttitle'] ."'><div><img src='".$retrieveCart['image']."' alt='Product Image' style='border: 1px solid grey; padding: 5px; border-radius: 5px; box-shadow: 1px 1px 10px grey' width=80 height=80><span style='font-weight: bold'> Title: </span>".$retrieveCart['arttitle']."</div></a>
                    </div>
                    <div class='col-md-2'>
                        <div>".$retrieveCart['foodType']."</div>
                    </div>
                    <div class='col-md-2'>
                    <div>₹".$retrieveCart['artprice'].".00</div>
                    </div>
                    <div class='col-md-2'>
                    <form action='' method='post'>
                    <input type='hidden' name='getUser' value='". $retrieveCart['uid'] ."' />
                    <input type='hidden' name='getToremove' value='". $retrieveCart['iid'] ."' />
                    <input type='submit' name='removeCart' class='btn btn-danger' value='Remove' />
                    </form>
                    </div>
                    </div>       
                ";}
            } else {
                echo "<div style='text-align: center; font-weight: bold'>Nothing in Cart</div>";
            }
            $selUserCartTotalAmount = mysqli_query($conn, "SELECT * FROM cart WHERE email = '$localEmail'");
            echo "
                    <hr />
                    <div class='row' style='margin: 10px'>
                    <div class='col-md-6'>
                    <a href='index.php' class='btn btn-warning'>Continue Shopping</a>
                    </div>
                    <div class='col-md-2'>
                    <span style='font-weight: bold'>Total Amount:</span>
                    </div>
                    <div class='col-md-2'>
                    <div>₹";
            if(mysqli_num_rows($selUserCartTotalAmount) > 0) {
                $calculate = 0;
                while($retrieveCart = mysqli_fetch_assoc($selUserCartTotalAmount)) {
                $calculate = $calculate + $retrieveCart['artprice'];
                }
                echo $calculate;
            }
            echo ".00</div>
                </div>
                <div class='col-md-2'>
                <form action='' method='post'>
                <button type='submit' name='purchased' class='btn btn-success'>Place Order</button>
                </form>
                </div>
                </div>       
                ";
        ?>
    </div>
    
    <!-- Footer -->
    <?php require("includes/footer.php");?>