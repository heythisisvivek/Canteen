<?php 
require("includes/database.php");
session_start();
if(isset($_SESSION["adminEmail"])) {
    header("location: admindashboard.php");
}
?>

<?php
if(isset($_REQUEST["submit"])) {
    function inValidate($data) {
        $data = trim(stripslashes(htmlspecialchars($data)));
        return $data;
    }

    $uid = rand();
    $name = inValidate($_REQUEST["name"]);
    $sname = inValidate($_REQUEST["sname"]);
    $email = inValidate($_REQUEST["email"]);
    $gender = inValidate($_REQUEST["gender"]);
    $city = inValidate($_REQUEST["city"]);
    $country = inValidate($_REQUEST["country"]);
    $password = password_hash(inValidate($_REQUEST["password"]), PASSWORD_DEFAULT);
    
    $sel = "SELECT * FROM users WHERE email='$email'";
    $query = mysqli_query($conn, $sel);
    if(mysqli_num_rows($query) > 0) {
        echo "<script>alert('User already exists.')</script>";
    } else {
        $insert = "INSERT INTO admin(uid, profilepic, name, sname, email, gender, city, country, password) VALUES ('$uid', '', '$name', '$sname', '$email', '$gender', '$city', '$country', '$password')";
    
        if(mysqli_query($conn, $insert)) {
            $_SESSION['adminEmail'] = $email;
            $_SESSION['password'] = $password;
            header("location: admindashboard.php");
        } else {
            echo "<script>alert('Something went wrong')</script>";
        }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sign Up</title>
    <link rel="stylesheet" href="css/basic.css" type="text/css" />
    <link rel="stylesheet" href="css/signin.css" type="text/css" />
    <link rel="stylesheet" href="CDN/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">    
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <!-- ICON -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="images/siteImages/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/siteImages/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/siteImages/favicon-16x16.png">
    <link rel="manifest" href="images/siteImages/site.webmanifest">
    <link rel="mask-icon" href="images/siteImages/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark static-top" style="background-color: #e23744">
    <div class="container">
      <a class="navbar-brand" href="http://localhost/Canteen/"><img src="images/siteImages/android-chrome-192x192.png" width="35" height="35" class="d-inline-block align-top" alt=""> Admin</a>
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
          <li class="nav-item">
            <a class="nav-link" href="menu.php">Menu</a>
          </li>
          <?php
          if(!isset($_SESSION['adminEmail'])) {
                echo "
            <li class='nav-item'><a class='nav-link' href='signin.php'>Sign In</a></li>
            <li class='nav-item'><a class='nav-link' href='signup.php'>Sign Up</a></li>";
            } else {
                echo "
            <li class='nav-item'><a class='nav-link' href='home.php'>Dashboard</a></li>
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

    <br /><br />

    <div class="container">
    <div class="row justify-content-center">
    <div class="col-md-6">
    <div class="card">
    <header class="card-header">
        <a href="admin.php" class="float-right btn btn-outline-danger mt-1">Log in</a>
        <h4 class="card-title mt-2">Sign up</h4>
    </header>
    <article class="card-body">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
        <div class="form-row">
            <div class="col form-group">
                <label>First name </label>   
                <input type="text" name="name" class="form-control" placeholder="" autofocus required>
            </div>
            <div class="col form-group">
                <label>Last name</label>
                <input type="text" name="sname" class="form-control" placeholder=" " required>
            </div>
        </div> 
        <div class="form-group">
            <label>Email address</label>
            <input type="email" name="email" class="form-control" placeholder="" required>
            <small class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div> 
        <div class="form-group">
            <label class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="Male">
            <span class="form-check-label"> Male </span>
            </label>
            <label class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" value="Female">
            <span class="form-check-label"> Female</span>
            </label>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
            <label>City</label>
            <input type="text" name="city" class="form-control" required>
            </div>
            <div class="form-group col-md-6">
            <label>Country</label>
            <select id="inputState" name="country" class="form-control">
                <option> Choose...</option>
                <option>Uzbekistan</option>
                <option>Russia</option>
                <option selected="">United States</option>
                <option>India</option>
                <option>Afganistan</option>
            </select>
            </div>
        </div>
        <div class="form-group">
            <label>Create password</label>
            <input class="form-control" name="password" type="password" required>
        </div>
        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-danger btn-block"> Register  </button>
        </div> 
        <small class="text-muted">By clicking the 'Sign Up' button, you confirm that you accept our <br> Terms of use and Privacy Policy.</small>                                          
    </form>
    </article>
    <div class="border-top card-body text-center">Have an account? <a href="admin.php" style="color: #e23744">Log In</a></div>
    </div> 
    </div> 
    </div> 
    </div> 
    <br><br>

    <!-- Footer -->
    <?php require("includes/footer.php");?>