<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
//roll back transaction
if (isset($_GET['RollBack_Transaction'])) {
  $id = intval($_GET['RollBack_Transaction']);
  $adn = "DELETE FROM  ib_transactions  WHERE tr_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $info = "iBanking Transaction Rolled Back";
  } else {
    $err = "Try Again Later";
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
                <!-- Data Tables -->
                <div class="col-12">
                  <div class="card overflow-hidden">
                  <div class="card-header">
                      <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Transaction History</h5>
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
                            <a class="dropdown-item" href="javascript:void(0);">View All</a>
                          </div>
                        </div>
                      </div>
                      <h7 class="card-title m-0 me-2">Select on any action options to manage Transactions</h5>
                    </div>
                  
                    <div class="table-responsive">
                      <table class="table table-sm">
                        <thead>
                          <tr>
                          <th>#</th>
                          <th>Transaction Code</th>
                          <th>Account No.</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Acc. Owner</th>
                          <th>Timestamp</th>
                          <th>Action</th>
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
                          <td><?php echo $cnt; ?></td>
                            <td><?php echo $row->tr_code; ?></a></td>
                            <td><?php echo $row->account_number; ?></td>
                            <td><?php echo $alertClass; ?></td>
                            <td>$ <?php echo $row->transaction_amt; ?></td>
                            <td><div>
                                  <h6 class="mb-0 text-truncate"><?php echo $row->client_name; ?></h6>
                            </div></td>
                            <td><?php echo date("d-M-Y h:m:s ", strtotime($transTstamp)); ?></td>
                            <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="ri-more-2-line"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="ri-pencil-line me-1"></i> Edit</a
                              >
                              <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="ri-delete-bin-6-line me-1"></i> Delete</a
                              >
                            </div>
                          </div>
                        </td>
                          </tr>

                          <?php $cnt = $cnt + 1; } ?>

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
  </body>
</html>
