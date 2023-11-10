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

// get the value sent over the search form
$search = isset($_GET['search']) ? $_GET['search'] : '';

// define the total number of results you want per page
$results_per_page = 10;

// find the total number of results/rows stored in the database
$query = "SELECT * FROM transaction";
$result = mysqli_query($conn, $query);
$number_of_result = mysqli_num_rows($result);

// determine the total number of pages available
$number_of_page = ceil($number_of_result / $results_per_page);

// determine which page number visitor is currently on
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

// determine the SQL LIMIT starting number for the results on the display page
$page_first_result = ($page - 1) * $results_per_page;

if (strlen($search) > 0) {
    // Use prepared statement to prevent SQL injection
    $query = 'SELECT transaction.datelog, transaction.documentcode, transaction.action, office.name as office_name, CONCAT(employee.lastname,",", employee.firstname) as employee_fullname, transaction.remarks FROM recordsapp_db.employee, recordsapp_db.office, recordsapp_db.transaction
        WHERE transaction.employee_id=employee.id and transaction.office_id=office.id and transaction.documentcode = ? ORDER BY transaction.documentcode, transaction.datelog LIMIT ?, ?';

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, 'sii', $search, $page_first_result, $results_per_page);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the data
    $transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    $query = 'SELECT transaction.datelog, transaction.documentcode, transaction.action, office.name as office_name, CONCAT(employee.lastname,",", employee.firstname) as employee_fullname, transaction.remarks FROM recordsapp_db.employee, recordsapp_db.office, recordsapp_db.transaction
        WHERE transaction.employee_id=employee.id and transaction.office_id=office.id ORDER BY transaction.documentcode, transaction.datelog LIMIT ?, ?';

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $query);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, 'ii', $page_first_result, $results_per_page);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Get the result set
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the data
    $transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Close the statement
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<div class="wrapper">
    <div class="sidebar" data-color="red" data-image="assets/img/sidebar-5.jpg">

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
                                    <form action="/transaction.php" method="GET">
                                        <input type="text" name="search" />
                                        <input type="submit" value="Search" class="btn btn-danger btn-fill" />
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <a href="/transaction-add.php">
                                        <button type="submit" class="btn btn-danger btn-fill pull-right">Add New Transaction</button>
                                    </a>
                                </div>
                                <div class="card-header ">
                                    <h4 class="card-title"><strong>Transactions</strong></h4>
                                    <p class="card-category">Here is a subtitle for this table</p>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <th>Datelog</th>
                                            <th>Document code</th>
                                            <th>Action</th>
                                            <th>Office</th>
                                            <th>Employee</th>
                                            <th>Remarks</th>
                                        </thead>
                                        <tbody>
                                            <?php foreach($transactions as $transaction) : ?>
                                            <tr>
                                                <td><?php echo $transaction['datelog']; ?></td>
                                                <td><?php echo $transaction['documentcode']; ?></td>
                                                <td><?php echo $transaction['action']; ?></td>
                                                <td><?php echo $transaction['office_name']; ?></td>
                                                <td><?php echo $transaction['employee_fullname']; ?></td>
                                                <td><?php echo $transaction['remarks']; ?></td>
                                            </tr>
                                            <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        for($page=1; $page <= $number_of_page; $page++){
                            echo '<a href = "transaction.php?page='. $page .'">' . $page .'</a>';
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
