<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
if (isset($_GET['deleteBankAccType'])) {
  $id = intval($_GET['deleteBankAccType']);
  $adn = "DELETE FROM  ib_acc_types  WHERE acctype_id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();

  if ($stmt) {
    $info = "Cheapy Account Type Removed";
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
            <!-- Hoverable Table rows -->
            <div class="card">
              <h5 class="card-header">Banking Account Types</h5>
              <div class="table-responsive">
                <table id="export" class="table table-hover table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Rate</th>
                      <th>Code</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">

                    <?php
                    //fetch all ib_acc_types
                    $ret = "SELECT * FROM  ib_acc_types ORDER BY RAND() ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute(); //ok
                    $res = $stmt->get_result();
                    $cnt = 1;
                    while ($row = $res->fetch_object()) {

                    ?>

                      <tr>
                        <td><?php echo $cnt; ?></td>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->rate; ?>%</td>
                        <td><?php echo $row->code; ?></td>
                        <td>
                          <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                              <i class="ri-more-2-line"></i>
                            </button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="pages_update_accs.php?code=<?php echo $row->code; ?>"><i class="ri-pencil-line me-1"></i> Edit</a>
                              <a class="dropdown-item" href="pages_manage_accs.php?deleteBankAccType=<?php echo $row->acctype_id; ?>"><i class="ri-delete-bin-6-line me-1"></i> Delete</a>
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
   
</body>

</html>