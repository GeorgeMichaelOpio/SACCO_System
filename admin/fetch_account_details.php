<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('conf/config.php');

if (isset($_GET['account_number'])) {
    $account_number = $_GET['account_number'];

    // Prepare the SQL statement
    $query = "SELECT acc_name, client_name FROM ib_bankaccounts WHERE account_number = ?";
    $stmt = $mysqli->prepare($query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($mysqli->error));
    }

    $stmt->bind_param('s', $account_number);
    $stmt->execute();
    $stmt->bind_result($acc_name, $client_name);
    $stmt->fetch();

    // Check if we got results
    if ($acc_name && $client_name) {
        echo json_encode(['acc_name' => $acc_name, 'client_name' => $client_name]);
    } else {
        echo json_encode(['acc_name' => '', 'client_name' => '']);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'No account number provided']);
}
?>
