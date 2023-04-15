<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION: script processes from data submitted by user
//              checks user's input against validation criteria using the functions from functions.php;
//              if any check fails or user hasn't pressed submit, user is redirected to index.,php with error msg appended to URL
//              if checks pass, the function createUser() inserts user's form data into the db (creates the user proflie/account)
//
// VULNERABILITY: Missing CSRF token protection - generation of unique token and inclusion in hidden input fields in the form to defend from Cross Site Request Forgery
//
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if ( isset( $_POST[ "submit" ] ) ) {

    //Variables
    $firstName = $_POST[ "firstName" ];
    $middleName = $_POST[ "middleName" ];
    $lastName = $_POST[ "surname" ];
    $phoneNumber = $_POST[ "phoneNumber" ];
    $email = $_POST[ "email" ];
    $password = $_POST[ "registerPassword" ];
    $pswRepeat = $_POST[ "confirmPassword" ];

    //Calls external files
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    //Checks if usernames contains numbers or not
    if ( conLetter( $firstName, $middleName, $lastName ) !== false ) {
        header( "Location: ../index.php?signerror=invalidmatch" );
        exit();
    }
    //Checks if input is empty
    if ( emptyInputSignup( $firstName, $lastName, $email, $password, $pswRepeat ) !== false ) {
        header( "Location: ../index.php?signerror=emptyinput" );
        exit();
    }
    //Checks if user exist
    if ( invalidUid( $firstName, $lastName ) !== false ) {
        header( "Location:../index.php?signerror=invaliduid" );
        exit();
    }
    //Checks if email
    if ( invalidEmail( $email ) !== false ) {
        header( "Location: ../index.php?signerror=invalidemail" );
        exit();
    }
    //Checks if users passwords match with the confirm password field
    if ( pwdMatch( $password, $pswRepeat ) !== false ) {
        header( "Location: ../index.php?signerror=nomatch" );
        exit();
    }
    //Checks if user exists
    if ( uidExists( $conn, $email, $phoneNumber) !== false ) {
        header( "Location: ../index.php?signerror=takenusername" );
        exit();
    }
    //Checks if phone number is valid
    if ( invalPhoneNum( $phoneNumber ) !== false ) {
        header( "Location: ../index.php?signerror=invalidnumber" );
        exit();
    }
    //Checks if phone number is the right length
    if ( shortPhoneNum( $phoneNumber ) !== false ) {
        header( "Location: ../index.php?signerror=shortnumber" );
        exit();
    }
    //Checks password
    if ( passwordCheck( $password ) !== false ) {
        header( "Location: ../index.php?signerror=invalidpassword" );
        exit();
    }

    //Runs createUser function from functions.inc.php
    createUser( $conn, $firstName, $middleName, $lastName, $phoneNumber, $email, $password );


} else {
    header( "Location: ../index.php" );
    exit();
}

?>
