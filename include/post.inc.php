<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// DESCRIPTION: manages the upload of blog posts by starting session, checking if submit button was pressed, and if an image was uploades
//              checks for image upload errors, as well as if the file size exceeds 2mb; it also specifies the formats which are not accepted
//              creates a new, unique image name and uploads it to the directory if no error occur
//              if errors present, submit button is not pressed, or image is not uploaded, user is redirected to post.php with error msg appended to URL
//
// VULNERABILITY: Missing CSRF token - fixed as example in commented code below
//
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Starts session
session_start();

// Generate CSRF token mitigation example
//$token = byn2hex(random_bytes(64));
//$_SESSION['csrf_token'] = $token;

// Form output with CSRF token
//echo '<form method="post" enctype="multipart/form-data">';
//echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
// .....
//echo '</form>';

//Checks if submit button is pressed and an image has been uploaded
if (isset($_POST["submit"]) && isset($_FILES["blogImage"])) {

	// Check CSRF token
	//if (!hash_equals($_SESSION['csrfToken'], $_POST['csrfToken'])) {
		// For invalid CSRF token, redirect user to post.php
		//header("Location: ../post.php?error=csrf");
		//exit();
	//}

	//Calls external files
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

	//Variables
    $blogTitle = $_POST["blogTitle"];
    $blogSummary = $_POST["blogSummary"];
    $blogContent = $_POST["blogContent"];
    $imgName = $_FILES["blogImage"]["name"];
    $imgSize = $_FILES["blogImage"]["size"];
    $tmpName = $_FILES["blogImage"]["tmp_name"];
    $error = $_FILES["blogImage"]["error"];
    $uid = $_SESSION["uid"];

	//If there is no error
    if ($error === 0) {
		if ($imgSize > 2097152) { // 2mb
			$em = "Sorry, your file is too large.";
		    header("Location: ../post.php?error=$em");
		}else {
			$imgEx = pathinfo($imgName, PATHINFO_EXTENSION);
			$imgExLc = strtolower($imgEx);

			$allowedExs = array("jpg", "jpeg", "png");

			if (in_array($imgExLc, $allowedExs)) {
				$newImgName = uniqid("IMG-", true).'.'.$imgExLc;
				$uploadPath = $_SERVER['DOCUMENT_ROOT'] . "/uploads/".$newImgName;
				if(move_uploaded_file($tmpName, $uploadPath)) {
                }else {
                    $em = "File upload failure";
                    header("Location: ../post.php?error=$em");
                }

			}else {
				$em = "You can't upload files of this type";
		        header("Location: ../post.php?error=$em");
			}
		}
	}else {
		$em = "unknown error occurred!";
		header("Location: ../post.php?error=$em");
	}

	//Calls uploadBlog function from functions.inc.php
    uploadBlog($conn, $uid, $blogTitle, $blogSummary, $blogContent, $newImgName);

}else {
    header("Location: ../post.php?error=submiterror");
    exit();
}
?>
