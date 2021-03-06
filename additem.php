<?php 
require("includes/database.php");
session_start();
if(!isset($_SESSION["adminEmail"])) {
    header("location: index.php");
} else {
    $localEmail = $_SESSION['adminEmail'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen</title>
    <link rel="stylesheet" href="css/basic.css" type="text/css" />
    <link rel="stylesheet" href="css/index.css" type="text/css" />
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
      <a class="navbar-brand" href="http://localhost/Canteen/"><img src="images/siteImages/android-chrome-192x192.png" width="35" height="35" class="d-inline-block align-top" alt=""> Canteen</a>
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
            <li class='nav-item'><a class='nav-link' href='logout.php'>Sign Out</a></li>
            <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
            </li>
        </ul>
      </div>
      </div>
    </nav>

    <?php include("includes/leftnavtop.php");?>
    
    <div class="row">
    <div class="col-md-2">
        <a href="addnewfood.php" class="btn btn-danger">Add Item <i class="fas fa-plus"></i></a>
    </div>
    <div class="col-md-8"></div>
    <div class="col-md-2">
        <a href="wallet.php" class="btn btn-warning"><i class="fas fa-wallet"></i> 
        <?php
               $selUserPurchased = mysqli_query($conn, "SELECT * FROM admin WHERE email='$localEmail'");
               if(mysqli_num_rows($selUserPurchased) > 0) {
                    $getAmount = mysqli_fetch_assoc($selUserPurchased);
                    echo $getAmount['wallet'];
               }
        ?>
        </a>
    </div>
    </div>
    <hr />
    <h3 style="text-align: center; border-bottom: 1px solid #e23744; color: #e23744; font-weight: bold">ALL ITEM</h3>
    <div class="row">
    <div class="col-md-8" style="font-weight: bold">
    ITEM
    </div>
    <div class="col-md-2" style="font-weight: bold">
    Amount
    </div>
    <div class="col-md-2" style="font-weight: bold">
    Remove
    </div>
    </div>
    <?php 
    if(isset($_REQUEST['removeItem'])) {
        $getToremove = trim(htmlspecialchars(stripslashes($_REQUEST['getToremove'])));
        $removeIt = "DELETE FROM menu WHERE iid='$getToremove'";
        if(!mysqli_query($conn, $removeIt)) {
            echo "<script>alert('Something Went Wrong.')</script>";
        }
    }

    $selUserPurchased = mysqli_query($conn, "SELECT * FROM menu");
    if(mysqli_num_rows($selUserPurchased) > 0) {
        while($retrievePurchased = mysqli_fetch_assoc($selUserPurchased)) {
            echo "
            <div class='row'>
            <div class='col-md-8' style='font-weight: bold'>
            <a href='menu.php?img=". $retrievePurchased['iid'] ."&imgname=". $retrievePurchased['imagetitle'] ."'><div><img src='".$retrievePurchased['userImage']."' alt='Product Image' style='border: 1px solid grey; padding: 5px; margin: 10px; border-radius: 5px; box-shadow: 1px 1px 10px grey' width=80 height=80><span style='font-weight: bold'> Title: </span>".$retrievePurchased['imagetitle']."</div></a>
            </div>
            <div class='col-md-2' style='font-weight: bold'>
                <input type='text' class='form-control' value='₹".$retrievePurchased['imageprice'].".00' disabled />
            </div>
            <div class='col-md-2' style='font-weight: bold'>
                <form action='' method='post'>
                <input type='hidden' name='getToremove' value='". $retrievePurchased['iid'] ."' />
                <input type='submit' name='removeItem' class='btn btn-danger' value='Remove' />
                </form>
            </div>
            </div>
            ";
        }
    }
    ?>

    <?php include("includes/leftnavbottom.php");?>

    <!-- Footer -->
    <?php require("includes/footer.php");?>