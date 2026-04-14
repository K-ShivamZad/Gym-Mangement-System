<?php
session_start();
include '../../include/db_conn.php';

if(!isset($_SESSION["user_data"])) {
    header("location: ../../index.php");
    exit();
}

// Generate a random Membership ID (like in your original project)
$membership_id = time(); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gym | New Entry</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; }
        .sidebar { width: 220px; background: #2b303a; color: white; height: 100vh; position: fixed; padding-top: 20px; }
        .sidebar h2 { text-align: center; margin-bottom: 30px; letter-spacing: 1px; }
        .sidebar a { display: block; color: #cfd8dc; padding: 15px 20px; text-decoration: none; border-left: 4px solid transparent; }
        .sidebar a:hover, .sidebar a.active { background: #1e2229; border-left: 4px solid #007bff; color: white; }
        .main-content { margin-left: 220px; padding: 20px; }
        
        .form-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); max-width: 600px; margin: 20px auto; }
        .form-group { margin-bottom: 15px; display: flex; justify-content: space-between; align-items: center; }
        .form-group label { width: 30%; font-weight: bold; color: #333; }
        .form-group input, .form-group select { width: 65%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-submit { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-size: 16px; margin-top: 10px;}
        .btn-submit:hover { background: #218838; }
    </style>
</head>
<body>

    <?php include '../../include/sidebar.php'; ?>

    <div class="main-content">
        <h2 style="text-align:center;">New Member Registration</h2>
        
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
                    <input type="text" name="city">
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
                            // Fetch plans dynamically from the database
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