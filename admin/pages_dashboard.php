<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

//clear notifications and alert user that they are cleared
if (isset($_GET['Clear_Notifications'])) {
  $id = intval($_GET['Clear_Notifications']);
  $adn = "DELETE FROM  ib_notifications  WHERE notification_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $info = "Notifications Cleared";
  } else {
    $err = "Try Again Later";
  }
}
/*
    get all dashboard analytics 
    and numeric values from distinct 
    tables
    */

//return total number of ibank clients
$result = "SELECT count(*) FROM ib_clients";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iBClients);
$stmt->fetch();
$stmt->close();

//return total number of iBank Staffs
$result = "SELECT count(*) FROM ib_staff";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iBStaffs);
$stmt->fetch();
$stmt->close();

//return total number of iBank Account Types
$result = "SELECT count(*) FROM ib_acc_types";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_AccsType);
$stmt->fetch();
$stmt->close();

//return total number of iBank Accounts
$result = "SELECT count(*) FROM ib_bankaccounts";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_Accs);
$stmt->fetch();
$stmt->close();

//return total number of iBank Deposits
$result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE  tr_type = 'Deposit' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_deposits);
$stmt->fetch();
$stmt->close();

//return total number of iBank Withdrawals
$result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE  tr_type = 'Withdrawal' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_withdrawal);
$stmt->fetch();
$stmt->close();



//return total number of iBank Transfers
$result = "SELECT SUM(transaction_amt) FROM ib_transactions WHERE  tr_type = 'Transfer' ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($iB_Transfers);
$stmt->fetch();
$stmt->close();

//return total number of  iBank initial cash->balances
$result = "SELECT SUM(transaction_amt) FROM ib_transactions ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($acc_amt);
$stmt->fetch();
$stmt->close();
//Get the remaining money in the accounts
$TotalBalInAccount = ($iB_deposits)  - (($iB_withdrawal) + ($iB_Transfers));


//ibank money in the wallet
$result = "SELECT SUM(transaction_amt) FROM ib_transactions ";
$stmt = $mysqli->prepare($result);
$stmt->execute();
$stmt->bind_result($new_amt);
$stmt->fetch();
$stmt->close();

// Fetch account types
$accTypesQuery = "SELECT acc_type, COUNT(*) AS count FROM ib_bankaccounts GROUP BY acc_type";
$accTypesStmt = $mysqli->prepare($accTypesQuery);
$accTypesStmt->execute();
$accTypesResult = $accTypesStmt->get_result();

$accountTypes = [];
$accountCounts = [];

while ($row = $accTypesResult->fetch_assoc()) {
  $accountTypes[] = $row['acc_type'];
  $accountCounts[] = $row['count'];
}

// Fetch transactions
$transactionsQuery = "SELECT tr_type, SUM(transaction_amt) AS total FROM ib_transactions GROUP BY tr_type";
$transactionsStmt = $mysqli->prepare($transactionsQuery);
$transactionsStmt->execute();
$transactionsResult = $transactionsStmt->get_result();

$transactionTypes = [];
$transactionTotals = [];

