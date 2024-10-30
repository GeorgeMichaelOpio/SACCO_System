<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/phpmailer/src/Exception.php';
require '../assets/vendor/phpmailer/src/PHPMailer.php';
require '../assets/vendor/phpmailer/src/SMTP.php';

// Register new account
if (isset($_POST['deposit'])) {
    $tr_code = $_POST['tr_code'];
    $account_id = $_GET['account_id'];
    $acc_name = $_POST['acc_name'];
    $account_number = $_POST['account_number'];
    $acc_type = $_POST['acc_type'];
    $tr_type  = $_POST['tr_type'];
    $tr_status = $_POST['tr_status'];
    $client_id = $_POST['client_id'] ?? $_GET['client_id'];
    $client_name  = $_POST['client_name'];
    $client_email = $_POST['client_email']; // Add this field for email
    $client_national_id = $_POST['client_national_id'] ?? '';
    $transaction_amt = $_POST['transaction_amt'];
    $client_phone = $_POST['client_phone'];
    $receiving_acc_no = $_POST['receiving_acc_no'];
    $receiving_acc_name = $_POST['receiving_acc_name'];
    $receiving_client_name = $_POST['receiving_client_name'];
    $notification_details = "$client_name has transferred $$transaction_amt from account $account_number to account $receiving_acc_no";

    // Check account balance
    $result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE account_id=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i', $account_id);
    $stmt->execute();
    $stmt->bind_result($amt);
    $stmt->fetch();
    $stmt->close();

    if ($transaction_amt > $amt) {
        $_SESSION['err'] = "Insufficient funds. Current balance: $$amt";
    } else {
        // Insert transaction and notification
        $query = "INSERT INTO ib_transactions (tr_code, account_id, acc_name, account_number, acc_type, tr_type, tr_status, client_id, client_name, client_national_id, transaction_amt, client_phone, receiving_acc_no, receiving_acc_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $notification = "INSERT INTO ib_notifications (notification_details) VALUES (?)";

        $stmt = $mysqli->prepare($query);
        $notification_stmt = $mysqli->prepare($notification);
        $stmt->bind_param('ssssssssssssss', $tr_code, $account_id, $acc_name, $account_number, $acc_type, $tr_type, $tr_status, $client_id, $client_name, $client_national_id, $transaction_amt, $client_phone, $receiving_acc_no, $receiving_acc_name);
        $notification_stmt->bind_param('s', $notification_details);

        if ($stmt->execute() && $notification_stmt->execute()) {
            $_SESSION['success'] = "Money Transferred";

            // Send Email
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username = 'georgemichaelopio@gmail.com';
                $mail->Password = 'password';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // Recipient and sender
                $mail->setFrom('georgemichaelopio@gmail.com', 'Bank Notifications');
                    $mail->addAddress('0abc0xyz@proton.me', $client_name);

                // Email content
                $mail->isHTML(true);
                $mail->Subject = 'Successful Transaction Notification';
                $mail->Body    = "
                    <h3>Transaction Successful</h3>
                    <p>Dear $client_name,</p>
                    <p>Your transfer of $$transaction_amt from account $account_number to account $receiving_acc_no has been successfully completed.</p>
                    <p>Transaction Code: $tr_code</p>
                    <p>Thank you for using our service!</p>
                ";

                $mail->send();
            } catch (Exception $e) {
                $_SESSION['err'] = "Transaction successful, but email could not be sent. Error: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['err'] = "Please try again later";
        }
    }
    header("Location: " . $_SERVER['PHP_SELF'] . "?account_id=" . $account_id);
    exit;
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

                <?php
                    $account_id = $_GET['account_id'];
                    $ret = "SELECT * FROM  ib_bankaccounts WHERE account_id = ? ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $account_id);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    $cnt = 1;
                    while ($row = $res->fetch_object()) {
                        //Indicate Account Balance 
                        $result = "SELECT SUM(transaction_amt) FROM  ib_transactions  WHERE account_id=?";
                        $stmt = $mysqli->prepare($result);
                        $stmt->bind_param('i', $account_id);
                        $stmt->execute();
                        $stmt->bind_result($amt);
                        $stmt->fetch();
                        $stmt->close();

                    ?>

                <!-- Content wrapper -->
                <div class="content-wrapper">

                 <!-- Add Alert Messages Here -->
                 <?php if (isset($_SESSION['err'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['err']; unset($_SESSION['err']); ?>
                        </div>
                    <?php elseif (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <!-- Basic Layout -->
                            <div class="row">
                                <div class="col-xl">
                                    <div class="card mb-6">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Transfer</h5>
                                        </div>
                                        <div class="card-body pt-0">
                                            <form method="post" enctype="multipart/form-data" role="form">
                                            <input type="hidden" name="client_id" value="<?php echo $row->client_id; ?>"> <!-- Ensure this exists -->
                                            <input type="hidden" name="client_national_id" value="<?php echo $row->client_national_id; ?>"> <!-- Hidden field for client_national_id -->  
                                            <div class="row mt-1 g-5">
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" readonly name="client_name" value="<?php echo $row->client_name; ?>" required class="form-control" id="client_name">
                                                            <label for="client_name">Client Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" readonly value="<?php echo $row->client_national_id; ?>" name="client_nationalsss_id" required class="form-control" id="ClientNationalId">
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
                                                            <input type="text" readonly value="<?php echo $amt; ?>" required class="form-control" id="TransactionAmount">
                                                                <label for="TransactionAmount">Current Account Balance</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="transaction_amt" required class="form-control" id="TransactionAmount">
                                                            <label for="TransactionAmount">Amount Transfer</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <select name="receiving_acc_no" onChange="getiBankAccs(this.value);" required class="form-control">
                                                                <option>Select Receiving Account</option>
                                                                <?php
                                                                //fetch all iB_Accs
                                                                $ret = "SELECT * FROM  ib_bankaccounts ";
                                                                $stmt = $mysqli->prepare($ret);
                                                                $stmt->execute(); //ok
                                                                $res = $stmt->get_result();
                                                                $cnt = 1;
                                                                while ($row = $res->fetch_object()) {

                                                                ?>
                                                                    <option><?php echo $row->account_number; ?></option>

                                                                <?php } ?>

                                                            </select>
                                                            <label for="exampleInputPassword1">Receiving Account Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
    <div class="form-floating form-floating-outline">
        <input type="text" name="receiving_acc_name" id="Receiving_Acc_Name" required class="form-control">
        <label for="Receiving_Acc_Name">Receiving Account Name</label>
    </div>
</div>
<div class="col-md-6">
    <div class="form-floating form-floating-outline">
        <input type="text" name="receiving_client_name" id="Receiving_client_name" required class="form-control">
        <label for="Receiving_client_name">Receiving Account Holder</label>
    </div>
</div>


                                                    <div class=" col-md-4 form-group" style="display:none">
                                                        <label for="exampleInputPassword1">Transaction Type</label>
                                                        <input type="text" name="tr_type" value="Transfer" required class="form-control" id="exampleInputEmail1">
                                                    </div>
                                                    <div class=" col-md-4 form-group" style="display:none">
                                                        <label for="exampleInputPassword1">Transaction Status</label>
                                                        <input type="text" name="tr_status" value="Success " required class="form-control" id="exampleInputEmail1">
                                                    </div>

                                                </div>
                                                <div class="mt-6">
                                                    <button type="submit" name="deposit" class="btn btn-primary me-3">Transfer Funds</button>
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

        <script>
function getiBankAccs(accountNumber) {
    if (accountNumber) {
        fetch(`fetch_account_details.php?account_number=${accountNumber}`)
            .then(response => response.json())
            .then(data => {
                if (data.acc_name && data.client_name) {
                    document.getElementById('Receiving_Acc_Name').value = data.acc_name;
                    document.getElementById('Receiving_client_name').value = data.client_name;
                } else {
                    document.getElementById('Receiving_Acc_Name').value = '';
                    document.getElementById('Receiving_client_name').value = '';
                }
            })
            .catch(error => console.error('Error fetching account details:', error));
    } else {
        document.getElementById('Receiving_Acc_Name').value = '';
        document.getElementById('Receiving_client_name').value = '';
    }
}
</script>

</body>

</html>