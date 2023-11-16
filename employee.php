<!doctype html>
<html lang="en">
<head>
<style> 
    .table { 
        -webkit-text-fill-color: black;
    }
 </style>
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

    //define total number of results you want per page
    $results_per_page = 10;

    //find the total number of results/rows stored in database
    $query = "SELECT * FROM employee";
    $result = mysqli_query($conn, $query);
    $number_of_result = mysqli_num_rows($result);

    //detremine the total number of pages available
    $number_of_page = ceil($number_of_result / $results_per_page);
    
    // determine which page number visitor is currently on
    if(!isset($_GET['page'])) {
        $page = 1;
    } else{
        $page = $_GET['page'];
    }

    // determine the sqll LIMIT starting number for the results on the display page
    $page_first_result = ($page-1) * $results_per_page;
    
    $query = 'SELECT employee.id, employee.lastname, employee.firstname, employee.address, office.name as office_name FROM employee, office WHERE employee.office_id = office.id ORDER BY employee.lastname LIMIT '. $page_first_result . ',' . $results_per_page;
    $result = mysqli_query($conn, $query);

    $employees = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    mysqli_close($conn);
    ?>

<div class="wrapper">
    <div class="sidebar" data-color="green" data-image="assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    <div class="sidebar-wrapper">
    <?php include("BS3/sidebar.php"); ?>
    </div>
    </div>

    <div class="main-panel">
    <?php include("BS3/navbar.php"); ?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                            <br/>
                                <div class="col-md-12">
                                    <a href="/employee-add.php">
                                        <button type="submit" class="btn btn-info btn-fill pull-right">Add New Employee</button>
                                    </a>
                                </div>
                            <div class="card-header ">
                                    <h4 class="card-title"><strong>Employees</strong></h4>
                                    <p class="card-category">Here is a subtitle for this table</p>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <th>Last name</th>
                                            <th>First name</th>
                                            <th>Address</th>
                                            <th>Office</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach($employees  as $employee) : ?>
                                            <tr>
                                                <td><?php echo $employee['lastname']; ?></td>
                                                <td><?php echo $employee['firstname']; ?></td>
                                                <td><?php echo $employee['address']; ?></td>
                                                <td><?php echo $employee['office_name']; ?></td>
                                                <td>
                                                    <a href="/employee-edit.php?id=<?php echo $employee['id']; ?>">
                                                        <button type="submit" class="btn btn-success btn-fill pull-right">Edit</button>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-fill pull-right" onclick="confirmDelete(<?php echo $employee['id']; ?>)">Delete</button>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>

                                        <script>
                                            function confirmDelete(employeeId) {
                                                var confirmation = confirm("Are you sure you want to delete this employee?");
                                                if (confirmation) {
                                                    // Redirect to office-delete.php with the office ID
                                                    window.location.href = "/employee-delete.php?id=" + employeeId;
                                                }
                                            }
                                        </script>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        for($page=1; $page <= $number_of_page; $page++){
                            echo '<a href = "employee.php?page='. $page .'">' . $page .'</a>';
                        }
                    ?>
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
