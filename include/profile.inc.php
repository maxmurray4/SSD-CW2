<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION: Checks if sumbit button was pressed and then gets the user input values from a form, validates input, and calls editProfile() from functions.inc.php with the input values as args
//              if submit button was not pressed, redirects to the profile pagr
//             editProfile() updates the user's profile in db - if user input values incorrect, user is redirected with header() to the relevant error page
//
// VULNERABILITY CHECK: ensure that the functions called in the script below are handling input validation and sanitisation accordingly
// VULNERABILITY : Missing CSRF token to include with the form's hidden fields and successively verified on the server side upon form submission
//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Starts session
session_start();
if (isset($_POST["submit"])) {

    //Variables
    $uid = $_SESSION['uid'];
    $firstName = $_POST["firstName"];
    $middleName = $_POST["middleName"];
    $lastName = $_POST["lastName"];
    $mobileNumber = $_POST["mobileNumber"];
    $emailAddress = $_POST["emailAddress"];

    //Calls external files
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    //Checks if input is empty
    if ( emptyInputProfile($firstName, $lastName, $mobileNumber, $emailAddress) !== false ) {
        header( "Location: ../profile.php?updateerror=emptyinput" );
        exit();
    }
    //Checks if phone number is valid
    if ( invalPhoneNum( $mobileNumber ) !== false ) {
        header( "Location: ../index.php?signerror=invalidnumber" );
        exit();
    }
    //Checks if phone number is the right length
    if ( shortPhoneNum( $mobileNumber ) !== false ) {
        header( "Location: ../index.php?signerror=shortnumber" );
        exit();
    }
    //Checks if email is valid
    if ( invalidEmail( $emailAddress ) !== false ) {
        header( "Location: ../index.php?signerror=invalidemail" );
        exit();
    }

    //calls the editProfile function from functions.inc.php
    editProfile( $conn, $uid, $firstName, $middleName, $lastName, $mobileNumber, $emailAddress);


} else {
    header( "Location: ../profile.php" );
    exit();
}

?>
