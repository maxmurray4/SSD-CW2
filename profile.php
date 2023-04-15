<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION: Creates profile page for the ToastBook webApp user
//              starts new session or resumes existing one and checks if firstName var is set in the session data, if not set, user is redirected to index.php page
//              checks if lastActivity var is set in session data and if session has expired; If session expired, user is redirected to logout.php tp end session
//              if session not expired, it updates var lastActivity to current time
//              HTML doc is outputted which includes nav bar at top of page; if firstName var is set in session data, a POST button is displayed
//              if firstName var is not set in session data, Sign Up and Log In buttons are displayed
//              Sign Up and Log In butons correspond to the modal windows defined with Bootstrap: one login form (which includes a POST request to script located @ /include/login.inc.php ) and one registration form
//
// ISSUES:  Script should check the session data is valid  and not tampered with and should regenerate session ids after successful login or logout to prevent session fixation attacks
//
// VULNERABILITY 1: INPUT SANITISATION missing (XSS attack) in the login form where the the user input is echoed back (use html special chars or similar function to escape user input before echoing back to the page)
// VULNERABILITY 2: Missing CSRF token
//
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


session_start();

//Check if user is logged in
if(!isset($_SESSION['firstName'])) {
  header("Location: ../index.php");
}

if(isset($_SESSION['lastActivity'])){
  if($_SESSION['lastActivity'] < time()-$_SESSION['expireTime'])  { //have we expired?
    //redirect to index.php
    header('Location: ../include/logout.inc.php');
  }else{ //if we haven't expired:
    $_SESSION['lastActivity'] = time();
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link href="css/PageCSS.css" rel="stylesheet" type="text/css">
<title>ToastBook - Profile</title>
<link rel="icon" href="images/tabLogo.png">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">ToastBook</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
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

    <!-- Jumbotron -->
    <div id="intro" class="p-5 text-center bg-light">
      <h1 class="mb-3 h2">Welcome, <?php echo $_SESSION['firstName']; ?>.</h1>
      <p class="mb-3">Edit your profile</p>
    </div><br>
    <!-- Jumbotron -->

    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <form method="post" action="/include/profile.inc.php">
                    <div class="row mt-3">
                        <div class="col-md-6"><label class="labels">First Name</label><input name="firstName" type="text" class="form-control" placeholder="<?php echo $_SESSION['firstName'];?>" value="<?php echo $_SESSION['firstName'];?>" required></div>
                        <div class="col-md-6"><label class="labels">Middle Name</label><input name="middleName" type="text" class="form-control" placeholder="<?php echo $_SESSION['middleName'];?>" value="<?php echo $_SESSION['middleName'];?>"></div>
                        <div class="col-md-6"><label class="labels">Last Name</label><input name="lastName" type="text" class="form-control" placeholder="<?php echo $_SESSION['lastName'];?>" value="<?php echo $_SESSION['lastName'];?>" required></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Mobile Number</label><input name="mobileNumber" type="text" class="form-control" placeholder="<?php echo $_SESSION['mobileNumber'];?>" value="<?php echo $_SESSION['mobileNumber'];?>" required></div>
                        <div class="col-md-12"><label class="labels">Email Address</label><input name="emailAddress" type="text" class="form-control" placeholder="<?php echo $_SESSION['emailAddress'];?>" value="<?php echo $_SESSION['emailAddress'];?>" required></div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit" name="submit">Save Profile</button></div>
                    </form>
            </div>
        </div>
    </div>

<div class="container">
  <hr class="line">
  <div class="merg">
    <h2 class="title">Your blogs</h2>
    <?php
    require_once 'include\functions.inc.php';
    require_once 'include\dbh.inc.php';
    if ( displayProBlog( $conn ) !== false ) {} else {
        echo '<p class="med">Wait a minute, it seems that you haven\'t uploaded a blog yet</p>';
        echo "<li class='menu_txt'><a href='post.php' class='link'>Create Blog</a></li>";
//        echo "<li class='link'><a href='post.php' class='menu_txt'>Create Blog</a></li>";
    }
    ?>
  </div>
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
