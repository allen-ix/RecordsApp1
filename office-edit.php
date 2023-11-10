<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Light Bootstrap Dashboard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>

    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>
<?php 
    require("Config/config.php");
    require("Config/db.php");

    // get value sent over
    $id = $_GET['id'];

    // create query
    $query = "SELECT * FROM office WHERE id=" . $id;

    // get result of query
    $result = mysqli_query($conn, $query);

    // check if there are results
    if ($result) {
        $office = mysqli_fetch_array($result);

        // check if $office is not null before accessing its values
        if ($office) {
            $name = $office['name'];
            $contactnum = $office['contactnum'];
            $email = $office['email'];
            $address = $office['address'];
            $city = $office['city'];
            $country = $office['country'];
            $postal = $office['postal'];
        } else {
        
            echo "No office found with ID: " . $id;
            exit;
        }

        // free result
        mysqli_free_result($result);
    } else {
        // Handle the case where the query fails
        echo "Error executing query: " . mysqli_error($conn);
        exit;
    }

    if(isset($_POST["submit"])){
        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $contactnum = mysqli_real_escape_string($conn, $_POST["contactnum"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);
        $city = mysqli_real_escape_string($conn, $_POST["city"]);
        $country = mysqli_real_escape_string($conn, $_POST["country"]);
        $postal = mysqli_real_escape_string($conn, $_POST["postal"]);

        $query = "UPDATE office SET name='$name', contactnum='$contactnum', email='$email', address='$address', city='$city', country='$country', postal='$postal'
               WHERE id=" . $id;
        

        if(mysqli_query($conn, $query)){
            
        }else{
            echo "ERROR: ".mysqli_error($conn);
        }
    }

    // close connection
    mysqli_close($conn);
?>
   

    <div class="wrapper">
        <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

        <div class="sidebar-wrapper">
        <?php include("BS3/sidebar.php"); ?>
        </div>
        </div>

        <div class="main-panel">
        <?php include("BS3/navbar.php"); ?>



        <div class="content">
            <div class="container-fluid">
                <div class="row">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Profile</h4>
                            </div>
                            <div class="content">
                                <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                                    <div class="row">
                                        <div class="col-md-5 pr-1">
                                            <div class="form-group">
                                                <label>Office Name</label>
                                                <input type="text" class="form-control" name="name" value="<?php echo $name;?> ">
                                            </div>
                                        </div>
                                        <div class="col-md-3 px-1">
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input type="text" class="form-control" name="contactnum" value="<?php echo $contactnum;?> ">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control" name="email" value="<?php echo $email;?> ">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address / Building</label>
                                                <input type="text" class="form-control" name="address" value="<?php echo $address;?> ">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 pr-1">
                                            <div class="form-group">
                                                <label>City</label>
                                                <input type="text" class="form-control" name="city" value="<?php echo $city;?> ">
                                            </div>
                                        </div>
                                        <div class="col-md-4 pr-1">
                                            <div class="form-group">
                                                <label>Country</label>
                                                <input type="text" class="form-control" name="country" value="<?php echo $country;?> ">
                                            </div>
                                        </div>
                                        <div class="col-md-4 pr-1">
                                            <div class="form-group">
                                                <label>Postal Code</label>
                                                <input type="text" class="form-control" name="postal" value="<?php echo $postal;?> ">
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" name="submit" value="Submit" class="btn btn-info btn-fill pull-right">Save</button>
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
                <nav class="pull-left">
                    <ul>
                        <li>
                            <a href="#">
                                Home
                            </a>
                        </li>

                    </ul>
                </nav>
                <p class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.creative-tim.com">Creative Tim</a>, made with love for a better web
                </p>
            </div>
        </footer>

    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>


</html>
