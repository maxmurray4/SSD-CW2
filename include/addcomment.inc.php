<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION: enables users to add comments to a blog post;
//              if comment is empty, it prompts an error, otherwise sets value of var $commentContent to the value of $_POST{}
//              if no errors prompted, SQL prep stmts are used to insert the mew comment into the db
//              if SQL prep stmts fail, user is redirected to the post.php page and propmpts and error message
//              if SQL prep stmts is successful, stmts are executed and user is redirected to the blog post they submitted the comment for, with the blogID in the URL
// ISSUES: PARAMETRISED QUERIES - to be used in addition to prepared stmt
// VULNERABILITY 1: INPUT SANITISATION missing - code checks if the comment_content field is empty; doesn't sanitise content of the field to prevent SQL injection attacks
// VULNERABILITY 2: CSRF token missing - include in all forms and requests coming from user
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Start session
session_start();
//External file
require_once 'dbh.inc.php';
//Variables
$commentContent = '';
$blogID = $_GET['id'];
$uid = $_SESSION['uid'];
if(empty($_POST['comment_content'])) {
    $error = '<p class="text-danger">Comment is required</p>';
}else {
     $commentContent = $_POST['comment_content'];
}

//If error is empty then run INSERT query to insert a comment into the database
if(empty($error)) {
    $sql = "INSERT INTO post_comment (postId, userID, createdAt, content) VALUES (?, ?, now(), ?)";
    $stmt = mysqli_stmt_init( $conn );

    if ( !mysqli_stmt_prepare( $stmt, $sql ) ) {
        header( "location: ../post.php?error=dbfailure" )
        exit();
    }

    mysqli_stmt_bind_param( $stmt, "iis", $blogID, $uid, $commentContent);
    mysqli_stmt_execute( $stmt );
    mysqli_stmt_close( $stmt );
    header( "Location: ../blog.php?id=".$blogID ); // Redirect to blog
}

?>
