<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION: Retrieves comments for a certain blog post from the db and displays output in a card layout format
//
// VULNERABILITY: CSRF token missing on all requests and forms made/completed by the user;
//                add CSRF token with random_bytes or openssl_random_pseudo_bytes to prevent a malicious user from tricking an authenticated user into executing unwanted actions on a web application.
//
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Calls external file
require_once 'dbh.inc.php';
//Starts session
session_start();

$blogID = $_GET["id"];
//Checks if user ID is set
if(isset($_SESSION['uid'])) {
	$uid = $_SESSION['uid'];
}else {
	$uid = 0;
}
//SQL statement to get comments
$stmt = $conn->prepare("SELECT `post_comment`.id, `post_comment`.createdAt, `post_comment`.content, `user`.firstName, `user`.middleName, `user`.lastName, `post_comment`.userID FROM `post_comment` JOIN `user` ON `user`.id = `post_comment`.userID WHERE `post_comment`.postId = ?");
$stmt->bind_param("i", $blogID);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($PID, $createdAt, $content, $firstName, $middleName, $lastName, $commentUID);

if($stmt->num_rows > 0) {
    echo '
    <div class="container">
    <div class="row d-flex justify-content-center">
    <div class="col-md-12">
    ';
    while($stmt->fetch()) {
    $date = date("d F Y, h:i:s A", strtotime($createdAt));
    echo '
    <div class="card p-3 mt-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="user d-flex flex-row align-items-center col-md-10"><span><small class="font-weight-bold text-primary">'.$firstName.' '.$middleName.' '.$lastName.'</small> <small class="font-weight-bold">'.$content.'</small></span> </div> <small>'.$date.'</small>
                </div>
            </div>
    </div>
    </div>
    </div>
    </div>
    ';
}
}

?>
