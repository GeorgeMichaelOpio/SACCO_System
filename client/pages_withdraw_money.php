<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/phpmailer/src/Exception.php';
require '../assets/vendor/phpmailer/src/PHPMailer.php';
require '../assets/vendor/phpmailer/src/SMTP.php';

$client_id = $_SESSION['client_id'];

if (isset($_POST['withdrawal'])) {
    $tr_code = $_POST['tr_code'];
    $account_id = $_GET['account_id'];
    $acc_name = $_POST['acc_name'];
    $account_number = $_GET['account_number'];
    $acc_type = $_POST['acc_type'];
    $tr_type  = $_POST['tr_type'];
    $tr_status = $_POST['tr_status'];
    $client_id  = $_GET['client_id'];
    $client_name  = $_POST['client_name'];
    $client_national_id  = $_POST['client_national_id'];
    $transaction_amt = $_POST['transaction_amt'];
    $client_phone = $_POST['client_phone'];
    $notification_details = "$client_name Has Withdrawn $$transaction_amt From Bank Account $account_number";

    if (!is_numeric($transaction_amt) || $transaction_amt <= 0) {
        $err = "Invalid withdrawal amount.";
    } else {
        $stmt = $mysqli->prepare("SELECT SUM(transaction_amt) FROM ib_transactions WHERE account_id = ?");
        $stmt->bind_param('i', $account_id);
        $stmt->execute();
        $stmt->bind_result($amt);
        $stmt->fetch();
        $stmt->close();

        if ($transaction_amt > $amt) {
            $err = "You Do Not Have Sufficient Funds In Your Account. Your Existing Amount is $$amt";
        } else {
            $mysqli->begin_transaction();
            try {
                $query = "INSERT INTO ib_transactions (tr_code, account_id, acc_name, account_number, acc_type, tr_type, tr_status, client_id, client_name, client_national_id, transaction_amt, client_phone) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('ssssssssssss', $tr_code, $account_id, $acc_name, $account_number, $acc_type, $tr_type, $tr_status, $client_id, $client_name, $client_national_id, $transaction_amt, $client_phone);
                $stmt->execute();

                $notification_query = "INSERT INTO ib_notifications (notification_details) VALUES (?)";
                $notification_stmt = $mysqli->prepare($notification_query);
                $notification_stmt->bind_param('s', $notification_details);
                $notification_stmt->execute();

                $mysqli->commit();
                $success = "Funds Withdrawn Successfully";

                // Send Email Notification
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'georgemichaelopio@gmail.com';
                    $mail->Password = 'password';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('georgemichaelopio@gmail.com', 'Bank Notifications');
                    $mail->addAddress('0abc0xyz@proton.me', $client_name);

                    $mail->isHTML(true);
                    $mail->Subject = 'Withdrawal Notification';
                    $mail->Body = "Dear $client_name,<br><br>You have successfully withdrawn $$transaction_amt from your account (Account Number: $account_number).<br><br>Transaction Code: $tr_code<br><br>Thank you for banking with us.";

                    $mail->send();
                } catch (Exception $e) {
                    $err = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } catch (Exception $e) {
                $mysqli->rollback();
                $err = "Transaction failed: " . $e->getMessage();
            }
        }
    }
}
?>

<!doctype html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free" data-style="light">

<?php include 'components/head.php'; ?>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <?php include 'components/app_brand.php'; ?>
                <div class="menu-inner-shadow"></div>
                <?php include 'components/side_bar.php'; ?>
            </aside>
            <div class="layout-page">
                <?php include 'components/nav_bar.php'; ?>

                <div class="content-wrapper">

                    <?php if (isset($success)): ?>
                        <div class="alert alert-success mt-3"><?php echo $success; ?></div>
                    <?php elseif (isset($err)): ?>
                        <div class="alert alert-danger mt-3"><?php echo $err; ?></div>
                    <?php endif; ?>
                    <!-- Content -->

                    <?php
                    $account_id = $_GET['account_id'];
                    $ret = "SELECT * FROM ib_bankaccounts WHERE account_id = ?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $account_id);
                    $stmt->execute();
                    $res = $stmt->get_result();

                    while ($row = $res->fetch_object()) {
                    ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <div class="row">
                                <div class="col-xl">
                                    <div class="card mb-6">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Withdraw Money</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <form method="post" enctype="multipart/form-data" role="form">
                                                <div class="row mt-1 g-5">
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" readonly name="client_name" value="<?php echo htmlspecialchars($row->client_name); ?>" required class="form-control" id="client_name">
                                                            <label for="client_name">Client Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" readonly value="<?php echo htmlspecialchars($row->client_national_id); ?>" name="client_national_id" required class="form-control" id="ClientNationalId">
                                                            <label for="ClientNationalId">Client National ID No.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" readonly name="client_phone" value="<?php echo htmlspecialchars($row->client_phone); ?>" required class="form-control" id="ClientPhoneNumber">
                                                            <label for="clientPhoneNumber">Client Phone Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="acc_name" value="<?php echo htmlspecialchars($row->acc_name); ?>" required class="form-control" id="AccountName">
                                                            <label for="client_name">Account Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="account_number" value="<?php echo htmlspecialchars($row->account_number); ?>" required class="form-control" id="AccountNumber">
                                                            <label for="client_name">Account Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" readonly name="acc_type" value="<?php echo htmlspecialchars($row->acc_type); ?>" class="form-control" id="Acc_Type">
                                                            <label for="Acc_Type">Account Type | Category</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <?php
                                                            $length = 20;
                                                            $_transcode = substr(str_shuffle('0123456789QWERgfdsazxcvbnTYUIOqwertyuioplkjhmPASDFGHJKLMNBVCXZ'), 1, $length);
                                                            ?>
                                                            <input type="text" readonly name="tr_code" value="<?php echo $_transcode; ?>" class="form-control" id="Transaction_Code">
                                                            <label for="Transaction_Code">Transaction Code</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="transaction_amt" required class="form-control" id="TransactionAmount">
                                                            <label for="TransactionAmount">Amount Withdraw</label>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="tr_type" value="Withdrawal" required>
                                                    <input type="hidden" name="tr_status" value="Success" required>
                                                </div>
                                                <div class="mt-6">
                                                    <button type="submit" name="withdrawal" class="btn btn-primary me-3">Withdraw Funds</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    
       <!-- script -->
   <?php include 'components/script.php'; ?>>
</body>

</html>