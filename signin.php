<?php 
require("includes/database.php");
session_start();
if(isset($_SESSION["email"])) {
    header("location: dashboard.php");
}
?>
<?php
    if(isset($_REQUEST["submit"])) {
        function inValidate($data) {
            $data = trim(stripslashes(htmlspecialchars($data)));
            return $data;
        }

        $email = inValidate($_REQUEST["email"]);
        $password = inValidate($_REQUEST["password"]);

        $select = "SELECT * FROM client WHERE email = '$email'";
        $query = mysqli_query($conn, $select);

        if(mysqli_num_rows($query) > 0) {
            $req = mysqli_fetch_assoc($query);
            $getPasswd = $req['password'];
            if(password_verify($password, $getPasswd)) {
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $getPasswd;
            header("location: dashboard.php");
            } else {
            echo "<script>alert('User not Found')</script>";  
            }
        } else {
            echo "<script>alert('User not Found')</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="stylesheet" href="css/basic.css" type="text/css" />
    <link rel="stylesheet" href="css/signin.css" type="text/css" />
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
    <link rel="mask-icon" href="images/siteImages/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark static-top" style="background-color: #e23744">
    <div class="container">
      <a class="navbar-brand" href="http://localhost/Canteen/"><img src="images/siteImages/android-chrome-192x192.png" width="35" height="35" class="d-inline-block align-top" alt=""> Sign In</a>
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
            <a class="nav-link" href="about.php">About</a>
            </li>
        </ul>
      </div>
      </div>
    </nav>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" class="form-signin mt-5 mb-5" style="text-align: center">
    <img class="mb-4" src="images/siteImages/signin.png" alt="User" style='object-fit: cover; border-radius: 100%; border: 2px solid #e23744' width="120" height="120">
    <h1 class="h3 mb-3 font-weight-normal">Welcome</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="email" id="inputEmail" class="form-control" value="<?php if(isset($_SESSION["email"])) {echo $_SESSION["email"];} ?>" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <div class="checkbox mb-3">
        <label>
        <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-danger btn-block" name="submit" type="submit">Sign in</button>
    <div class="checkbox mt-3">
        <label>
        <a href="signup.php" style="color: #e23744">Sign Up</a>
        </label>
    </div>
    </form>

    <!-- Footer -->
    <?php require("includes/footer.php");?>