<?php 
require("includes/database.php");
session_start();
if(!isset($_SESSION["adminEmail"])) {
    header("location: index.php");
} else {
    $localEmail = $_SESSION['adminEmail'];
}
?>
<?php
    if(isset($_REQUEST['updatePassword'])) {
        function inValidate($data) {
            $data = trim(stripslashes(htmlspecialchars($data)));
            return $data;
        }

        $currentPasswd = inValidate($_REQUEST['currentPasswd']);
        $newPasswd = inValidate($_REQUEST['newPasswd']);
        $repeatPasswd = inValidate($_REQUEST['repeatPasswd']);

        $sel = "SELECT * FROM admin WHERE email='$localEmail'";
        $query = mysqli_query($conn, $sel);
        if(mysqli_num_rows($query) > 0) {
            $retrieveUser = mysqli_fetch_assoc($query);
            $retrievePasswd = $retrieveUser['password'];
            if(password_verify($currentPasswd, $retrievePasswd)) {
                if($newPasswd === $repeatPasswd) {
                    $hashPasswd = password_hash($newPasswd, PASSWORD_DEFAULT);
                    $insertNewPasswd = "UPDATE admin SET password = '$hashPasswd' WHERE email = '$localEmail'";
                    if(mysqli_query($conn, $insertNewPasswd)) {
                        header("location: logout.php");
                    } else {
                        "<script>alert('Something went Wrong.')</script>";
                    }
                } else {
                    echo "<script>alert('Reapted Password is Wrong.')</script>";
                }
            } else {
                echo "<script>alert('Current Password is Wrong.')</script>";
            }
        } else {
            echo "<script>alert('Error Code: Session Expire')</script>";
        }
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
    <div class='form-group row'>
        <div class="col-md-4">
        <h5>Email</h5>   
        <input type='text' value='<?php echo $localEmail; ?>' name='name' class='form-control' placeholder='' disabled>
        </div>
    </div>
    <hr />
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
    <h5>Change Password:</h5> <br />
        <div class="form-group row">
        <div class="col-md-4">
        <input type='text' value='' name='currentPasswd' class='form-control' placeholder='Current Password' required />
        </div>
        </div>
        <div class="form-group row">
        <div class="col-md-4">
        <input type='text' value='' name='newPasswd' class='form-control' placeholder='New Password' required />
        </div>
        </div>
        <div class="form-group row">
        <div class="col-md-4">
        <input type='text' value='' name='repeatPasswd' class='form-control' placeholder='Repeat Password' required />
        </div>
        </div>
        <div class="form-group row">
        <div class="col-md-4">
        <input type='submit' value='Update Password' name='updatePassword' class='btn btn-danger' />
        </div>
        </div>
    </form>
    <?php include("includes/leftnavbottom.php");?>

    <!-- Footer -->
    <?php require("includes/footer.php");?>