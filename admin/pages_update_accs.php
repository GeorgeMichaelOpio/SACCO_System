<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
$success = "";
$err = "";

if (isset($_POST['update_acc_type'])) {
    // Sanitize inputs
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $rate = htmlspecialchars($_POST['rate']);
    $code = htmlspecialchars($_GET['code']);

    // Update account type in the database
    $query = "UPDATE ib_acc_types SET name=?, description=?, rate=? WHERE code=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssss', $name, $description, $rate, $code);

    if ($stmt->execute()) {
        $success = "Cheapy Account Category Updated";
    } else {
        $err = "Update Failed. Please Try Again.";
    }
}

?>

<!doctype html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free" data-style="light">
<?php include 'components/head.php'; ?>
<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <?php include 'components/app_brand.php'; ?>
        <div class="menu-inner-shadow"></div>
        <?php include 'components/side_bar.php'; ?>
      </aside>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <?php include 'components/nav_bar.php'; ?>

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Display success or error messages -->
            <?php if ($success): ?>
              <div class="alert alert-success"><?php echo $success; ?></div>
            <?php elseif ($err): ?>
              <div class="alert alert-danger"><?php echo $err; ?></div>
            <?php endif; ?>

            <?php
            // Fetch account type data
            $code = $_GET['code'];
            $ret = "SELECT * FROM ib_acc_types WHERE code = ?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('s', $code);
            $stmt->execute();
            $res = $stmt->get_result();
            while ($row = $res->fetch_object()) {
            ?>

            <!-- Account Update Form -->
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
                      <div class="form-floating form-floating-outline mb-6">
                        <input type="text" class="form-control" readonly name="code" value="<?php echo $row->code; ?>" id="codeInput" />
                        <label for="codeInput">Account Category Code</label>
                      </div>
                      <div class="form-floating form-floating-outline mb-6">
                        <textarea id="descriptionInput" class="form-control" name="description" required style="height: 60px"><?php echo $row->description; ?></textarea>
                        <label for="descriptionInput">Account Category Description</label>
                      </div>
                      <button type="submit" name="update_acc_type" class="btn btn-primary">Update Account Type</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>

            <?php } ?>

          </div>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>

   <!-- script -->
   <?php include 'components/script.php'; ?>
   
</body>
</html>
