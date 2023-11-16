<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Light Bootstrap Dashboard - Free Bootstrap 4 Admin Dashboard by Creative Tim</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="assets/css/demo.css" rel="stylesheet" />
</head>

<body>

<?php
require("config/config.php");
require("config/db.php");

// Initialize variables
$id = isset($_GET['id']) ? $_GET['id'] : '';
$lastname = '';
$firstname = '';
$office_id = '';
$address = '';

// Fetch data if 'id' is set
if (!empty($id)) {
    $query = "SELECT * FROM employee WHERE id=" . $id;
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $employee = mysqli_fetch_array($result);
        $lastname = $employee['lastname'];
        $firstname = $employee['firstname'];
        $office_id = $employee['office_id'];
        $address = $employee['address'];
    }

    // Free result
    mysqli_free_result($result);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize form data
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $office_id = $_POST['office_id'];
    $address = $_POST['address'];

    // Check if 'Select....' is selected for office_id
    if ($office_id == 'Select....') {
        echo 'Please select a valid office.';
    } else {
        // Update query
        $query = "UPDATE recordsapp_db.employee SET lastname=?, firstname=?, office_id=?, address=? WHERE employee.id=?";
        
        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssisi", $lastname, $firstname, $office_id, $address, $id);

        // Execute query
        if (mysqli_stmt_execute($stmt)) {
            echo 'Success!';
            // Redirect to employee page
            header("Location: employee.php");
            exit();
        } else {
            echo 'ERROR: ' . mysqli_error($conn);
            echo 'Query: ' . $query;
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}


// Fetch office data
$officeOptions = '';
$query = "SELECT id, name FROM office";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result)) {
    if ($row['id'] == $office_id) {
        $officeOptions .= "<option value='{$row["id"]}' selected>{$row["name"]}</option>";
    } else {
        $officeOptions .= "<option value='{$row["id"]}'>{$row["name"]}</option>";
    }
}

// Close connection
mysqli_close($conn);

?>


<div class="wrapper">
    <div class="sidebar" data-image="../assets/img/sidebar-5.jpg">
        <div class="sidebar-wrapper">
            <?php include("BS3/sidebar.php") ?>
        </div>
    </div>
    <div class="main-panel">
        <?php include("BS3/navbar.php"); ?>
        <div class="content">
            <div class="container-fluid">
                <div class="section">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Profile</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action ="<?php $_SERVER['PHP_SELF']; ?>">
                                    <button type="submit" name="submit" value="Submit" class="btn btn-info btn-fill pull-right">Update</button>
                                    <div class="row">
                                        <div class="col-md-4 pr-1">
                                            <div class="form-group">
                                                <label>Last name</label>
                                                <input name="lastname" type="text" class="form-control" value="<?php echo $lastname;?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4 pr-1">
                                            <div class="form-group">
                                                <label>First name</label>
                                                <input name="firstname" type="text" class="form-control" value="<?php echo $firstname;?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address / Building</label>
                                                <input type="text" class="form-control" name="address" value="<?php echo $address;?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 pr-1">
                                        <div class="form-group">
                                            <label for="exampleInputEmail">Office</label>
                                            <select class="form-control" name='office_id'>
                                                <option>Select....</option>
                                                <?php echo $officeOptions; ?>
                                            
                                            </select>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <nav>
                    <ul class="footer-menu">
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Company
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Portfolio
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Blog
                            </a>
                        </li>
                    </ul>
                    <p class="copyright text-center">
                        ©
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                    </p>
                </nav>
            </div>
        </footer>
    </div>
</div>

</body>
<!-- Core JS Files -->
<script src="assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="assets/js/core/popper.min.js
