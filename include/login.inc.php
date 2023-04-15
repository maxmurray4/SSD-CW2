<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION: Checks if submit button was pressed in login form by checking weather the "submit" variable is set in the POST request; if it is , the user's input for login & pawd are stored in vars
//
// VULNERABILITIY: Missing CSRF token
//
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (isset($_POST["submit"])) {
// stores the users login and password into variables
    $userLogin = $_POST["userLogin"];
    $password = $_POST["psw"];
// calls the 2 files
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
// checks to see if the fields in the login page are empty and if so then return false and rirect the user to a different page that alerts them that they left the fields empty
    if ( emptyInputLogin( $userLogin, $password ) !== false ) {
        header( "Location: ../index.php?signerror=emptyinput" );
        exit();
    }
// logs the user in as they have inputted the correct informtation
    loginUser( $conn, $userLogin, $password );


} else {
    header( "Location: ../index.php" );
    exit();
}

?>
