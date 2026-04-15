<?php
if (isset($_POST['submit'])) {
    // ... (Keep your sanitization variables $memID, $uname, etc. here) ...

    // Start a transaction to ensure all tables update or none do
    mysqli_begin_transaction($con);

    try {
        $query1 = "INSERT INTO users (userid, username, gender, mobile, email, dob, joining_date) 
                   VALUES ('$memID', '$uname', '$gender', '$mobile', '$email', '$dob', '$jdate')";
        mysqli_query($con, $query1);

        $plan_query = "SELECT validity FROM plan WHERE pid='$plan'";
        $plan_result = mysqli_query($con, $plan_query);
        
        // Bug Fix: Check if the plan actually exists before calculating
        if ($plan_row = mysqli_fetch_assoc($plan_result)) {
            $validity_months = $plan_row['validity'];
            $expire_date = date('Y-m-d', strtotime("+$validity_months months", strtotime($jdate)));
        } else {
            throw new Exception("Selected Plan not found.");
        }

        $query2 = "INSERT INTO enrolls_to (pid, uid, paid_date, expire, renewal) 
                   VALUES ('$plan', '$memID', '$jdate', '$expire_date', 'yes')";
        mysqli_query($con, $query2);

        $query3 = "INSERT INTO health_status (uid) VALUES ('$memID')";
        mysqli_query($con, $query3);

        $query4 = "INSERT INTO address (id, streetName, state, city, zipcode) 
                   VALUES ('$memID', '$street_name', '$state', '$city', '$zipcode')";
        mysqli_query($con, $query4);

        // Commit all changes if everything succeeds
        mysqli_commit($con);
        echo "<script>alert('Member Successfully Registered!'); window.location.href='new_entry.php';</script>";

    } catch (Exception $e) {
        // Rollback all changes if ANY query fails
        mysqli_rollback($con);
        echo "<script>alert('Registration Failed: " . $e->getMessage() . "'); window.location.href='new_entry.php';</script>";
    }
}
?>