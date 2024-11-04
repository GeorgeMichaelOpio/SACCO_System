<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];

// Register new account
if (isset($_POST['create_staff_account'])) {
  // Get input data
  $name = $_POST['name'];
  $national_id = $_POST['national_id'];
  $client_number = $_POST['client_number'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $password = sha1(md5($_POST['password']));
  $address  = $_POST['address'];

  // Handle profile picture upload
  $profile_pic = $_FILES["profile_pic"]["name"];
  $target_dir = "../assets/img/";
  $target_file = $target_dir . basename($profile_pic);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
  $uploadOk = 1;

  // Check file size (limit to 2MB)
  if ($_FILES["profile_pic"]["size"] > 2000000) {
    $err = "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Check file type
  if (!in_array($imageFileType, $allowed_types)) {
    $err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }

  // Check if everything is ok to upload
  if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
      // Insert captured information to a database table
      $query = "INSERT INTO ib_clients (name, national_id, client_number, phone, email, password, address, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $mysqli->prepare($query);

      // Bind parameters
      if ($stmt) {
        $rc = $stmt->bind_param('ssssssss', $name, $national_id, $client_number, $phone, $email, $password, $address, $profile_pic);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
          $success = "Client Account Created Successfully.";
        } else {
          $err = "Failed to create Client Account. Please try again.";
        }
        $stmt->close();
      } else {
        $err = "Database error: " . $mysqli->error;
      }
    } else {
      $err = "Sorry, there was an error uploading your file.";
    }
  }
}

?>

<!doctype html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free" data-style="light">

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

          <?php if (isset($success)): ?>
            <div class="alert alert-success mt-3"><?php echo $success; ?></div>
          <?php elseif (isset($err)): ?>
            <div class="alert alert-danger mt-3"><?php echo $err; ?></div>
          <?php endif; ?>

          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
              <div class="col-xl">
                <div class="card mb-6">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Client</h5>
                  </div>
                  <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" role="form">
                      <div class="row mt-1 g-5">
                        <div class="col-md-6">
                          <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="inputName" name="name" required autofocus />
                            <label for="inputName">Client Name</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="inputEmail" name="email" />
                            <label for="inputEmail">Client E-mail</label>
                          </div>
                        </div>
                        <?php
                        // PHP function to generate random client number
                        $length = 4;
                        $_Number = substr(str_shuffle('0123456789'), 1, $length);
                        ?>
                        <div class="col-md-6">
                          <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="inputStaffNumber" name="client_number" value="Cheapy-CLIENT-<?php echo $_Number; ?>" />
                            <label for="inputStaffNumber">Client Number</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" name="address" required />
                            <label for="address">Address</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="inputPhone" name="phone" required />
                            <label for="inputPhone">Client Phone Number</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating form-floating-outline">
                            <input class="form-control" type="text" id="national_id" name="national_id" required />
                            <label for="inputNationalID">National ID No.</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating form-floating-outline">
                            <input class="form-control" type="password" id="inputPassword" name="password" required />
                            <label for="inputPassword">Client Password</label>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-floating form-floating-outline">
                            <input class="form-control" type="file" id="InputProfilePic" name="profile_pic" required/>
                            <label for="InputProfilePic">Profile Picture</label>
                          </div>
                        </div>
                      </div>
                      <div class="mt-6">
                        <button type="submit" name="create_staff_account" class="btn btn-primary me-3">Add Client</button>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- /Account -->
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