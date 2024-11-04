<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/phpmailer/src/Exception.php';
require '../assets/vendor/phpmailer/src/PHPMailer.php';
require '../assets/vendor/phpmailer/src/SMTP.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

if (isset($_POST['deposit'])) {
    $tr_code = $_POST['tr_code'];
    $account_id = $_GET['account_id'];
    $acc_name = $_POST['acc_name'];
    $account_number = $_GET['account_number'];
    $acc_type = $_POST['acc_type'];
    $tr_type  = $_POST['tr_type'];
    $tr_status = $_POST['tr_status'];
    $client_id  = $_GET['client_id'];
    $client_name  = $_POST['client_name'];
    $client_email  = $_POST['client_email'];
    $client_national_id  = $_POST['client_national_id'];
    $transaction_amt = $_POST['transaction_amt'];
    $client_phone = $_POST['client_phone'];

    // Notification
    $notification_details = "$client_name has deposited $$transaction_amt to bank account $account_number";

    // Insert transaction details into database
    $query = "INSERT INTO ib_transactions (tr_code, account_id, acc_name, account_number, acc_type, tr_type, tr_status, client_id, client_name, client_national_id, transaction_amt, client_phone) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    $notification = "INSERT INTO ib_notifications (notification_details) VALUES (?)";

    $stmt = $mysqli->prepare($query);
    $notification_stmt = $mysqli->prepare($notification);

    $rc = $notification_stmt->bind_param('s', $notification_details);
    $rc = $stmt->bind_param('ssssssssssss', $tr_code, $account_id, $acc_name, $account_number, $acc_type, $tr_type, $tr_status, $client_id, $client_name, $client_national_id, $transaction_amt, $client_phone);
    $stmt->execute();
    $notification_stmt->execute();

    // Send confirmation email
    if ($stmt && $notification_stmt) {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'georgemichaelopio@gmail.com'; // Gmail username
            $mail->Password = 'igrvwtdrzijdtfth'; // Gmail app-specific password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('georgemichaelopio@gmail.com', 'Bank Notifications');
            //$mail->addAddress('0abc0xyz@proton.me'); // Use client's email
            $mail->addAddress($client_email,$client_name); // Use client's email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Transaction Confirmation';
            $mail->Body = "
                <h3>Transaction Successful</h3>
                <p>Dear $client_name,</p>
                <p>Your deposit of $$transaction_amt to account number $account_number has been successfully processed.</p>
                <p>Transaction Code: $tr_code</p>
                <p>Thank you for banking with us!</p>
            ";

            $mail->send();
            $success = "Money Deposited and Email Sent";
        } catch (Exception $e) {
            $err = "Money Deposited but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        $err = "Please Try Again Or Try Later";
    }
}
?>


<!doctype html>

<html
    lang="en"
    class="light-style layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
    data-style="light">

<?php include 'components/head.php'; ?>

<body>
    <!-- Layout wrapper -->

    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

                <!-- App Brand -->
                <?php include 'components/app_brand.php'; ?>


                <div class="menu-inner-shadow"></div>

                <!-- SideBar -->
                <?php include 'components/side_bar.php'; ?>



            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">

                <!-- NavBar -->
                <?php include 'components/nav_bar.php'; ?>

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success mt-3"><?php echo $success; ?></div>
                    <?php elseif (isset($err)): ?>
                        <div class="alert alert-danger mt-3"><?php echo $err; ?></div>
                    <?php endif; ?>
                    <!-- Content -->

                    <?php
                    $account_id = $_GET['account_id'];
                    $ret = "SELECT * FROM  ib_bankaccounts WHERE account_id = ? ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $account_id);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    $cnt = 1;
                    while ($row = $res->fetch_object()) {

                    ?>

                        <div class="container-xxl flex-grow-1 container-p-y">
                            <!-- Basic Layout -->
                            <div class="row">
                                <div class="col-xl">
                                    <div class="card mb-6">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Deposit Money</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <form method="post" enctype="multipart/form-data" role="form">
                                                <div class="row mt-1 g-5">
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" readonly name="client_name" value="<?php echo $row->client_name; ?>" required class="form-control" id="client_name">
                                                            <label for="client_name">Client Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" readonly value="<?php echo $row->client_national_id; ?>" name="client_national_id" required class="form-control" id="ClientNationalId">
                                                            <label for="ClientNationalId">Client National ID No.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" readonly name="client_phone" value="<?php echo $row->client_phone; ?>" required class="form-control" id="ClientPhoneNumber">
                                                            <label for="clientPhoneNumber">Client Phone Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="acc_name" value="<?php echo $row->acc_name; ?>" required class="form-control" id="AccountName">
                                                            <label for="client_name">Account Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="account_number" value="<?php echo $row->account_number; ?>" required class="form-control" id="AccountNumber<">
                                                            <label for="client_name">Account Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" readonly name="acc_type" value="<?php echo $row->acc_type; ?>" class="form-control" id="Acc_Type">
                                                            <label for="Acc_Type">Account Type | Category</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <?php
                                                            //PHP function to generate random account number
                                                            $length = 20;
                                                            $_transcode =  substr(str_shuffle('0123456789QWERgfdsazxcvbnTYUIOqwertyuioplkjhmPASDFGHJKLMNBVCXZ'), 1, $length);
                                                            ?>
                                                            <input type="text" readonly name="tr_code" value="<?php echo $_transcode; ?>" class="form-control" id="Transaction_Code">
                                                            <label for="Transaction_Code">Transaction Code</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="transaction_amt" required class="form-control" id="TransactionAmount">
                                                            <label for="TransactionAmount">Amount Deposited</label>
                                                        </div>
                                                    </div>
                                                    <div class=" col-md-4 form-group" style="display:none">
                                                        <label for="exampleInputPassword1">Transaction Type</label>
                                                        <input type="text" name="tr_type" value="Deposit" required class="form-control" id="exampleInputEmail1">
                                                    </div>
                                                    <div class=" col-md-4 form-group" style="display:none">
                                                        <label for="exampleInputPassword1">Transaction Status</label>
                                                        <input type="text" name="tr_status" value="Success " required class="form-control" id="exampleInputEmail1">
                                                    </div>

                                                </div>
                                                <div class="mt-6">
                                                    <button type="submit" name="deposit" class="btn btn-primary me-3">Deposit Funds</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- / Content -->


                            <div class="content-backdrop fade"></div>
                        </div>
                    <?php } ?>
                    <!-- Content wrapper -->
                </div>
                <!-- / Layout page -->
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>
        <!-- / Layout wrapper -->

        <!-- script -->
        <?php include 'components/script.php'; ?>

</body>

</html>