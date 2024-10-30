<?php
ini_set('display_errors', 1);
include('conf/config.php');
include('conf/checklogin.php');

session_start();
include_once('conf/config.php');
include_once('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

$success = $err = ""; // Initialize success and error messages

if (isset($_POST['create_acc_type'])) {
  // Register account type
  $name = $_POST['name'];
  $description = $_POST['description'];
  $rate = $_POST['rate'];
  $code = $_POST['code'];

  // Insert Captured information into the database table
  $query = "INSERT INTO ib_acc_types (name, description, rate, code) VALUES (?, ?, ?, ?)";
  $stmt = $mysqli->prepare($query);

  if ($stmt) {
    // Bind parameters
    $stmt->bind_param('ssss', $name, $description, $rate, $code);
    $stmt->execute();

    // Check if insertion was successful
    if ($stmt->affected_rows > 0) {
      $success = "Account Category Created Successfully!";
    } else {
      $err = "Failed to create account category. Please try again.";
    }
    $stmt->close();
  } else {
    $err = "Database Error: Unable to prepare statement.";
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

        <!-- header -->
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


                    <!-- Display success or error messages -->
                    <?php if ($success): ?>
                      <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php elseif ($err): ?>
                      <div class="alert alert-danger"><?php echo $err; ?></div>
                    <?php endif; ?>

          <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Basic Layout -->
            <div class="row">
              <div class="col-xl">
                <div class="card mb-6">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Create Account Categories</h5>
                  </div>
                  <div class="card-body">
                  <form method="post">
                      <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="name" required id="Accountname" />
                        <label for="Accountname">Account Category Name</label>
                      </div>
                      <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" name="rate" required id="rateInput" />
                        <label for="rateInput">Account Category Rates % Per Year</label>
                      </div>
                      <?php
                      //PHP function to generate random passenger number
                      $length = 5;
                      $_Number =  substr(str_shuffle('0123456789QWERTYUIOPLKJHGFDSAZXCVBNM'), 1, $length);
                      ?>
                      <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" readonly name="code" id="codeInput" value="ACC-CAT-<?php echo $_Number; ?>" />
                        <label for="codeInput">Account Category Code</label>
                      </div>
                      <div class="form-floating form-floating-outline mb-6">
                        <textarea
                          id="descriptionInput"
                          class="form-control"
                          name="description" required
                          style="height: 60px"></textarea>
                        <label for="descriptionInput">Account Category Decription</label>
                      </div>
                      <button type="submit" name="create_acc_type" class="btn btn-primary">Add Account Type</button>
                    </form>
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


      <!-- script -->
      <?php include 'components/script.php'; ?>

</body>

</html>