while ($row = $transactionsResult->fetch_assoc()) {
  $transactionTypes[] = $row['tr_type'];
  $transactionTotals[] = $row['total'];
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

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-6">

              <!-- Summary -->
              <div class="col-lg-12">
                <div class="card h-100">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0">Summary</h5>
                  </div>

                  <div class="card-body pt-lg-10">
                    <div class="row g-3">
                      <!----Clients-->
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="avatar">
                            <div class="avatar-initial bg-primary rounded shadow-xs">
                              <i class="ri-group-2-line ri-24px"></i>
                            </div>
                          </div>
                          <div class="ms-3">
                            <p class="mb-0">Clients</p>
                            <h5 class="mb-0"><?php echo $iBClients; ?></h5>
                          </div>
                        </div>
                      </div>
                      <!----Clients-->
                      <!----Staff-->
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="avatar">
                            <div class="avatar-initial bg-primary rounded shadow-xs">
                              <i class="ri-group-line ri-24px"></i>
                            </div>
                          </div>
                          <div class="ms-3">
                            <p class="mb-0">Staff</p>
                            <h5 class="mb-0"><?php echo $iBStaffs; ?></h5>
                          </div>
                        </div>
                      </div>
                      <!----Staff-->
                      <!----Account Types-->
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="avatar">
                            <div class="avatar-initial bg-primary rounded shadow-xs">
                              <i class="ri-macbook-line ri-24px"></i>
                            </div>
                          </div>
                          <div class="ms-3">
                            <p class="mb-0">Account Types</p>
                            <h5 class="mb-0"><?php echo $iB_AccsType; ?></h5>
                          </div>
                        </div>
                      </div>
                      <!----Account Types-->
                      <!----Accounts-->
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="avatar">
                            <div class="avatar-initial bg-primary rounded shadow-xs">
                              <i class="ri-account-pin-circle-line ri-24px"></i>
                            </div>
                          </div>
                          <div class="ms-3">
                            <p class="mb-0">Accounts</p>
                            <h5 class="mb-0"><?php echo $iB_Accs; ?></h5>
                          </div>
                        </div>
                      </div>
                      <!----Accounts-->
                      <!----./ iBank Deposits-->
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="avatar">
                            <div class="avatar-initial bg-success rounded shadow-xs">
                              <i class="ri-upload-line ri-24px"></i>
                            </div>
                          </div>
                          <div class="ms-3">
                            <p class="mb-0">Deposits</p>
                            <h5 class="mb-0">$ <?php echo $iB_deposits; ?></h5>
                          </div>
                        </div>
                      </div>
                      <!----./ iBank Deposits-->
                      <!-- Withdrawals-->
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="avatar">
                            <div class="avatar-initial bg-danger rounded shadow-xs">
                              <i class="ri-download-line ri-24px"></i>
                            </div>
                          </div>
                          <div class="ms-3">
                            <p class="mb-0">Withdrawals</p>
                            <h5 class="mb-0">$ <?php echo $iB_withdrawal; ?></h5>
                          </div>
                        </div>
                      </div>
                      <!-- Withdrawals-->
                      <!--Transfers-->
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="avatar">
                            <div class="avatar-initial bg-warning rounded shadow-xs">
                              <i class="ri-shuffle-line ri-24px"></i>
                            </div>
                          </div>
                          <div class="ms-3">
                            <p class="mb-0">Transfers</p>
                            <h5 class="mb-0">$ <?php echo $iB_Transfers; ?></h5>
                          </div>
                        </div>
                      </div>
                      <!--Transfers-->
                      <!--Balances-->
                      <div class="col-md-3 col-6">
                        <div class="d-flex align-items-center">
                          <div class="avatar">
                            <div class="avatar-initial bg-warning rounded shadow-xs">
                              <i class="ri-wallet-line ri-24px"></i>
                            </div>
                          </div>
                          <div class="ms-3">
                            <p class="mb-0">Wallet Balance</p>
                            <h5 class="mb-0">$ <?php echo $TotalBalInAccount;  ?></h5>
                          </div>
                        </div>
                      </div>
                      <!-- ./Balances-->
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Summary -->


              <!-- Account Types -->
              <div class="col-sm-6">
                <div class="card h-100">
                  <div class="card-header pb-0">
                    <h4 class="mb-0">Accounts Types</h4>
                  </div>
                  <div class="card-body">
                    <div id="accountTypesChart" class="mb-3"></div>
                  </div>
                </div>
              </div>
              <!--/ Account Types -->

              <!-- Transactions -->
              <div class="col-sm-6">
                <div class="card h-100">
                  <div class="card-header pb-0">
                    <h4 class="mb-0">Transactions</h4>
                  </div>
                  <div class="card-body">
                    <div id="transactionsChart" class="mb-3"></div>
                  </div>
                </div>
              </div>
              <!--/ Account Types -->


              <!-- Data Tables -->
              <div class="col-12">
                <div class="card overflow-hidden">
                  <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2">Latest Transactions</h5>
                      <div class="dropdown">
                        <button
                          class="btn text-muted p-0"
                          type="button"
                          id="transactionID"
                          data-bs-toggle="dropdown"
                          aria-haspopup="true"
                          aria-expanded="false">
                          <i class="ri-more-2-line ri-24px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                          <a class="dropdown-item" href="pages_transactions_engine.php">View All</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="table-responsive text-nowrap">
                    <table class="table table-hover table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Transaction Code</th>
                          <th>Account No.</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Acc. Owner</th>
                          <th>Timestamp</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        //Get latest transactions 
                        $ret = "SELECT * FROM `ib_transactions` ORDER BY `ib_transactions`.`created_at` DESC ";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->execute(); //ok
                        $res = $stmt->get_result();
                        $cnt = 1;
                        while ($row = $res->fetch_object()) {
                          /* Trim Transaction Timestamp to 
                            *  User Uderstandable Formart  DD-MM-YYYY :
                            */
                          $transTstamp = $row->created_at;
                          //Perfom some lil magic here
                          if ($row->tr_type == 'Deposit') {
                            $alertClass = "<span class='badge bg-label-success rounded-pill'>$row->tr_type</span>";
                          } elseif ($row->tr_type == 'Withdrawal') {
                            $alertClass = "<span class='badge bg-label-danger rounded-pill'>$row->tr_type</span>";
                          } else {
                            $alertClass = "<span class='badge bg-label-warning rounded-pill'>$row->tr_type</span>";
                          }
                        ?>
                          <tr class="border-transparent">
                            <td><?php echo $row->tr_code; ?></a></td>
                            <td><?php echo $row->account_number; ?></td>
                            <td><?php echo $alertClass; ?></td>
                            <td>$ <?php echo $row->transaction_amt; ?></td>
                            <td>
                              <div>
                                <h6 class="mb-0 text-truncate"><?php echo $row->client_name; ?></h6>
                              </div>
                            </td>
                            <td><?php echo date("d-M-Y h:m:s ", strtotime($transTstamp)); ?></td>
                          </tr>

                        <?php } ?>

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!--/ Data Tables -->
            </div>
          </div>
          <!-- / Content -->

          <div class="content-backdrop fade"></div>
        </div>
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
  <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

  <!-- Main JS -->
  <script src="../assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="../assets/js/dashboards-analytics.js"></script>

  <!-- Place this tag before closing body tag for github widget button. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <script>
    // Account Types Chart
    var accountTypes = <?php echo json_encode($accountTypes); ?>;
    var accountCounts = <?php echo json_encode($accountCounts); ?>;

    var options1 = {
      chart: {
        type: 'pie',
      },
      series: accountCounts,
      labels: accountTypes,
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 300
          },
          legend: {
            position: 'bottom'
          }
        }
      }]
    };

    var chart1 = new ApexCharts(document.querySelector("#accountTypesChart"), options1);
    chart1.render();

    // Transactions Chart
    var transactionTypes = <?php echo json_encode($transactionTypes); ?>;
    var transactionTotals = <?php echo json_encode($transactionTotals); ?>;

    var options2 = {
      chart: {
        type: 'bar',
      },
      series: [{
        name: 'Transaction Amount',
        data: transactionTotals
      }],
      xaxis: {
        categories: transactionTypes
      }
    };

    var chart2 = new ApexCharts(document.querySelector("#transactionsChart"), options2);
    chart2.render();
  </script>

</body>

</html>