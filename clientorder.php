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

        <h3 style='font-weight: bold; text-align: center'>All Order</h3>
        <hr style='background-color: #e23744' />
        <?php
            if(isset($_REQUEST['orderStatus'])) {
                $fid = $_REQUEST['fid'];
                $email = $_REQUEST['email'];
                $status = $_REQUEST['userStatus'];
                if(!mysqli_query($conn, "UPDATE foodorder SET status='$status' WHERE fid='$fid' and email = '$email'")) {
                    echo "<script>alert('Something Went Wrong')</script>";
                } else {
                    echo "<script>alert('Status Updated')</script>";
                }
            }
            $getFood = mysqli_query($conn, "SELECT * FROM foodorder ORDER BY id DESC");
            if(mysqli_num_rows($getFood) > 0) {
                while($getItem = mysqli_fetch_assoc($getFood)) {
                    $getItemClient = $getItem['email'];
                    $getFoodUser = mysqli_query($conn, "SELECT * FROM client WHERE email = '$getItemClient'");
                    if(mysqli_num_rows($getFoodUser) > 0) {
                        while($getItemInfo = mysqli_fetch_assoc($getFoodUser)) {
                            echo "
                            <div class='container' style='margin: 10px'>
                            <div class='row'>
                                <div class='col-md-2'>
                                    <img src='". $getItem['image'] ."' alt='Client Order' width=155 height=140 />
                                </div>
                                <div class='col-md-6'>
                                    <div><span style='font-weight: bold'>Client Name:</span> ". $getItemInfo['name'] . " " .  $getItemInfo['sname'] ."</div>
                                    <div><span style='font-weight: bold'>Order:</span> ". $getItem['title'] ." </div>
                                    <div><span style='font-weight: bold'>Address:</span> ". $getItemInfo['street'] ."</div>
                                    <div><span style='font-weight: bold'>Status:</span> 
                                    <form action='' method='post'>
                                    <div class='row'>
                                    <div class='col-md-6'>
                                    <select name='userStatus' class='form-control' class= id=''>
                                        <option value='Order Confirmed'>Order Confirmed</option>
                                        <option value='Order Cancelled'>Order Cancelled</option>
                                        <option value='Food Being Prepared'>Food Being Prepared</option>
                                        <option value='Food Pickup'>Food Pickup</option>
                                        <option value='Food Delivered'>Food Delivered</option>
                                    </select>
                                    </div>
                                    <div class='col-md-6'>
                                    <input type='hidden' name='fid' value='". $getItem['fid'] ."' />
                                    <input type='hidden' name='email' value='". $getItemInfo['email'] ."' />
                                    <div><input type='submit' name='orderStatus' class='btn btn-warning' value='Submit'></div>
                                    </form>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class='col-md-4'></div>
                            </div>
                            </div>
                            ";
                        }
                    }
                }
            } else {
                echo "No Order Placed";
            }
        ?>

    <?php include("includes/leftnavbottom.php");?>

    <!-- Footer -->
    <?php require("includes/footer.php");?>