<?php
session_start();

// --- DATABASE CONNECTION DIRECTLY IN THE FILE ---
$host = "localhost";
$username = "root";
$password = ""; 
$db_name = "gymsysdb"; 

$con = mysqli_connect($host, $username, $password, $db_name);

if (mysqli_connect_errno()) {
    die("CRITICAL ERROR - DB FAILED: " . mysqli_connect_error());
}
// ------------------------------------------------

// Process the login
if (isset($_POST['btnLogin'])) {
    
    // Sanitize inputs
    $user_id_auth = mysqli_real_escape_string($con, $_POST['user_id_auth']);
    $pass_key = mysqli_real_escape_string($con, $_POST['pass_key']);

    if (empty($user_id_auth) || empty($pass_key)) {
        echo "<script>alert('Username and Password cannot be empty'); window.location.href='index.php';</script>";
        exit();
    }

    // Query the admin table
    $sql = "SELECT * FROM admin WHERE username='$user_id_auth' AND pass_key='$pass_key'";
    $result = mysqli_query($con, $sql);

    // Trap for SQL execution errors
    if (!$result) {
        die("SQL Error: " . mysqli_error($con));
    }

    // If a match is found
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Store Session Data
        $_SESSION['user_data'] = $user_id_auth;
        $_SESSION['logged'] = "start";
        $_SESSION['full_name'] = $row['Full_name'];

        // Redirect to admin dashboard
        header("location: ./dashboard/admin/");
    } else {
        echo "<script>alert('Invalid Username OR Password'); window.location.href='index.php';</script>";
    }
}
?>