<?php
// start session in order to get the session we then unset it and we then destroy in order to log the user out
session_start();
session_unset();
session_destroy();

header( "Location: ../index.php" );
exit();
?>
