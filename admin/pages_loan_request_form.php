<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

// Register new loan
if (isset($_POST['apply_loan'])) {
    $ln_code = $_POST['ln_code'];
    $account_id = $_GET['account_id'];
    $acc_name = $_POST['acc_name'];
    $account_number = $_POST['account_number'];
    $acc_type = $_POST['acc_type'];
    $ln_amount = $_POST['ln_amount'];
    $interest_rate = $_POST['interest_rate'];
    $ln_period = $_POST['ln_period'];
    $ln_status = "Pending"; // Assuming loan status is "Pending" at creation
    $client_id = $_GET['client_id'];
    $client_name = $_POST['client_name'];
    $client_national_id = $_POST['client_national_id'];
    $client_phone = $_POST['client_phone'];

    // Notification
    $notification_details = "$client_name has applied for a loan of $ $ln_amount with Account Number $account_number";

    // Insert loan details into ib_loans table
    $query = "INSERT INTO ib_loans (ln_code, account_id, acc_name, account_number, acc_type, ln_amount, interest_rate, ln_status, client_id, client_name, client_national_id, client_phone, ln_period) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $notification = "INSERT INTO ib_notifications (notification_details) VALUES (?)";

    $stmt = $mysqli->prepare($query);
    $notification_stmt = $mysqli->prepare($notification);

    // Bind parameters
    $rc = $notification_stmt->bind_param('s', $notification_details);
    $rc = $stmt->bind_param('sssssssssssss', $ln_code, $account_id, $acc_name, $account_number, $acc_type, $ln_amount, $interest_rate, $ln_status, $client_id, $client_name, $client_national_id, $client_phone, $ln_period);
    $stmt->execute();
    $notification_stmt->execute();

    // Declare a variable to pass to alert function
    if ($stmt && $notification_stmt) {
        $success = "Loan Application Submitted";
    } else {
        $err = "Please Try Again Or Try Later";
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

                    <?php
                    $account_id = $_GET['account_id'];
                    $ret = "SELECT * FROM ib_bankaccounts WHERE account_id = ? ";
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
                                            <h5 class="mb-0">Loan Application</h5>
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
                                                            <label for="ClientPhoneNumber">Client Phone Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="acc_name" value="<?php echo $row->acc_name; ?>" required class="form-control" id="AccountName">
                                                            <label for="AccountName">Account Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="account_number" value="<?php echo $row->account_number; ?>" required class="form-control" id="AccountNumber">
                                                            <label for="AccountNumber">Account Number</label>
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
                                                            // PHP function to generate random loan code
                                                            $length = 20;
                                                            $_lncode = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);
                                                            ?>
                                                            <input type="text" readonly name="ln_code" value="<?php echo $_lncode; ?>" class="form-control" id="LoanCode">
                                                            <label for="LoanCode">Loan Code</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="ln_amount" required class="form-control" id="LoanAmount">
                                                            <label for="LoanAmount">Loan Amount</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="interest_rate" required class="form-control" id="InterestRate">
                                                            <label for="InterestRate">Interest Rate (%)</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="ln_period" required class="form-control" id="LoanPeriod">
                                                            <label for="LoanPeriod">Loan Period (Months)</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-6">
                                                    <button type="submit" name="apply_loan" class="btn btn-primary me-3">Apply for Loan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="content-backdrop fade"></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="layout-overlay layout-menu-toggle"></div>
        </div>

        <!-- script -->
        <?php include 'components/script.php'; ?>

</body>

</html>