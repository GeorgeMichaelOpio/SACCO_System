<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
if (isset($_POST['systemSettings'])) {
  //Error Handling and prevention of posting double entries
  $error = 0;
  if (isset($_POST['sys_name']) && !empty($_POST['sys_name'])) {
    $sys_name = mysqli_real_escape_string($mysqli, trim($_POST['sys_name']));
  } else {
    $error = 1;
    $err = "System Name Cannot Be Empty";
  }
  if (!$error) {
    $id = $_POST['id'];
    $sys_tagline = $_POST['sys_tagline'];
    $sys_logo = $_FILES['sys_logo']['name'];
    move_uploaded_file($_FILES["sys_logo"]["tmp_name"], "dist/img/" . $_FILES["sys_logo"]["name"]);

    $query = "UPDATE ib_systemsettings SET sys_name =?, sys_logo =?, sys_tagline=? WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssss',  $sys_name,  $sys_logo, $sys_tagline, $id);
    $stmt->execute();
    if ($stmt) {
      $success = "Settings Updated" && header("refresh:1; url=pages_system_settings.php");
    } else {
      //inject alert that profile update task failed
      $info = "Please Try Again Or Try Later";
    }
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

            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- Basic Layout -->
              <div class="row">
                <div class="col-xl">
                  <div class="card mb-6">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">System Settings</h5>
                    </div>
                    <div class="card-body">
                    <?php
                /* Persisit System Settings On Brand */
                $ret = "SELECT * FROM `ib_systemsettings` ";
                $stmt = $mysqli->prepare($ret);
                $stmt->execute(); //ok
                $res = $stmt->get_result();
                while ($sys = $res->fetch_object()) {
                ?>
                      <form>
                        <div class="form-floating form-floating-outline mb-6">
                          <input type="text" class="form-control" id="basic-default-fullname"  value="<?php echo $sys->sys_name; ?>" />
                          <label for="basic-default-fullname">Company Name</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-6">
                          <input type="text" class="form-control" id="basic-default-company" value="<?php echo $sys->sys_tagline; ?>" />
                          <label for="basic-default-company">Company Tagline</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-6">
                          <input type="file" class="form-control" id="basic-default-company" placeholder="" />
                          <label for="basic-default-company">System Logo</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                      </form>
                      <?php
                } ?>
                    </div>
                  </div>
                </div>
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

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
