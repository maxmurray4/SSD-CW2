<?php
// SECURITY VULNERABILITY 1: INPUT VALIDATION & SANITISATION - user login and password fields should be validated to ensure that only allowed characters are entered.
// SECURITY VULNERBILITY 2: PASSWORD STORAGE -  use bcrypt hashing algorithm to store the user's password
// SECURITY VULNERABILITY 3: SESSION MANAGEMENT - ensuring session ids are randomised sufficiently (prevent session hijacking) and that sessions are properly invalidated upon logout or timeout (preventing attacker to use old session id)

// Start session
session_start();

// Check if session variable is set (check if user session has expired since last activity)
if(isset($_SESSION['lastActivity'])){

  // If session var has not expired based on the expiration time stored in $_SESSION['expireTime']
  if($_SESSION['lastActivity'] < time()-$_SESSION['expireTime'])  { //have we expired?

    // If session has expired, direct user to index.php
    header('Location: ../include/logout.inc.php');
    // If session has not expired, update the $_SESSION['lastActivity'] variable to current time
  }else{ //if we haven't expired:
    $_SESSION['lastActivity'] = time();
  }
}

// Set content type header
header('Content-Type: text/html; charset=utf-8');

// Turn on output buffering
ob_start();
?>

<!-- If user is logged in, display button in nav bar to create a post, a dropdown menu with the user's first name, profile and logout -->
<!-- If user is not logged in (session variable is set), display dropdown menu containing links to the user's profile and sign out page -->
<!-- If session variable is not set, display sign up and log in options -->
<!DOCTYPE html>

<html>
<head>
<title>ToastBook - Blog</title>
<link href="css/PageCSS.css" rel="stylesheet" type="text/css">
<link rel="icon" href="images/tabLogo.png">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body class="d-flex flex-column h-100" cz-shortcut-listen="true">
<main role="main" class="flex-shrink-0">
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <a class="navbar-brand" href="#">ToastBook</a>
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


<?php

       // Code to connect to db, retrieve a blog post with given id from "post" table
       // Use JOIN operation and prepared stmt to execute SELECT query to retrieve blog post data along with the id of the post
        require_once 'include/dbh.inc.php';
        if(isset($_GET["id"])) {
            $blogId = $_GET["id"];
            $stmt = $conn->prepare("SELECT title, summary, imgName, content, createdAt, `user`.firstName, `user`.middleName, `user`.lastName FROM `post` JOIN `user` ON `user`.id = `post`.`authorId` AND `post`.`id` = ?");
            $stmt->bind_param("i", $blogId);
            $stmt->execute();
            // Use store_result() method to store query output and bind value of blog id to the prepared stmt
            $stmt->store_result();
            $stmt->bind_result($blogTitle, $blogSummary, $blogImage, $blogContent, $createdAt, $firstName, $middleName, $lastName);

            // If no. of rows returned > 0, use fetch() method to retrieve query result, change the creation date of the post
            if($stmt->num_rows > 0) {
                $stmt->fetch();
                $date = date("d F Y, h:i:s A", strtotime($createdAt));
                // Echo blog post contents
                echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                <h1 class="display-5">'.$blogTitle.'</h1>
                <p class="blog-post-meta">'.$date.' by '.$firstName.' '.$middleName.' '.$lastName.'</p>
                </div>
                </div>
                <article class="blog-post w-50 p-5 mx-auto">
                <div>
                <img src="../uploads/'.$blogImage.'" class="img-fluid"/>
                </div>
                <pre style="white-space:pre-line;"><p class="mt-2 lead">'.$blogContent.'</p></pre>
                </article>';
            // If  the id param is not passed through the URL, therefore id is invalid, redirect user to homepage and exit to stop further script execution
            }else {
              // Redirecting the user to the homepage, provides a 'fallback behavior' if there is no data to display, helping to improve user experience
                header("Location: ../index.php");
                exit();
                // Function to flush output buffer - send data in output buffer to client and turn off output buffering
                ob_end_flush();
            }
            // Close prepared stmt to free up resources and stop further interraction with the stmt
            $stmt->close();
        // If  SELECT query returns no rows, use  header() function to redirect user to index page and flush output buffer
        }else {
            header("Location: ../index.php");
            exit();
            ob_end_flush();
        }
