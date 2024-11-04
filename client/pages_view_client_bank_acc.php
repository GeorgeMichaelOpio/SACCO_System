<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];

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

        <?php
        $client_id = $_SESSION['client_id'];
        $ret = "SELECT * FROM  ib_clients WHERE client_id =? ";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('i', $client_id);
        $stmt->execute(); //ok
        $res = $stmt->get_result();
        $cnt = 1;
        while ($row = $res->fetch_object()) {

        ?>

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Hoverable Table rows -->
            <div class="card">
              <h5 class="card-header"><?php echo $row->name; ?> Cheapy Accounts</h5>
              <h7 class="card-header">Select on any action options to manage enquiries</h7>
              <div class="table-responsive">
                <table id="export"  class="table table-hover table-bordered table-striped">
                  <thead>
                    <tr>
                    <th>#</th>
                                                <th>Name</th>
                                                <th>Account No.</th>
                                                <th>Rate</th>
                                                <th>Acc. Type</th>
                                                <th>Acc. Owner</th>
                                                <th>Date Opened</th>
                                                <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                  <?php
                                  //fetch all iB_Accs Which belongs to selected client
                                  $client_id = $_SESSION['client_id'];
                                  $ret = "SELECT * FROM  ib_bankaccounts WHERE client_id = ?";
                                  $stmt = $mysqli->prepare($ret);
                                  $stmt->bind_param('i', $client_id);
                                  $stmt->execute(); //ok
                                  $res = $stmt->get_result();
                                  $cnt = 1;
                                            while ($row = $res->fetch_object()) {
                                                //Trim Timestamp to DD-MM-YYYY : H-M-S
                                                $dateOpened = $row->created_at;

                                            ?>
                      <tr>
                      <td><?php echo $cnt; ?></td>
                                                    <td><?php echo $row->acc_name; ?></td>
                                                    <td><?php echo $row->account_number; ?></td>
                                                    <td><?php echo $row->acc_rates; ?>%</td>
                                                    <td><?php echo $row->acc_type; ?></td>
                                                    <td><?php echo $row->client_name; ?></td>
                                                    <td><?php echo date("d-M-Y", strtotime($dateOpened)); ?></td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="ri-more-2-line"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="pages_check_client_acc_balance.php?account_id=<?php echo $row->account_id; ?>&acccount_number=<?php echo $row->account_number; ?>"><i class="ri-pencil-line me-1"></i>Check Balance</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                    <?php $cnt = $cnt + 1;
                    } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <?php } ?>
            <!--/ Hoverable Table rows -->

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


   <!-- script -->
   <?php include 'components/script.php'; ?>

   <!-- page script -->
   <script>
    $('#export').DataTable({
      dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
      buttons: {
        buttons: [{
            extend: 'excel',
            className: 'btn'
          },
          {
            extend: 'print',
            className: 'btn'
          }
        ]
      },
      "oLanguage": {
        "oPaginate": {
          "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
          "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
        },
        "sInfo": "Showing page _PAGE_ of _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Search...",
        "sLengthMenu": "Results :  _MENU_",
      },
      "stripeClasses": [],
      "lengthMenu": [7, 10, 20, 50],
      "pageLength": 7
    });
  </script>
</body>

</html>