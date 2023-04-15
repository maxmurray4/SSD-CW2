<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION: code performs user input validation and sanitisation; includes functions to validate fields: phone number, name, email, password, and to create a new user in the database
//
// VULNERABILITY 1: PASSWORD SECURITY - random_bytes() function should be used in addition to hashing the password to make it more difficult for attackers to crack the password using a rainbow table or dictionary attack
// VULNERABILITY 2: uidExists(), if the mysqli_stmt_prepare() returns false, the user is redirected to an error page - better to return generic error msg such as "An error has occured.."
// VULNERABILITY 3: header() redirects user to another page, if error occurrs - exit() script after calling header(), to avoid allowing potential attacker to bypass error page and continue executing arbitrary code
// VULNERABILITY 4: INPUT SANITISATION missing on following functions: emptyInputSignup() function only checks if the input fields are empty
//                                                                     passwordCheck()  only checks if password inserted by user meets criteria
//                                                                     pwdMatch() only checks if passwords match
//                                                                     uidExists() and createUser()  only use prepared tstaments and executes db query
//
// ERROR: in function invalidUid(), the preg_match() function is called with three args instead of three:
// ERROR FIX:  calling function with 2 args - reg ex pattern to match, and the string to match against:
//function invalidUid($firstName, $lastName) {
    //$result;
    //if (!preg_match("/^[a-zA-Z0-9]*$/", $firstName) || !preg_match("/^[a-zA-Z0-9]*$/", $lastName)) {
       // $result = true;
    //} else {
       // $result = false;
   // }
   // return $result;
