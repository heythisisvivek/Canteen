<?php 
require("includes/database.php");
session_start();
if(isset($_SESSION["email"])) {
    $localEmail = $_SESSION['email'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen Menu</title>
    <link rel="stylesheet" href="css/basic.css" type="text/css" />
    <link rel="stylesheet" href="css/menu.css" type="text/css" />
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

    <!-- Menu -->
    <?php
    if(isset($_REQUEST['buyFood'])) {
        $localEmail = $_SESSION['email'];
        $imgid = $_REQUEST['img'];

        if(isset($localEmail)) {
            $getSellerInfo = mysqli_query($conn, "SELECT * FROM menu WHERE iid = '$imgid'");
            if(mysqli_num_rows($getSellerInfo) > 0) {
                $retreiveSellerInfo = mysqli_fetch_assoc($getSellerInfo);
                $userid = $retreiveSellerInfo['uid'];
                $imgtitle = $retreiveSellerInfo['imagetitle'];
                $userImageSold = $retreiveSellerInfo['userImage'];
                $imgprice = $retreiveSellerInfo['imageprice'];
                $foodType = $retreiveSellerInfo['foodType'];
                $insertArt = "INSERT INTO cart(iid, email, arttitle, image, foodType, artprice, item) VALUES ('$imgid', '$localEmail', '$imgtitle', '$userImageSold', '$foodType', '$imgprice', 1)";
                if(mysqli_query($conn, $insertArt)) {
                    echo "<script>alert('Added to Cart')</script>";
                } else {
                    echo "<script>alert('Something Went Wrong')</script>";
                }
            }
        } else {
            header("signin.php");
        }
    }

    if(isset($_REQUEST['removeFood'])) {
        $localEmail = $_SESSION['email'];
        $imgid = $_REQUEST['img'];

        if(isset($localEmail)) {
            $getUserCart = mysqli_query($conn, "SELECT * FROM cart WHERE email = '$localEmail' AND iid = '$imgid'");
            if(mysqli_num_rows($getUserCart) > 0) {
                $deleteImg = "DELETE FROM cart WHERE iid='$imgid'";
                if(mysqli_query($conn, $deleteImg)) {
                    echo "<script>alert('Removed from Cart')</script>";
                } else {
                    echo "<script>alert('Something Went Wrong')</script>";
                }
            }
        } else {
            header("location: http://localhost/Art%20Gallery/signin.php");
        }
    }
    if(isset($_REQUEST['img']) and isset($_REQUEST['imgname'])) {
        $imgid = $_REQUEST['img'];
        $getItemDetails = mysqli_query($conn, "SELECT * FROM menu WHERE iid='$imgid'");
        if(mysqli_num_rows($getItemDetails) > 0) {
            $getItemList = mysqli_fetch_assoc($getItemDetails);
        echo " 
        <div class='container' style='margin-top: 30px'>
        <div class='row'>
            <div class='col-md-5'>
                <div class='selectedImageContainer'>
                <img src='".$getItemList['userImage']."' style='padding: 5px; border-radius: 5px; border: 1px solid grey; box-shadow: 5px 5px 25px grey' class='selectedImage' alt='Images is Removed' width=400 height=300>
                </div>
            </div>
            <div class='col-md-7'>
                <h5 style='font-weight: bold'><i class='fas fa-concierge-bell'></i> ".$getItemList['imagetitle']."</h5>
                <hr />
                <h5><span style='font-weight: bold'>Description:</span> ".$getItemList['imagedescription']."</h5>
                <h5><span style='font-weight: bold'>Type:</span> ".$getItemList['foodType']."</h5>
            <hr />
            <div class='row'>
            <div class='col-md-6'>
            <h5 style='font-weight: bold'>Opening Hours</h5>
            Today 8am - 11pm (Delivered in 30 mins)
            </div>
            <div class='col-md-6'>
            </div>
            </div>
            <div style='margin: 10px 0'>
            ";

        if(isset($_SESSION['email'])) {
        $selCart = mysqli_query($conn, "SELECT * FROM cart WHERE email = '$localEmail' AND iid = '$imgid'");
        if(mysqli_num_rows($selCart) > 0) {
            echo "<form action='' method='post'><button type='submit' name='removeFood' class='btn btn-danger'>Remove from Cart ₹".$getItemList['imageprice']."</button></form><br /><br />";
        } else {
            echo "<form action='' method='post'><button type='submit' name='buyFood' class='btn btn-primary'>Add to Cart ₹".$getItemList['imageprice']."</button></form><br /><br />";
        } 
        } else {
            echo "<a href='signin.php' class='btn btn-danger'>Login First</a><br /><br />";
        }
        
        echo "
        </div>
        </div>
        </div>
        <hr />
        </div>
        ";} else {
            echo "Nothing Found";
        }
    } else {
        echo "
        <div class='container' style='padding: 20px'>
        <div class='row'>"; ?>
        <?php
          $selImage = "SELECT * FROM menu ORDER BY id";
          $queryImage = mysqli_query($conn, $selImage);
    
          if(mysqli_num_rows($queryImage) > 0) {
            while($retrieve = mysqli_fetch_assoc($queryImage)) {
                echo "
                <div class='col-md-3'>
                  <div class='thumbnail'>
                    <a href='menu.php?img=".$retrieve['iid']."&imgname=".$retrieve['imagetitle']."'>
                      <img src='".$retrieve['userImage']."' alt='Home Images' style='width:100%'>
                      <div class='caption' style='padding: 10px; color: #000'>
                        <p class='foodTitle' style='margin: 5px; font-weight: bold'>".$retrieve['imagetitle']."</p>
                        <p>".substr($retrieve['imagedescription'],0,50)."..</p>
                        <div class='row'>
                        <div class='col-md-6'>
                            <p style='margin: 5px; font-weight: bold'>Rs. ".$retrieve['imageprice']."</p>
                        </div>
                        <div class='col-md-6'>
                            <input type='button' value='Order Now' class='orderBtn' />
                        </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
                ";
            }
          } echo "</div></div>";
    }
    ?>

    <!-- Footer -->
    <?php require("includes/footer.php");?>