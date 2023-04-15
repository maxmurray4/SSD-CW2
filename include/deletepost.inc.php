<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION: script used to delete post
//              first checks if POST request was made with form containing "submit" button;
//              if condition is true, session is started, required files and functions are called and user is redirected to the profile page
//              if condition is false, user is redirected to index page and exits script
//
// VULNERABILITY: Missing CSRF token - include so token is generated when submit button is pressed, avoiding CSRF attack (e.g.: attacker deceives user to press a button that performs an unwanted outcome)
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



if ( isset( $_POST[ "submit" ] ) ) {
	// Start session
    session_start();
	//Calls external files
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

	//Variable
    $postID = $_POST[ "submit" ];
	//Calls deleteProBlog function from functions.inc.php
    deleteProBlog( $conn, $postID );
	//Redirect
    header( "Location: ../profile.php" );

} else {
	//Redirect
    header( "Location:../index.php" );
    exit();
}

?>
