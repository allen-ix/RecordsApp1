<?php

// Include your database configuration here if not already included
require("config/config.php");
require("config/db.php");

function deleteTransactionById($id, $conn)
{
    // Sanitize the input to prevent SQL injection
    $transactionId = mysqli_real_escape_string($conn, $id);

    // Assuming your transactions are stored in a table called 'transaction'
    $sql = "DELETE FROM recordsapp_db.transaction WHERE id = '$transactionId'";

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
    $transactionId = $_GET['id'];

    if (deleteTransactionById($transactionId, $conn)) {
        // Redirect back to the original page after successful deletion
        header("Location: transaction.php?msg=Record deleted.");
        exit();
    } else {
        // Handle the case where deletion fails, if necessary
        echo "Deletion failed.";
    }
}
?>
