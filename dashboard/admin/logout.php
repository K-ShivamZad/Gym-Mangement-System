<?php
session_start();
// Destroy all session variables
session_unset();
session_destroy();
// Redirect back to the main login page
header("location: ../../index.php");
exit();
?>