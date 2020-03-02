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
if(isset($_REQUEST['newFood'])) {
    function inValidate($data) {
        $data = trim(stripslashes(htmlspecialchars($data)));
        return $data;
    }

    $uploadImage = "images/siteUploads/" . basename($_FILES["uploadImage"]["name"]);
    $imageName = inValidate($_REQUEST['imageName']);
    $imageAmount = inValidate($_REQUEST['imageAmount']);
    $imageDescription = inValidate($_REQUEST['imageDescription']);
    $inputCategory = inValidate($_REQUEST['inputCategory']);
    $iid = rand();
    $date = date('d/m/Y', time());

    $selUser = "SELECT * FROM admin WHERE email = '$localEmail'";
    $selQuery = mysqli_query($conn, $selUser);

    if(mysqli_num_rows($selQuery) > 0) {
        $retrieveUsers = mysqli_fetch_assoc($selQuery);
        $userID = $retrieveUsers['uid'];
        if(move_uploaded_file($_FILES['uploadImage']['tmp_name'], $uploadImage)) {
        $insertNewArt = "INSERT INTO menu (uid, iid, email, userimage, imagetitle, imagedescription, imageprice, updateDate, foodType) VALUES ('$userID', '$iid', '$localEmail', '$uploadImage', '$imageName', '$imageDescription', '$imageAmount', '$date', '$inputCategory')";
        if(mysqli_query($conn, $insertNewArt)) {
            echo "<script>alert('Congratulation! Food is Added to Menu.')</script>";
        } else {
            echo mysqli_error($conn);
        } } else {
            echo "<script>alert('Something went wrong')</script>";
        }
    } else {
        echo "<script>alert('Error Code: Session Expires')</script>";
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
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data">
        <div class="row">
        <div class="col-md-3">
        <div class="form-group">
            <input type="file" name="uploadImage" id="uploadImage" style="display: none" />
            <label for="uploadImage" style="cursor: pointer"><img src="images/siteImages/addimages.png" alt="Upload Image" width=215 height=215></label>
        </div>
        </div>
        <div class="col-md-9">
            <div class="form-group">
            <h5>Add New Item</h5>
            <hr />
            </div>
            <div class="form-group">
            <h5>Title:</h5>
            <input type="text" name="imageName" class="form-control" placeholder="Name" required />
            </div>
            <h5>Set Amount:</h5>
            <div class="input-group">
            <input type="number" name="imageAmount" class="form-control" placeholder="500" required />
            <div class="input-group-append">
                <span class="input-group-text">₹</span>
            </div>
            </div>
        </div>
        </div>
        <div class="form-group">
        <h5>Description:</h5>
        <textarea name="imageDescription" class="form-control" rows="5" placeholder="Description." required></textarea>
        <br />
        <div class="form-group">
        <label>Food Type:</label>
              <select id='inputCategory' name='inputCategory' class='form-control' required>
                  <option>Choose Wisely...</option>
                  <option>Veg</option>
                  <option>Non-Veg</option>
              </select>
              </div>
        </div>
        <div class="form-group">
        <input type="submit" name="newFood" class="btn btn-primary" value="Publish" />
        </div>
        </form>
    <?php include("includes/leftnavbottom.php");?>

    <!-- Footer -->
    <?php require("includes/footer.php");?>