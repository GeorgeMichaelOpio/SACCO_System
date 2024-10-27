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
                /*  Im About to do something stupid buh lets do it
         *  get the sumof all deposits(Money In) then get the sum of all
         *  Transfers and Withdrawals (Money Out).
         * Then To Calculate Balance and rate,
         * Take the rate, compute it and then add with the money in account and 
         * Deduce the Money out
         *
         */

                //get the total amount deposited
                $account_id = $_GET['account_id'];
                $result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE  account_id = ? AND  tr_type = 'Deposit' ";
                $stmt = $mysqli->prepare($result);
                $stmt->bind_param('i', $account_id);
                $stmt->execute();
                $stmt->bind_result($deposit);
                $stmt->fetch();
                $stmt->close();

                //get total amount withdrawn
                $account_id = $_GET['account_id'];
                $result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE  account_id = ? AND  tr_type = 'Withdrawal' ";
                $stmt = $mysqli->prepare($result);
                $stmt->bind_param('i', $account_id);
                $stmt->execute();
                $stmt->bind_result($withdrawal);
                $stmt->fetch();
                $stmt->close();

                //get total amount transfered
                $account_id = $_GET['account_id'];
                $result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE  account_id = ? AND  tr_type = 'Transfer' ";
                $stmt = $mysqli->prepare($result);
                $stmt->bind_param('i', $account_id);
                $stmt->execute();
                $stmt->bind_result($Transfer);
                $stmt->fetch();
                $stmt->close();



                $account_id = $_GET['account_id'];
                $ret = "SELECT * FROM  ib_bankaccounts WHERE account_id =? ";
                $stmt = $mysqli->prepare($ret);
                $stmt->bind_param('i', $account_id);
                $stmt->execute(); //ok
                $res = $stmt->get_result();
                $cnt = 1;
                while ($row = $res->fetch_object()) {
                    //compute rate
                    $banking_rate = ($row->acc_rates) / 100;
                    //compute Money out
                    $money_out = $withdrawal + $Transfer;
                    //compute the balance
                    $money_in = $deposit - $money_out;
                    //get the rate
                    $rate_amt = $banking_rate * $money_in;
                    //compute the intrest + balance 
                    $totalMoney = $rate_amt + $money_in;

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
                                                    <!-- title row -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h4>
                                                                <i class="fas fa-bank"></i> iBanking Corporation Balance Enquiry
                                                                <small class="float-right">Date: <?php echo date('d/m/Y'); ?></small>
                                                            </h4>
                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- info row -->
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
                                                        <!-- /.col -->
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
                                                    <!-- /.row -->

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
                                                                        <td>$ <?php echo $deposit; ?></td>
                                                                        <td>$ <?php echo $withdrawal; ?></td>
                                                                        <td>$ <?php echo $Transfer; ?></td>
                                                                        <td>$ <?php echo $money_in; ?></td>
                                                                    </tr>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- /.row -->

                                                    <div class="row">
                                                        <!-- accepted payments column -->
                                                        <div class="col-6">
                                                            <p class="lead"></p>

                                                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">

                                                            </p>
                                                        </div>
                                                        <!-- /.col -->
                                                        <div class="col-6">
                                                            <p class="lead">Balance Checked On : <?php echo date('d-M-Y'); ?></p>

                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover">
                                                                    <tr>
                                                                        <th style="width:50%">Funds In:</th>
                                                                        <td>$ <?php echo $deposit; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Funds Out</th>
                                                                        <td>$ <?php echo $money_out; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Sub Total:</th>
                                                                        <td>$ <?php echo $money_in; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Banking Intrest:</th>
                                                                        <td>$ <?php echo $rate_amt; ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th>Total Balance:</th>
                                                                        <td>$ <?php echo $totalMoney; ?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- /.row -->

                                                    <!-- this row will not appear when printing -->
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

            <!-- DateTables -->
            <script src="../assets/datatables/jquery.dataTables.js"></script>
            <script src="../assets/datatables-bs4/js/dataTables.bootstrap4.js"></script>

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
            </script>
            <script>
                //print balance sheet
                function printContent(el) {
                    var restorepage = $('body').html();
                    var printcontent = $('#' + el).clone();
                    $('body').empty().html(printcontent);
                    window.print();
                    $('body').html(restorepage);
                }
            </script>
</body>

</html>