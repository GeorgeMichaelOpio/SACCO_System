<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];

// Register new account
if (isset($_POST['update_account'])) {
    // Fetch current account details
    $account_id = $_GET['account_id'];
    $current_query = "SELECT * FROM ib_bankaccounts WHERE account_id = ?";
    $current_stmt = $mysqli->prepare($current_query);
    $current_stmt->bind_param('i', $account_id);
    $current_stmt->execute();
    $current_res = $current_stmt->get_result();
    $current_row = $current_res->fetch_object();

    // Client open account
    $acc_name = $_POST['acc_name'];
    $account_number = $_POST['account_number'];
    $acc_type = $_POST['acc_type'];
    $acc_rates = $_POST['acc_rates'];
    $client_national_id = $_POST['client_national_id'];
    $client_name = $_POST['client_name'];
    $client_phone = $_POST['client_phone'];
    $client_number = $_POST['client_number'];
    $client_email = $_POST['client_email'];
    $client_adr = $_POST['client_adr'];

    // Check if any values have changed
    if (
        $acc_name !== $current_row->acc_name ||
        $account_number !== $current_row->account_number ||
        $acc_type !== $current_row->acc_type ||
        $acc_rates !== $current_row->acc_rates ||
        $client_name !== $current_row->client_name ||
        $client_national_id !== $current_row->client_national_id ||
        $client_phone !== $current_row->client_phone ||
        $client_number !== $current_row->client_number ||
        $client_email !== $current_row->client_email ||
        $client_adr !== $current_row->client_adr
    ) {

        $query = "UPDATE ib_bankaccounts SET acc_name=?, account_number=?, acc_type=?, acc_rates=?, client_name=?, client_national_id=?, client_phone=?, client_number=?, client_email=?, client_adr=? WHERE account_id =?";
        $stmt = $mysqli->prepare($query);

        // Bind parameters
        $stmt->bind_param('ssssssssssi', $acc_name, $account_number, $acc_type, $acc_rates, $client_name, $client_national_id, $client_phone, $client_number, $client_email, $client_adr, $account_id);
        $stmt->execute();

        // Check for success or error
        if ($stmt) {
            $success = "Account Updated";
        } else {
            $err = "Please Try Again Or Try Later";
        }
    } else {
        // No changes detected
        $err = "No changes were made to the account.";
    }
}

?>

<!doctype html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free" data-style="light">

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
                    $ret = "SELECT * FROM ib_bankaccounts WHERE account_id = ? ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('i', $account_id);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($row = $res->fetch_object()) {
                    ?>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <!-- Basic Layout -->
                            <div class="row">
                                <div class="col-xl">
                                    <div class="card mb-6">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">Update <?php echo htmlspecialchars($row->client_name); ?> Banking Account</h5>
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
                                                            <input type="text" readonly name="client_number" value="<?php echo htmlspecialchars($row->client_number); ?>" class="form-control" id="ClientNumber">
                                                            <label for="clientNumber">Client Number</label>
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
                                                            <input type="text" readonly value="<?php echo htmlspecialchars($row->client_national_id); ?>" name="client_national_id" required class="form-control" id="ClientNationalId">
                                                            <label for="ClientNationalId">Client National ID No.</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="email" readonly name="client_email" value="<?php echo htmlspecialchars($row->client_email); ?>" required class="form-control" id="ClientEmail">
                                                            <label for="client_email">Client Email</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="client_adr" readonly value="<?php echo htmlspecialchars($row->client_adr); ?>" required class="form-control" id="ClientAddress">
                                                            <label for="client_adr">Client Address</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="acc_name" value="<?php echo htmlspecialchars($row->acc_name); ?>" required class="form-control" id="AccountName">
                                                            <label for="AccountName">Account Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="account_number" value="<?php echo htmlspecialchars($row->account_number); ?>" required class="form-control" id="AccountNumber">
                                                            <label for="AccountNumber">Account Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <select class="form-control" id="acc_type" onChange="updateAccountRate();" name="acc_type">
                                                                <?php
                                                                // Fetch all ib_acc_types
                                                                $ret = "SELECT * FROM ib_acc_types ORDER BY RAND()";
                                                                $stmt = $mysqli->prepare($ret);
                                                                $stmt->execute();
                                                                $res = $stmt->get_result();

                                                                while ($rowType = $res->fetch_object()) {
                                                                    $selected = ($row->acc_type === $rowType->name) ? 'selected' : '';
                                                                ?>
                                                                    <option value="<?php echo htmlspecialchars($rowType->name); ?>" data-rate="<?php echo htmlspecialchars($rowType->rate); ?>" <?php echo $selected; ?>>
                                                                        <?php echo htmlspecialchars($rowType->name); ?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                            <label for="acc_type">Account Type</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="acc_rates" readonly required class="form-control" id="AccountRates" value="<?php echo htmlspecialchars($row->acc_rates); ?>">
                                                            <label for="AccountRates">Account Type Rates (%)</label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="mt-6">
                                                    <button name="update_account" type="submit" class="btn btn-primary me-3">Update Bank Account</button>
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
            function updateAccountRate() {
                // Get the selected account type
                const accountTypeSelect = document.getElementById('acc_type');
                const selectedOption = accountTypeSelect.options[accountTypeSelect.selectedIndex];

                // Get the rate from the selected option
                const rate = selectedOption.getAttribute('data-rate');

                // Update the account rates input field
                document.getElementById('AccountRates').value = rate;
            }
        </script>

</body>

</html>