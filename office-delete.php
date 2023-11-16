<?php

// Include your database configuration here if not already included
require("config/config.php");
require("config/db.php");

function deleteOfficeById($id, $conn)
{
    // Sanitize the input to prevent SQL injection
    $officeId = mysqli_real_escape_string($conn, $id);

    // Assuming your offices are stored in a table called 'office'
    $sql = "DELETE FROM recordsapp_db.office WHERE id = '$officeId'";

    if (mysqli_query($conn, $sql)) {
        // Deletion successful
        return true;
    } else {
        // If deletion fails, you might want to handle the error
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        return false;
    }
}


if (isset($_GET['id'])) {
    $officeId = $_GET['id'];

    if (deleteOfficeById($officeId, $conn)) {
        // Redirect back to the original page after successful deletion
        header("Location: office.php?msg=Record deleted.");
        exit();
    } else {
        // Handle the case where deletion fails, if necessary
        echo "Deletion failed.";
    }
}
?>
