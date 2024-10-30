<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

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

<?php include("components/head.php"); ?>

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

                <!-- Content Wrapper. Contains page content -->
                <?php
                // Get the account ID from the URL
                $account_id = $_GET['account_id'];

                // Get the total amount deposited
                $result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE account_id = ? AND tr_type = 'Deposit'";
                $stmt = $mysqli->prepare($result);
                $stmt->bind_param('i', $account_id);
                $stmt->execute();
                $stmt->bind_result($deposit);
                $stmt->fetch();
                $stmt->close();

                // Get total amount withdrawn
                $result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE account_id = ? AND tr_type = 'Withdrawal'";
                $stmt = $mysqli->prepare($result);
                $stmt->bind_param('i', $account_id);
                $stmt->execute();
                $stmt->bind_result($withdrawal);
                $stmt->fetch();
                $stmt->close();

                // Get total amount transferred
                $result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE account_id = ? AND tr_type = 'Transfer'";
                $stmt = $mysqli->prepare($result);
                $stmt->bind_param('i', $account_id);
                $stmt->execute();
                $stmt->bind_result($transfer);
                $stmt->fetch();
                $stmt->close();

                // Get account details
                $ret = "SELECT * FROM ib_bankaccounts WHERE account_id = ?";
                $stmt = $mysqli->prepare($ret);
                $stmt->bind_param('i', $account_id);
                $stmt->execute();
                $res = $stmt->get_result();
                $cnt = 1;

                while ($row = $res->fetch_object()) {
                    // Compute rate
                    $banking_rate = ($row->acc_rates) / 100;
                    // Compute Money out
                    $money_out = $withdrawal + $transfer;
                    // Compute the balance
                    $money_in = $deposit - $money_out;
                    // Get the rate
                    $rate_amt = $banking_rate * $money_in;
                    // Compute interest + balance
                    $totalMoney = $rate_amt + $money_in;

                    // Get approved loans
                    $loan_result = "SELECT SUM(ln_amount) FROM ib_loans WHERE account_id = ? AND ln_status = 'Approved'";
                    $loan_stmt = $mysqli->prepare($loan_result);
                    $loan_stmt->bind_param('i', $account_id);
                    $loan_stmt->execute();
                    $loan_stmt->bind_result($total_loans);
                    $loan_stmt->fetch();
                    $loan_stmt->close();

                    // Compute net total balance
                    $net_total_balance = $totalMoney - ($total_loans ? $total_loans : 0); // Adjust the total balance by deducting loans
                ?>
                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">

                            <div class="col-md-12">
                                <div class="card mb-6">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-12">
                                                <!-- Main content -->
                                                <div id="balanceSheet" class="invoice p-3 mb-3">
                                                    <!-- Title row -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h4>
                                                                <i class="fas fa-bank"></i> Cheapy Corporation Balance Enquiry
                                                                <small class="float-right">Date: <?php echo date('d/m/Y'); ?></small>
                                                            </h4>
                                                        </div>
                                                    </div>
                                                    <!-- Info row -->
                                                    <div class="row invoice-info">
                                                        <div class="col-sm-6 invoice-col">
                                                            Account Holder
                                                            <address>
                                                                <strong><?php echo $row->client_name; ?></strong><br>
                                                                <?php echo $row->client_number; ?><br>
                                                                <?php echo $row->client_email; ?><br>
                                                                Phone: <?php echo $row->client_phone; ?><br>
                                                                ID No: <?php echo $row->client_national_id; ?>
                                                            </address>
                                                        </div>
                                                        <div class="col-sm-6 invoice-col">
                                                            Account Details
                                                            <address>
                                                                <strong><?php echo $row->acc_name; ?></strong><br>
                                                                Acc No: <?php echo $row->account_number; ?><br>
                                                                Acc Type: <?php echo $row->acc_type; ?><br>
                                                                Acc Rates: <?php echo $row->acc_rates; ?> %
                                                            </address>
                                                        </div>
                                                    </div>

                                                    <!-- Table row -->
                                                    <div class="row">
                                                        <div class="col-12 table-responsive">
                                                            <table class="table table-hover table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Deposits</th>
                                                                        <th>Withdrawals</th>
                                                                        <th>Transfers</th>
                                                                        <th>Subtotal</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>$ <?php echo number_format($deposit, 2); ?></td>
                                                                        <td>$ <?php echo number_format($withdrawal, 2); ?></td>
                                                                        <td>$ <?php echo number_format($transfer, 2); ?></td>
                                                                        <td>$ <?php echo number_format($money_in, 2); ?></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <p class="lead"></p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="lead">Balance Checked On: <?php echo date('d-M-Y'); ?></p>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover">
                                                                    <tr>
                                                                        <th style="width:50%">Funds In:</th>
                                                                        <td>$ <?php echo number_format($deposit, 2); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Funds Out:</th>
                                                                        <td>$ <?php echo number_format($money_out, 2); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Sub Total:</th>
                                                                        <td>$ <?php echo number_format($money_in, 2); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Banking Interest:</th>
                                                                        <td>$ <?php echo number_format($rate_amt, 2); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Total Loans:</th>
                                                                        <td>$ <?php echo $total_loans ? number_format($total_loans, 2) : '0.00'; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Net Total Balance:</th>
                                                                        <td>$ <?php echo number_format($net_total_balance, 2); ?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row no-print">
                                                        <div class="col-12">
                                                            <button type="button" id="print" onclick="printContent('balanceSheet');" class="btn btn-primary float-right" style="margin-right: 5px;">
                                                                <i class="fas fa-print"></i> Print
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.invoice -->
                                            </div><!-- /.col -->
                                        </div><!-- /.row -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <!-- /.content-wrapper -->

                <!-- Control Sidebar -->
                <aside class="control-sidebar control-sidebar-dark">
                    <!-- Control sidebar content goes here -->
                </aside>
                <!-- /.control-sidebar -->
            </div>
            <!-- ./wrapper -->

            <!-- script -->
            <?php include 'components/script.php'; ?>

            <!-- page script -->
            <script>
                $(function() {
                    $("#example1").DataTable();
                    $('#example2').DataTable({
                        "paging": true,
                        "lengthChange": false,
                        "searching": false,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                    });
                });

                // Print function
                function printContent(divName) {
                    var printContents = document.getElementById(divName).innerHTML;
                    var originalContents = document.body.innerHTML;

                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                }
            </script>
</body>

</html>
