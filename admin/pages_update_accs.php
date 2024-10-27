<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
if (isset($_POST['update_acc_type'])) {
  //Register  account type
  $name = $_POST['name'];
  $description = $_POST['description'];
  $rate = $_POST['rate'];
  $code = $_GET['code'];


  //Insert Captured information to a database table
  $query = "UPDATE  ib_acc_types SET name=?, description=?, rate=? WHERE code=? ";
  $stmt = $mysqli->prepare($query);
  //bind paramaters
  $rc = $stmt->bind_param('ssss', $name, $description, $rate, $code);
  $stmt->execute();

  //declare a varible which will be passed to alert function
  if ($stmt) {
    $success = "iBank Account Category Updated";
  } else {
    $err = "Please Try Again Or Try Later";
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
          //fetch a ib_acc_types
          $code = $_GET['code'];
          $ret = "SELECT * FROM  ib_acc_types WHERE code = ? ";
          $stmt = $mysqli->prepare($ret);
          $stmt->bind_param('s', $code);
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
                      <h5 class="mb-0">Update <?php echo $row->name; ?></h5>
                    </div>
                    <div class="card-body">
                      <form method="post" enctype="multipart/form-data" role="form">
                        <div class="form-floating form-floating-outline mb-6">
                          <input type="text" class="form-control" name="name" value="<?php echo $row->name; ?>" required id="Accountname" />
                          <label for="Accountname">Account Category Name</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-6">
                          <input type="text" class="form-control" name="rate" value="<?php echo $row->rate; ?>" required id="rateInput" />
                          <label for="rateInput">Account Category Rates % Per Year</label>
                        </div>
                        <?php
                        //PHP function to generate random passenger number
                        $length = 5;
                        $_Number =  substr(str_shuffle('0123456789QWERTYUIOPLKJHGFDSAZXCVBNM'), 1, $length);
                        ?>
                        <div class="form-floating form-floating-outline mb-6">
                          <input type="text" class="form-control" readonly name="code" value="<?php echo $row->code; ?>" id="codeInput" />
                          <label for="codeInput">Account Category Code</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-6">
                          <textarea
                            id="descriptionInput"
                            class="form-control"
                            pname="description" required
                            style="height: 60px"><?php echo $row->description; ?></textarea>
                          <label for="descriptionInput">Account Category Decription</label>
                        </div>
                        <button type="submit" name="update_acc_type" class="btn btn-primary">Update Account Type</button>
                      </form>
                    </div>
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