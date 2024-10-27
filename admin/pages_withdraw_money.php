<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
//register new account

if (isset($_POST['withdrawal'])) {
    $tr_code = $_POST['tr_code'];
    $account_id = $_GET['account_id'];
    $acc_name = $_POST['acc_name'];
    $account_number = $_GET['account_number'];
    $acc_type = $_POST['acc_type'];
    //$acc_amount  = $_POST['acc_amount'];
    $tr_type  = $_POST['tr_type'];
    $tr_status = $_POST['tr_status'];
    $client_id  = $_GET['client_id'];
    $client_name  = $_POST['client_name'];
    $client_national_id  = $_POST['client_national_id'];
    $transaction_amt = $_POST['transaction_amt'];
    $client_phone = $_POST['client_phone'];
    //$acc_new_amt = $_POST['acc_new_amt'];
    //$notification_details = $_POST['notification_details'];
    $notification_details = "$client_name Has Withdrawn $ $transaction_amt From Bank Account $account_number";

    /*
    * The below code will handle the withdrwawal process that is first it 
      checks if the selected back account has the any amount and secondly the money withdrawed should 
      no be be greater than the existing amount.
    *   
    */

    $result = "SELECT SUM(transaction_amt) FROM  ib_transactions  WHERE account_id=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i', $account_id);
    $stmt->execute();
    $stmt->bind_result($amt);
    $stmt->fetch();
    $stmt->close();


    if ($transaction_amt > $amt) {
        $err = "You Do Not Have Sufficient Funds In Your Account.Your Existing Amount is $ $amt";
    } else {


        //Insert Captured information to a database table
        $query = "INSERT INTO ib_transactions (tr_code, account_id, acc_name, account_number, acc_type,  tr_type, tr_status, client_id, client_name, client_national_id, transaction_amt, client_phone) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $notification = "INSERT INTO  ib_notifications (notification_details) VALUES (?)";
        $stmt = $mysqli->prepare($query);
        $notification_stmt = $mysqli->prepare($notification);
        //bind paramaters
        $rc = $stmt->bind_param('ssssssssssss', $tr_code, $account_id, $acc_name, $account_number, $acc_type, $tr_type, $tr_status, $client_id, $client_name, $client_national_id, $transaction_amt, $client_phone);
        $rc = $notification_stmt->bind_param('s', $notification_details);
        $stmt->execute();
        $notification_stmt->execute();
        //declare a varible which will be passed to alert function
        if ($stmt && $notification_stmt) {
            $success = "Funds Withdrawled";
        } else {
            $err = "Please Try Again Or Try Later";
        }

        /*
    if(isset($_POST['deposit']))
    {
       $account_id = $_GET['account_id'];
       $acc_amount = $_POST['acc_amount'];
        
        //Insert Captured information to a database table
        $query="UPDATE  ib_bankaccounts SET acc_amount=? WHERE account_id=?";
        $stmt = $mysqli->prepare($query);
        //bind paramaters
        $rc=$stmt->bind_param('si', $acc_amount, $account_id);
        $stmt->execute();

        //declare a varible which will be passed to alert function
        if($stmt )
        {
            $success = "Money Deposited";
        }
        else
        {
            $err = "Please Try Again Or Try Later";
        }   
    }   
    */
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
                                            <h5 class="mb-0">Withdraw Money</h5>
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
                                                            <input type="text" readonly name="client_number" value="<?php echo $_transcode; ?>" class="form-control" id="Transaction_Code">
                                                            <label for="Transaction_Code">Transaction Code</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input type="text" name="transaction_amt" required class="form-control" id="TransactionAmount">
                                                            <label for="TransactionAmount">Amount Withdraw</label>
                                                        </div>
                                                    </div>
                                                    <div class=" col-md-4 form-group" style="display:none">
                                                        <label for="exampleInputPassword1">Transaction Type</label>
                                                        <input type="text" name="tr_type" value="Withdrawal" required class="form-control" id="exampleInputEmail1">
                                                    </div>
                                                    <div class=" col-md-4 form-group" style="display:none">
                                                        <label for="exampleInputPassword1">Transaction Status</label>
                                                        <input type="text" name="tr_status" value="Success " required class="form-control" id="exampleInputEmail1">
                                                    </div>

                                                </div>
                                                <div class="mt-6">
                                                    <button type="submit" name="withdraw" class="btn btn-primary me-3">Withdraw Funds</button>
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


        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->
        <script src="../assets/vendor/libs/jquery/jquery.js"></script>
        <script src="../assets/vendor/libs/popper/popper.js"></script>
        <script src="../assets/vendor/js/bootstrap.js"></script>
        <script src="../assets/vendor/libs/node-waves/node-waves.js"></script>
        <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="../assets/vendor/js/menu.js"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->

        <!-- Main JS -->
        <script src="../assets/js/main.js"></script>

        <!-- Page JS -->

        <!-- Place this tag before closing body tag for github widget button. -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>