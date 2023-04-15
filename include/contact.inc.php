<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION: handles form submission form; it checks if the form was submitted(verify if Submit buttion was clicked), if it did, it retrieves values of the form field
//              validates email and phone no fields calling the functions from function.inc.php and checks if returned value is false or not
//              if any field is invalid, redirects back to contact page with error message appended in the URL
//              if all fields valid, the function postContact() is called from functions.inc.php with the vars as parameters; function inserts contact info into the db
//              if form not submitted because user accessed the page directly, it redirects user to the contact page
//
// VULNERABILITY: check for input validation; missing INPUT SANITISATION
// VULNERABILITY: missing CSRF token, lack of authorisation and authentication (check if functions or other pages control if user is authorized to access the page or perform the action.  )
//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



if ( isset( $_POST[ "submit" ] ) ) {

    //Variables
    $name = $_POST['name'];
    $number = $_POST['phonenumber'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Calls external files
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    //If email is invalid
    if ( invalidEmail( $email ) !== false ) {
        header( "Location: ../contact.php?error=invalidemail" );
        exit();
    }
    //If phone number is invalid
    if ( invalPhoneNum( $number ) !== false ) {
        header( "Location: ../contact.php?error=invalidnumber" );
        exit();
    }
    //If phone number is too short
    if ( shortPhoneNum( $number ) !== false ) {
        header( "Location: ../contact.php?error=shortnumber" );
        exit();
    }

    //Runs postContact function from functions.inc.php file
    postContact( $conn, $name, $number, $email, $message);


} else {
    // Redirect
    header( "Location: ../contact.php" );
    exit();
}

?>
