<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION: start session and check if user's lastActivity fits within the allocated expireTime timeframe;
//              if outside allocated time, redirect user to logout.inc.php, otherwise, if user session is still active, update the last activity time
//              output HTMP and CSS for web page, including nav bar with links to Home and Contact pages
//              determine if user is logged in using the fisrtName session var, and if it is, display POST button linking to the post.php page; dropdown menu is also included (link to user's profle) & display Sign Out button
//              if user not logged in(verified with firstName var), display Sing Up and Log In buttons
//
// VULNERABILITY 1: user input ($_GET['logerror']) without proper sanitization or validation. This could be a potential security vulnerability( an attacker could inject malicious code through this input). - check if it's dealt with in function.php
// VULNERABILITY 2: Missing CSRF token
//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


session_start();
if(isset($_SESSION['lastActivity'])){
  if($_SESSION['lastActivity'] < time()-$_SESSION['expireTime'])  { //have we expired?
    //redirect to index.php
    header('Location: ../include/logout.inc.php');
  }else{ //if we haven't expired:
    $_SESSION['lastActivity'] = time();
  }
}
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
<title>ToastBook</title>
<link rel="icon" href="/images/tabLogo.png">
<link href="css/PageCSS.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">ToastBook</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
            <?php
            if (isset($_SESSION["firstName"])) {
                echo "<button type=\"button\" class=\"btn btn-primary\" style=\"height: 0.4%;\" onclick=\"window.location.href='post.php'\">Post</button>";
            }
            ?>
            </ul>
            <ul class="navbar-nav">
            <?php
        if (isset($_SESSION["firstName"])) {
            echo "<div class=\"dropdown\">
                <li class=\"nav-item\">
                <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
              ".$_SESSION['firstName']."</a>
              <ul class=\"dropdown-menu dropdown-menu-right\">
              <li><a class=\"dropdown-item\" href=\"profile.php\">Profile</a></li>
              <li><a class=\"dropdown-item\" href=\"include\logout.inc.php\">Sign Out</a></li>
                </ul>
            </div>
            ";
        } else {
            echo "<li class=\"nav-item\"><a class='nav-link' data-bs-toggle=\"modal\" data-bs-target=\"#modalRegistrationForm\">Sign Up</a></li>";
	        echo "<li class=\"nav-item\"><a class='nav-link' data-bs-toggle=\"modal\" data-bs-target=\"#modalLoginForm\">Log In</a></li>";
        }
  ?>
            </ul>
        </div>
    </nav>

<!-- Modal Login Form -->
<div class="modal fade" id="modalLoginForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="/include/login.inc.php">
          <div class="mb-3">
            <label class="form-label">Phone Number/Email</label>
            <input type="text" class="form-control" id="userLogin" name="userLogin" placeholder="Phone Number/Email" required/>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" id="psw" name="psw" placeholder="Password" required/>
            <?php
            if ( isset( $_GET[ "logerror" ] ) ) {
                echo '<p class="error_txt">Wrong input. Try again!</p>';
            }
            ?>
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="rememberMe" />
            <label class="form-check-label" for="rememberMe">Remember me</label>
          </div>
          <div class="modal-footer d-block">
            <p class="float-start">Not got an account? <a data-bs-toggle="modal" data-bs-target="#modalRegistrationForm" href="#">Sign Up</a></p>
            <button type="submit" class="btn btn-success float-end" name="submit">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

