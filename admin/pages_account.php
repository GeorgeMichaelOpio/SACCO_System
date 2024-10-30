<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
$err = $success = "";

// Update account details
if (isset($_POST['update_account'])) {
  $name = htmlspecialchars($_POST['name']);
  $email = htmlspecialchars($_POST['email']);

  $query = "UPDATE ib_admin SET name=?, email=? WHERE admin_id=?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('ssi', $name, $email, $admin_id);

  if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
      $success = "Account Updated";
    } else {
      $err = "No changes made";
    }
  } else {
    $err = "An error occurred. Please try again.";
  }
  $stmt->close();
}

// Change password
if (isset($_POST['change_password'])) {
  $old_password = sha1(md5($_POST['old_password']));
  $new_password = sha1(md5($_POST['new_password']));
  $confirm_password = sha1(md5($_POST['confirm_password']));

  $query = "SELECT password FROM ib_admin WHERE admin_id=?";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param('i', $admin_id);
  $stmt->execute();
  $stmt->bind_result($current_password);
  $stmt->fetch();
  $stmt->close();

  if ($current_password !== $old_password) {
    $err = "Old password does not match.";
  } elseif ($new_password !== $confirm_password) {
    $err = "New password and confirmation do not match.";
  } else {
    $query = "UPDATE ib_admin SET password=? WHERE admin_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('si', $new_password, $admin_id);
    if ($stmt->execute()) {
      $success = "Password Updated Successfully";
    } else {
      $err = "Failed to update password. Try again later.";
    }
    $stmt->close();
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

          <?php if ($err): ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $err; ?>
            </div>
          <?php elseif ($success): ?>
            <div class="alert alert-success" role="alert">
              <?php echo $success; ?>
            </div>
          <?php endif; ?>

          <?php
          $ret = "SELECT * FROM ib_admin WHERE admin_id = ?";
          $stmt = $mysqli->prepare($ret);
          $stmt->bind_param('i', $admin_id);
          $stmt->execute();
          $res = $stmt->get_result();
          while ($row = $res->fetch_object()) {
            $profile_picture = $row->profile_pic
              ? "<img class='img-fluid' src='../assets/img/$row->profile_pic' alt='User profile picture'>"
              : "<img class='img-fluid' src='../assets/img/user_icon.png' alt='User profile picture'>";
          ?>

            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-6">
                    <!-- Account -->
                    <div class="card-body">
                      <div class="d-flex align-items-start align-items-sm-center gap-6">
                        <?php echo $profile_picture; ?>
                        <div class="button-wrapper">
                          <label for="upload" class="btn btn-sm btn-primary me-3 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="ri-upload-2-line d-block d-sm-none"></i>
                            <input
                              type="file"
                              id="upload"
                              class="account-file-input"
                              hidden
                              accept="image/png, image/jpeg" />
                          </label>
                          <button type="button" class="btn btn-sm btn-outline-danger account-image-reset mb-4">
                            <i class="ri-refresh-line d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                          </button>

                          <div>Allowed JPG, GIF or PNG. Max size of 800K</div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body pt-0">
                      <form method="POST">
                        <div class="row mt-1 g-5">
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <input
                                class="form-control"
                                type="text"
                                id="inputName"
                                name="name"
                                value="<?php echo $row->name; ?>"
                                autofocus />
                              <label for="inputName">Name</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <input
                                class="form-control"
                                type="text"
                                id="inputNumber"
                                name="number"
                                value="<?php echo $row->number; ?>"
                                autofocus readonly />
                              <label for="inputNumber">Number</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <input
                                class="form-control"
                                type="text"
                                id="inputEmail"
                                name="email"
                                value="<?php echo $row->email; ?>" />
                              <label for="inputEmail">E-mail</label>
                            </div>
                          </div>
                        </div>
                        <div class="mt-6">
                          <button name="update_account" type="submit" class="btn btn-primary me-3">Update Account</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
                  </div>

                </div>
              </div>
            </div>

            <!-- Change Password--->
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-6">
                    <div class="card-body">
                      <h5 class="card-header">Change Password</h5>
                      <div class="card-body pt-0">
                        <form method="POST">
                          <div class="row mt-1 g-5">
                            <div class="col-md-6">
                              <div class="form-floating form-floating-outline">
                                <input
                                  class="form-control"
                                  type="password" name="old_password" placeholder="Old Password"
                                  required
                                  autofocus />
                                <label for="inputPassword">Old Password</label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-floating form-floating-outline">
                                <input class="form-control"  type="password" name="new_password" placeholder="New Password" 
                                autofocus
                                required />
                                <label for="inputPassword">New Password</label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-floating form-floating-outline">
                                <input
                                  class="form-control"
                                  itype="password" name="confirm_password" placeholder="Confirm New Password" required
                                  autofocus/>
                                <label for="inputPassword">Confirm New Password</label>
                              </div>
                            </div>
                          </div>
                          <div class="mt-6">
                            <button name="change_password" type="submit" class="btn btn-primary me-3">Change Password</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
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