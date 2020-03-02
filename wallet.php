<?php 
require("includes/database.php");
session_start();
if(isset($_SESSION["adminEmail"]) or isset($_SESSION['email'])) {
    
} else {
    header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen</title>
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

    <div class="row" style="padding: 10px">
    <div class="col-md-2">
        <button class="btn btn-danger" onclick="window.history.back()">Go Back</button>
    </div>
    <div class="col-md-8"></div>
    <div class="col-md-2">
        <div class="btn btn-warning"><i class="fas fa-wallet"></i> 
        <?php
            if(isset($_SESSION['email'])) {
                $localEmail = $_SESSION['email'];
                $selUserPurchased = mysqli_query($conn, "SELECT * FROM client WHERE email='$localEmail'");
               if(mysqli_num_rows($selUserPurchased) > 0) {
                    $getAmount = mysqli_fetch_assoc($selUserPurchased);
                    echo $getAmount['wallet'];
               }
            } else {
                $localEmail = $_SESSION['adminEmail'];
                $selUserPurchased = mysqli_query($conn, "SELECT * FROM admin WHERE email='$localEmail'");
               if(mysqli_num_rows($selUserPurchased) > 0) {
                    $getAmount = mysqli_fetch_assoc($selUserPurchased);
                    echo $getAmount['wallet'];
               }
            }
        ?>
        </div>
    </div>
    </div>
    <hr />
    <?php
        if(isset($_REQUEST['walletsubmit'])) {
            $setAmount = $_REQUEST['setAmount'];
            if(isset($_SESSION['email'])) {
                $clientEmail = $_SESSION['email'];
                $sel = "SELECT * FROM client WHERE email = '$clientEmail'";
                $getWalletAmount = mysqli_query($conn, $sel);
                if(mysqli_num_rows($getWalletAmount) > 0) {
                    $getWallet = mysqli_fetch_assoc($getWalletAmount)['wallet'] + $setAmount;
                    if(!mysqli_query($conn, "UPDATE client SET wallet = '$getWallet' WHERE email = '$clientEmail'")) {
                        echo "<script>alert('Something went Wrong')</script>";
                    }
                }
            } else {
                $clientEmail = $_SESSION['adminEmail'];
                $sel = "SELECT * FROM admin WHERE email = '$clientEmail'";
                $getWalletAmount = mysqli_query($conn, $sel);
                if(mysqli_num_rows($getWalletAmount) > 0) {
                    $getWallet = mysqli_fetch_assoc($getWalletAmount)['wallet'] + $setAmount;
                    if(!mysqli_query($conn, "UPDATE admin SET wallet = '$getWallet' WHERE email = '$clientEmail'")) {
                        echo "<script>alert('Something went Wrong')</script>";
                    }
                }
            }
        }
    ?>
    <div class="col-md-6 offset-md-3">
    <span class="anchor" id="formPayment"></span>
    <div class="card card-outline-secondary">
        <div class="card-body">
            <h3 class="text-center">Credit Card Payment</h3>
            <hr>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form" role="form" autocomplete="off">
                <div class="form-group">
                    <label for="cc_name">Card Holder's Name</label>
                    <input type="text" class="form-control" id="cc_name" pattern="\w+ \w+.*" title="First and last name" required="required">
                </div>
                <div class="form-group">
                    <label>Card Number</label>
                    <input type="text" class="form-control" autocomplete="off" maxlength="20" pattern="\d{16}" title="Credit card number" required="">
                </div>
                <div class="form-group row">
                    <label class="col-md-12">Card Exp. Date</label>
                    <div class="col-md-4">
                        <select class="form-control" name="cc_exp_mo" size="0">
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" name="cc_exp_yr" size="0">
                            <option>2018</option>
                            <option>2019</option>
                            <option>2020</option>
                            <option>2021</option>
                            <option>2022</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" autocomplete="off" maxlength="3" pattern="\d{3}" title="Three digits at back of your card" required="" placeholder="CVC">
                    </div>
                </div>
                <div class="row">
                    <label class="col-md-12">Amount</label>
                </div>
                <div class='form-inline'>
                <div class='input-group'>
                <div class='input-group-prepend'><span class='input-group-text'>Rs</span></div>
                <input type='text' class='form-control text-right' value='' name='setAmount' id='exampleInputAmount' placeholder=''/>
                <div class='input-group-append'><span class='input-group-text'>.00</span></div>
                </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-md-6 offset-md-3">
                        <button type="submit" name="walletsubmit" class="btn btn-success btn-lg btn-block">Add Money</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    <div class="container">
	<div class="row">
        <div class="col-md-6 offset-md-3">
		<div class="paymentCont">
            <div class="paymentWrap">
            <h3 class="headingTop text-center">Trusted Payment Method</h3>	
            <div class="btn-group paymentBtnGroup btn-group-justified" data-toggle="buttons">
                <label class="btn paymentMethod active">
                    <div class="method visa"></div>
                    <input type="radio" name="options" checked> 
                </label>
                <label class="btn paymentMethod">
                    <div class="method master-card"></div>
                    <input type="radio" name="options"> 
                </label>
                <label class="btn paymentMethod">
                    <div class="method amex"></div>
                    <input type="radio" name="options">
                </label>
                    <label class="btn paymentMethod">
                    <div class="method vishwa"></div>
                    <input type="radio" name="options"> 
                </label>
                <label class="btn paymentMethod">
                    <div class="method ez-cash"></div>
                    <input type="radio" name="options"> 
                </label>
            </div>        
            </div>
        </div>
        </div>	
    </div>
    </div>

    <!-- Footer -->
    <?php require("includes/footer.php");?>