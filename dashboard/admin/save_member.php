<?php
session_start();
include '../../include/db_conn.php';

if (!isset($_SESSION["user_data"])) {
    header("location: ../../index.php");
    exit();
}

if (isset($_POST['submit'])) {
    // 1. Sanitize all inputs to prevent SQL injection
    $memID = mysqli_real_escape_string($con, $_POST['m_id']);
    $uname = mysqli_real_escape_string($con, $_POST['u_name']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $dob = mysqli_real_escape_string($con, $_POST['dob']);
    $jdate = mysqli_real_escape_string($con, $_POST['jdate']);
    $street_name = mysqli_real_escape_string($con, $_POST['street_name']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $state = mysqli_real_escape_string($con, $_POST['state']);
    $zipcode = mysqli_real_escape_string($con, $_POST['zipcode']);
    $plan = mysqli_real_escape_string($con, $_POST['plan']);

    // 2. Insert into `users` table
    $query1 = "INSERT INTO users (userid, username, gender, mobile, email, dob, joining_date) 
               VALUES ('$memID', '$uname', '$gender', '$mobile', '$email', '$dob', '$jdate')";

    if (mysqli_query($con, $query1)) {
        
        // 3. Fetch the selected plan's validity (in months) to calculate expiration
        $plan_query = "SELECT validity FROM plan WHERE pid='$plan'";
        $plan_result = mysqli_query($con, $plan_query);
        $plan_row = mysqli_fetch_assoc($plan_result);
        $validity_months = $plan_row['validity'];
        
        // Calculate expiration date automatically
        $expire_date = date('Y-m-d', strtotime("+$validity_months months", strtotime($jdate)));

        // 4. Insert into `enrolls_to` table
        $query2 = "INSERT INTO enrolls_to (pid, uid, paid_date, expire, renewal) 
                   VALUES ('$plan', '$memID', '$jdate', '$expire_date', 'yes')";
        mysqli_query($con, $query2);

        // 5. Insert into `health_status` table (with default 0 values)
        $query3 = "INSERT INTO health_status (uid) VALUES ('$memID')";
        mysqli_query($con, $query3);

        // 6. Insert into `address` table
        $query4 = "INSERT INTO address (id, streetName, state, city, zipcode) 
                   VALUES ('$memID', '$street_name', '$state', '$city', '$zipcode')";
        mysqli_query($con, $query4);

        // Success Alert and Redirect
        echo "<script>alert('Member Successfully Registered!'); window.location.href='new_entry.php';</script>";
    } else {
        // Error Alert
        echo "<script>alert('Error: Could not register member.'); window.location.href='new_entry.php';</script>";
    }
}
?>