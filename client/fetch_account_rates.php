<?php
session_start();
include('conf/config.php');

if (isset($_GET['acc_type'])) {
    $acc_type = $_GET['acc_type'];

    // Fetch the account rate from the database based on the account type
    $query = "SELECT rate FROM ib_acc_types WHERE name = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $acc_type);
    $stmt->execute();
    $stmt->bind_result($rate);
    $stmt->fetch();
    echo $rate; // Return the rate
}
?>
