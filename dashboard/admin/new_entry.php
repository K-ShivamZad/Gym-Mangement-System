<?php
session_start();
include '../../include/db_conn.php';

if(!isset($_SESSION["user_data"])) {
    header("location: ../../index.php");
    exit();
}
$membership_id = time(); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gym | New Entry</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>

    <?php include '../../include/sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h2>New Member Registration</h2>
            <div>
                <a href="logout.php" class="logout-btn">Log Out</a>
            </div>
        </div>
        
        <div class="form-container">
            <form action="save_member.php" method="POST">
                
                <div class="form-group">
                    <label>Membership ID:</label>
                    <input type="text" name="m_id" value="<?php echo $membership_id; ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label>Full Name:</label>
                    <input type="text" name="u_name" required>
                </div>

                <div class="form-group">
                    <label>Gender:</label>
                    <select name="gender" required>
                        <option value="">--Please Select--</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Phone No:</label>
                    <input type="text" name="mobile" required>
                </div>

                <div class="form-group">
                    <label>Email ID:</label>
                    <input type="email" name="email">
                </div>

                <div class="form-group">
                    <label>Date of Birth:</label>
                    <input type="date" name="dob" required>
                </div>

                <div class="form-group">
                    <label>Joining Date:</label>
                    <input type="date" name="jdate" required>
                </div>

                <div class="form-group">
                    <label>Street Name:</label>
                    <input type="text" name="street_name">
                </div>

                <div class="form-group">
                    <label>City:</label>
                    <select name="city" required>
                    <option value="">--Select City--</option>
                    <option value="Lucknow">Lucknow</option>
                    <option value="Gautam Buddha Nagar">Gautam Buddha Nagar</option>
                    <option value="Prayagraj">Prayagraj</option>
                   <option value="Azamgarh">Azamgarh</option>
                   </select>
                </div>

                

                <div class="form-group">
                    <label>State:</label>
                    <input type="text" name="state">
                </div>

                <div class="form-group">
                    <label>Zipcode:</label>
                    <input type="text" name="zipcode">
                </div>

                <div class="form-group">
                    <label>Select Plan:</label>
                    <select name="plan" required>
                        <option value="">--Please Select--</option>
                        <?php
                            $query = "SELECT * FROM plan";
                            $result = mysqli_query($con, $query);
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<option value='".$row['pid']."'>".$row['planName']." (₹".$row['amount'].")</option>";
                                }
                            }
                        ?>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn-submit">Register Member</button>
            </form>
        </div>
    </div>

</body>
</html>