?>

<div class="container">
    <h2>Comments</h2>
   <form method="POST" id="comment_form">
    <div class="form-group">
     <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5" required></textarea>
    </div>
    <div class="form-group">
     <input type="hidden" name="comment_id" id="comment_id" value="0" />
     <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
    </div>
   </form>
   <span id="comment_message"></span>
   <br />
   <div id="display_comment"></div>
  </div>

    </main>
    <footer class="bg-dark text-white text-center text-lg-left">
      <!-- Grid container -->
      <div class="container p-4">
        <!--Grid row-->
        <div class="row">
          <!--Grid column-->
          <div class="col-lg-8 col-md-12 mb-4 mb-md-0">
            <h5>ToastBook</h5>
            <p>
              ToastBook is where you can find the latest technology news and reviews, covering computing, home entertainment systems, gadgets and more.
            </p>
          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
            <h5>Social Media</h5>

            <ul class="list-unstyled mb-0">
              <li>
                <a href="#!" class="text-white">Facebook</a>
              </li>
              <li>
                <a href="#!" class="text-white">Twitter</a>
              </li>
              <li>
                <a href="#!" class="text-white">Instagram</a>
              </li>
              <li>
                <a href="#!" class="text-white">LinkedIn</a>
              </li>
            </ul>
          </div>
          <!--Grid column-->
        </div>
        <!--Grid row-->
      </div>
      <!-- Grid container -->

      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
         © 2022 Copyright:
      <a class="text-white" href="#">ToastBook</a>
      </div>
      <!-- Copyright -->
    </footer>
        <!-- Bootstrap JS -->
        <script src="https://www.markuptag.com/bootstrap/5/js/bootstrap.bundle.min.js"></script>
        <script>
//jQuery/JavaScript function triggered when document is ready
$(document).ready(function(){
// Attach a submit event listener to HTML form with id comment_form using the .on()
 $('#comment_form').on('submit', function(event){
  // When form submitted function first calls event.preventDefault() to stop default form submission behavior
  event.preventDefault();
  // Serialise the form data into a string with the serialize() and retrieve param value from current URL with new URLSearchParams(queryString) API
  var form_data = $(this).serialize();
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const id = urlParams.get('id');
  // Make AJAX request to addcomment.inc.php on server using HTTP POST for the request sent with the serialised data included in the request body
  $.ajax({
   url:`/include/addcomment.inc.php?id=${id}`,
   method:"POST",
   data:form_data,
   // Server response expected to be JSON format and the success:function(data) callback function is executed when response is received
   dataType:"JSON",
   success:function(data)
   {
    // Check if data variable returns error message, otherwise reset the form, display message to user and call load_comment() function
    if(data.error != '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');
     load_comment();
    }
   }
  })
 });

 load_comment();

 // Function responsible for loading comments on the webpage; using URLSearchParams object, it retrieves the value of the id param from the URL
 function load_comment()
 {
    const queryString = window.location.search;
    console.log(queryString);
    const urlParams = new URLSearchParams(queryString);
    const id = urlParams.get('id');
  // Sends AJAX request to getcomment.inc.php file on the server using the extracted id value as a parameter. getcomment.inc.php file returns the comments associated with the given id
  $.ajax({
  // The  getcomment.inc.php file returns the comments associated with the given id
   url:`/include/getcomment.inc.php?id=${id}`,
   method:"POST",
   // When comments are recieved, set the HTML content of the element with the ID #display_comment to the returned data using the success function of the AJAX request
   success:function(data)
   {
    $('#display_comment').html(data);
   }
  })
 }

 // If user clicks the "reply" button, set comment_id var to the comment id thst the user is replying to
 $(document).on('click', '.reply', function(){
  var comment_id = $(this).attr("id");
  // Set value of comment_id as the value of the hidden input field with the id of #comment_id', the submit the comment
  $('#comment_id').val(comment_id);
  // User should enter their comment_name before entering comment
  $('#comment_name').focus();
 });

});
</script>
    </body>
</html>