//}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Checks if number is numeric
function invalPhoneNum( $phoneNumber ) {
    $result;
    if ( !is_numeric( $phoneNumber ) ) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

//Checks if number length is not equal to 11
function shortPhoneNum( $phoneNumber ) {
    $result;
    if ( strlen( $phoneNumber ) != 11 ) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
//Checks if name contains numbers
function conLetter( $firstName, $middleName, $lastName ) {
    $result;
    if ( is_numeric( $firstName ) || is_numeric( $middleName ) || is_numeric( $lastName ) ) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
// function that contains the variables for the user to sign up to the website.
function emptyInputSignup( $username, $email, $password, $pswRepeat ) {
    $result;
    // if statement to test if the fields are empty or if data has been inputted into them
    if ( empty( $username ) || empty( $email ) || empty( $password ) || empty( $pswRepeat ) ) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
// function to check the password fits the wesbites criteria of passwordsd
function passwordCheck( $password ) {
    $result;
    $counter = 0;
    // preg_match is used to see if anything in the variable matches the parameters set below in the if statements and if so then the variable counter is incremented by 1
    if ( strlen( $password ) > 7 ) {
        $counter++;
    }
    if ( preg_match( "#[0-9]+#", $password ) ) {
        $counter++;
    }
    if ( preg_match( "#[A-Z]+#", $password ) ) {
        $counter++;
    }
    if ( preg_match( "#[a-z]+#", $password ) ) {
        $counter++;
    }
    if ( preg_match( '/[\'^£$%&*()}{@#~?><>,;:|=_+¬-]/', $password ) ) {
        $counter++;
    }
    if ( $counter != 5 ) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidUid( $firstName, $lastName ) {
    $result;
    // checks to see that the first and last name of the user matches the parameters set below in the if statement and if they do then the result is true and if not then returns false
    if ( !preg_match( "/^[a-zA-Z0-9]*$/", $firstName, $lastName ) ) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function invalidEmail( $email ) {
    $result;
    // filter_var is used to check and sanitise the data that the user is inputting into the email field to make sure it is an actaal email address
    if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}

function pwdMatch( $password, $pswRepeat ) {
    $result;
    // check to make sure that the passowrd inputted by the user matches the repeated password that the website asks for in order to make the password for the website
    if ( $password !== $pswRepeat ) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
// function to check that the user exists by checking the email address previously entered and checking that it exists within the SQL database
function uidExists( $conn, $email ) {
    $sql = "SELECT * FROM user WHERE email = ?;";
    $stmt = mysqli_stmt_init( $conn );

    if ( !mysqli_stmt_prepare( $stmt, $sql ) ) {
        header( "location: ../errorpage.php" );
        exit();
    }
    mysqli_stmt_bind_param( $stmt, "s", $email );
    mysqli_stmt_execute( $stmt );

    $resultData = mysqli_stmt_get_result( $stmt );

    if ( $row = mysqli_fetch_assoc( $resultData ) ) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close( $stmt );
}
// function to create the user within the database and then add the user's data they have inputted into the database to then create the profile for the user
function createUser( $conn, $firstName, $middlename, $lastName, $phoneNumber, $email, $password ) {
    $sql = "INSERT INTO user (firstName, middleName, lastName, mobile, email, passwordHash, registeredAt) VALUES (?, ?, ?, ?, ?, ?, now());";
    $stmt = mysqli_stmt_init( $conn );

    if ( !mysqli_stmt_prepare( $stmt, $sql ) ) {
        header( "location: ../errorpage.php" );
        exit();
    }
    // hashing the password in order to keep the user's password secure as we are not saving the password in the database as plain text
    $hashedPassword = password_hash( $password, PASSWORD_DEFAULT );

    mysqli_stmt_bind_param( $stmt, "ssssss", $firstName, $middleName, $lastName, $phoneNumber, $email, $hashedPassword );
    mysqli_stmt_execute( $stmt );
    mysqli_stmt_close( $stmt );
    header( "Location: ../index.php?error=none" );
}
// ----------------------------loginFunctions--------------------------
// function to check if the username and password field is empty or if the user has inputted data within the fields
function emptyInputLogin( $username, $password ) {
    $result;
    if ( empty( $username ) || empty( $password ) ) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
// function for the user to login to the website by checking the username and password matches with the username and passwords that are stored within the SQL database if it does
// then the user will be directed to the home page of the website and if the data doesnt match the user will be redirected to the login page to input the data again
function loginUser( $conn, $userLogin, $password ) {

    $stmt = $conn->prepare( "SELECT id, firstName, middleName, lastName, mobile, email, passwordHash FROM user WHERE email = ? OR mobile = ?" );
    $stmt->bind_param( "ss", $userLogin, $userLogin );
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result( $uid, $firstName, $middleName, $lastName, $mobile, $email, $hash );

    if ( $stmt->num_rows == 1 ) {
        $stmt->fetch();
        if ( password_verify( $password, $hash ) ) {
            session_start();
            $_SESSION[ 'uid' ] = $uid;
            $_SESSION[ 'firstName' ] = $firstName;
            $_SESSION[ 'middleName' ] = $middleName;
            $_SESSION[ 'lastName' ] = $lastName;
            $_SESSION[ 'mobileNumber' ] = $mobile;
            $_SESSION[ 'emailAddress' ] = $email;
            $_SESSION[ 'loggedIn' ] = true; //set you've logged in
            $_SESSION[ 'lastActivity' ] = time(); //your last activity was now, having logged in.
            $_SESSION[ 'expireTime' ] = 15 * 60; //expire time in seconds: 15 minutes
            $sql = "UPDATE user SET lastLogin=now() WHERE id=?";
            $stmt = $conn->prepare( $sql );
            $stmt->bind_param( "i", $uid );
            $stmt->execute();
            mysqli_stmt_close( $stmt );
            header( "Location: ../index.php" );
        } else {
            header( "Location: ../index.php?logerror" );
        }
    } else {
        header( "Location: ../index.php?logerror" );
    }
    $stmt->close();
}
// ----------------------------Upload Blog Function--------------------------
// function to check if the user is trying to post an empty blog
function emptyInputPost( $blogTitle, $blogImage ) {
    $result;
    if ( empty( $blogTitle ) || empty( $blogImage ) ) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
// function to upload the user's blog to the website it does this by putting the data that the user has inputted in the seperate fields into variables and it then stores these
// variables and stores these within the database and from there the data is fetched and then executed to create the blog post on the website
function uploadBlog( $conn, $uid, $blogTitle, $blogSummary, $blogContent, $newImgName ) {
    $sql = "INSERT INTO post (authorId, title, summary, createdAt, content, imgName) VALUES (?, ?, ?, now(), ?, ?);";
    $stmt = mysqli_stmt_init( $conn );

    if ( !mysqli_stmt_prepare( $stmt, $sql ) ) {
        header( "location: ../post.php?error=dbfailure" );
        exit();
    }

    mysqli_stmt_bind_param( $stmt, "issss", $uid, $blogTitle, $blogSummary, $blogContent, $newImgName );
    mysqli_stmt_execute( $stmt );
    mysqli_stmt_close( $stmt );
    header( "Location: ../index.php?error=none" );
}
// ----------------------------Retrieve Blog's for Index Function--------------------------
function getBlogs( $conn ) {
    $stmt = $conn->prepare( "SELECT id, title, summary, imgName FROM `post` ORDER BY `createdAt` DESC" );
    $stmt->execute();
    $stmt->bind_result( $blogId, $blogTitle, $blogSummary, $imgName );
    // retrieving the users blog and then gives the image a maximum height and width for it to be presented on the user's device
    while ( $stmt->fetch() ) {
        echo '<div class="col-lg-4 col-md-4 col-sm-12">
          <div class="card mb-5 shadow-sm">
          <img src="../uploads/' . $imgName . '" class="img-fluid" style="max-height:550px;max-width:100%"/>
          <div clas="card-body">
            <div class="card-title">
              <h2>' . $blogTitle . '</h2>
            </div>
            <div class="card-text">
             <p>
             ' . $blogSummary . '
             </p>
            </div>
            <a href="blog.php?id=' . $blogId . '" class="btn btn-outline-primary rounded-0 float-end">Read More</a>
          </div>
        </div>
      </div>';
    }
    $stmt->close();
}
// ----------------------------Update User Profile --------------------------
// function to check that tyhe fields that are presented to the user are empty or not if so return true and if the fields are filled then return false
function emptyInputProfile( $firstName, $lastName, $mobileNumber, $emailAddress ) {
    $result;
    if ( empty( $firstName ) || empty( $lastName ) || empty( $mobileNumber ) || empty( $emailAddress ) ) {
        $result = true;
    } else {
        $result = false;
    }
    return $result;
}
// function for the user to edit their profile based on what they input into the fields
function editProfile( $conn, $uid, $firstName, $middleName, $lastName, $mobileNumber, $emailAddress ) {
    $sql = "UPDATE user SET firstName=?, middleName=?, lastName=?, mobile=?, email=? WHERE id=?";
    $stmt = $conn->prepare( $sql );

    if ( !mysqli_stmt_prepare( $stmt, $sql ) ) {
        header( "location: ../errorpage.php" );
        exit();
    }
    // Updates the user's data within the database dependent on what they input into the fields when they are editting their profile information
    $stmt->bind_param( "sssssi", $firstName, $middleName, $lastName, $mobileNumber, $emailAddress, $uid );
    $stmt->execute();
    mysqli_stmt_close( $stmt );
    $_SESSION[ 'firstName' ] = $firstName;
    $_SESSION[ 'middleName' ] = $middleName;
    $_SESSION[ 'lastName' ] = $lastName;
    $_SESSION[ 'mobileNumber' ] = $mobileNumber;
    $_SESSION[ 'emailAddress' ] = $emailAddress;
    header( "Location: ../profile.php?error=none" );
}
//This function runs a SELECT query to get all blogs which have been posted by the logged in user and will be used to display in profile.php
function displayProBlog( $conn ) {
    $flag = false;
    $uid = $_SESSION[ 'uid' ];
    $sql = "SELECT * FROM `post` WHERE authorId=" . $uid . ";";
    $stmt = mysqli_stmt_init( $conn );
    if ( !mysqli_stmt_prepare( $stmt, $sql ) ) {
        header( "location: ../errorpage.php" );
        exit();
    }
    mysqli_stmt_execute( $stmt );
    $result = mysqli_stmt_get_result( $stmt );
    while ( $row = mysqli_fetch_assoc( $result ) ) {
        echo ' <div class="con_box"> <img src="uploads/' . $row[ 'imgName' ] . ' "  style="width:100%; height: 200px;">';
        echo ' <div class="blog_con"><h4 class="blog_fon crop_title">' . $row[ 'title' ] . '</h4>';
        echo '<p class="blog_fon crop">' . $row[ 'summary' ] . '</p></div><form method="post" action="include/deletepost.inc.php"><button value=' . $row[ 'id' ] . ' class="blog_btn" name="submit">Delete</button></form></div>';
        $flag = true;
    }
    return $flag;
}
// This function is used to delete the users blog and is used in profile.php
function deleteProBlog( $conn, $postID ) {
    $uid = $_SESSION[ 'uid' ];
    $sql = "SELECT authorId, imgName FROM `post` WHERE authorId=" . $uid . " AND id=" . $postID . ";";
    $stmt = mysqli_stmt_init( $conn );
    if ( !mysqli_stmt_prepare( $stmt, $sql ) ) {
        header( "location: ../errorpage.php" );
        exit();
    }
    mysqli_stmt_execute( $stmt );
    $result = mysqli_stmt_get_result( $stmt );
    while ( $row = mysqli_fetch_assoc( $result ) ) {
        $sql = "DELETE FROM `post` WHERE id=" . $postID . "; ";
        if ( !mysqli_stmt_prepare( $stmt, $sql ) ) {
            header( "location: ../errorpage.php" );
            exit();
        }
        mysqli_stmt_execute( $stmt );
        $imgPath = "../uploads/" . $row[ 'imgName' ];
        unlink( $imgPath );
    }
}


// ---------------------------- Contact Page --------------------------
// Post function to INSERT comment into database
function postContact( $conn, $name, $number, $email, $message ) {
    $sql = "INSERT INTO contact (contactName, contactNumber, contactEmail, contactMessage) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init( $conn );
    if ( !mysqli_stmt_prepare( $stmt, $sql ) ) {
        header( "location: ../errorpage.php" );
        exit();
    }
    mysqli_stmt_bind_param( $stmt, "ssss", $name, $number, $email, $message );
    mysqli_stmt_execute( $stmt );
    mysqli_stmt_close( $stmt );
    header( "Location: ../contact.php?error=none" );
}
?>
