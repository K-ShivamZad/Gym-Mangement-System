<?php
session_start();
require '../../include/db_conn.php';

// Protect the route
if(!isset($_SESSION["user_data"])) {
    header("location: ../../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gym | Payments</title>
    <link rel="stylesheet" href="../../css/style.css">
    <style>
        /* Add some basic structure if your style.css is missing these */
        .main-content { margin-left: 220px; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
    </style>
</head>
<tbody>
    <?php
        // 1. Define and execute the query BEFORE using $result
        $query = "SELECT u.username, u.mobile, u.dob, p.planName, p.amount, e.paid_date, e.expire 
                  FROM users u
                  LEFT JOIN enrolls_to e ON u.userid = e.uid 
                  LEFT JOIN plan p ON e.pid = p.pid 
                  ORDER BY e.paid_date DESC";
        
        $result = mysqli_query($con, $query); // This creates the $result variable
        $sno = 1;

        // 2. Check if the query itself was successful
        if ($result) {
            if (mysqli_num_rows($result) > 0) { // Now $result is guaranteed to be a mysqli_result object
                while ($row = mysqli_fetch_assoc($result)) {
                    // Calculate Age
                    $dob = new DateTime($row['dob']);
                    $today = new DateTime('today');
                    $age = $dob->diff($today)->y;

                    // Display Row
                    echo "<tr>";
                    echo "<td>" . $sno . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td><strong>" . $age . "</strong> yrs</td>";
                    echo "<td>" . $row['mobile'] . "</td>";
                    echo "<td>" . ($row['planName'] ?? 'No Plan') . "</td>";
                    echo "<td style='color: green; font-weight: bold;'>₹" . ($row['amount'] ?? '0') . "</td>";
                    echo "<td>" . ($row['paid_date'] ?? 'N/A') . "</td>";
                    echo "<td>" . ($row['expire'] ?? 'N/A') . "</td>";
                    echo "</tr>";
                    $sno++;
                }
            } else {
                echo "<tr><td colspan='8' style='text-align:center;'>No payment records found.</td></tr>";
            }
        } else {
            // Error handling if the query fails
            echo "<tr><td colspan='8' style='text-align:center; color:red;'>SQL Error: " . mysqli_error($con) . "</td></tr>";
        }
    ?>
</tbody>
</html>