<!-- Modal Registration Form -->
<div class="modal fade" id="modalRegistrationForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registration Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="/include/signup.inc.php">
          <div class="mb-3">
            <label class="form-label">First Name<span style="color:#ff0000">*</span></label>
            <input type="text" class="form-control" id="firstName" name="firstName" required/>
          </div>
          <div class="mb-3">
            <label class="form-label">Middle Name(s)</label>
            <input type="text" class="form-control" id="middleName" name="middleName"/>
          </div>
          <div class="mb-3">
            <label class="form-label">Surname<span style="color:#ff0000">*</span></label>
            <input type="text" class="form-control" id="surname" name="surname" required/>
			              <?php
            if ( isset( $_GET[ "signerror" ] ) ) {
                if ( $_GET[ "signerror" ] == "invalidmatch" ) {
                    echo '<p class="error_txt">All name fields must not contain numbers</p>';
                }
            }
            ?>
          </div>
          <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber"/>
            <?php
            if ( isset( $_GET[ "signerror" ] ) ) {
                if ( $_GET[ "signerror" ] == "invalidnumber" ) {
                    echo '<p class="error_txt">Phone number must not contain letters!</p><br>';
                } else if ( $_GET[ "signerror" ] == "shortnumber" ) {
                    echo '<p class="error_txt">Phone number must be 11 characters!</p>';
                }
            }
            ?>
          </div>
          <div class="mb-3">
            <label class="form-label">Email<span style="color:#ff0000">*</span></label>
            <input type="text" class="form-control" id="email" name="email" required/>
            <?php
            if ( isset( $_GET[ "signerror" ] ) ) {
                if ( $_GET[ "signerror" ] == "invalidemail" ) {
                    echo '<p class="error_txt">Invalid email format!</p>';
                }
            }

            // This function should silently exit and not output the error message
            if ( isset( $_GET[ "signerror" ] ) ) {
                if ( $_GET[ "signerror" ] == "takenusername" ) {
                    echo '<p class="error_txt">Phone number or email already taken!</p>';
                }
            }
            ?>
          </div>
          <div class="mb-3">
            <label class="form-label">Password<span style="color:#ff0000">*</span></label>
            <input type="password" class="form-control" id="registerPassword" name="registerPassword" required/>
            <?php
            if ( isset( $_GET[ "signerror" ] ) ) {
                if ( $_GET[ "signerror" ] == "invalidpassword" ) {
                    echo '<p class="error_txt">The password must comply with the rules below!</p>';
                }
            }
            ?>
            <div id="passwordHelpBlock" class="form-text">Your password must be atleast 8 characters long, Must contain numbers, lowercase, uppercase, and symbols</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm Password<span style="color:#ff0000">*</span></label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
				   required/>
            <?php
            if ( isset( $_GET[ "signerror" ] ) ) {
                if ( $_GET[ "signerror" ] == "nomatch" ) {
                    echo '<p class="error_txt">The two passwords doesn\'t match!</p>';
                }
            }
            ?>
          </div>
          <div class="modal-footer d-block">
            <button type="submit" class="btn btn-success float-end" name="submit">Register</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="row mx-md-5 mt-md-4">
  <?php
  require_once 'include\functions.inc.php';
  require_once 'include\dbh.inc.php';
  getBlogs( $conn );
  ?>
</div>
<footer class="bg-dark text-white text-center text-lg-left">
  <!-- Grid container -->
  <div class="container p-4">
    <!--Grid row-->
    <div class="row">
      <!--Grid column-->
      <div class="col-lg-8 col-md-12 mb-4 mb-md-0">
        <h5>ToastBook</h5>
        <p> ToastBook is where you can find the latest technology news and reviews, covering computing, home entertainment systems, gadgets and more. </p>
      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5>Social Media</h5>
        <ul class="list-unstyled mb-0">
          <li> <a href="#!" class="text-white">Facebook</a> </li>
          <li> <a href="#!" class="text-white">Twitter</a> </li>
          <li> <a href="#!" class="text-white">Instagram</a> </li>
          <li> <a href="#!" class="text-white">LinkedIn</a> </li>
        </ul>
      </div>
      <!--Grid column-->
    </div>
    <!--Grid row-->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)"> © 2022 Copyright: <a class="text-white" href="#">ToastBook</a> </div>
  <!-- Copyright -->
</footer>
<!-- Bootstrap JS -->
<script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
</body>
</html>
