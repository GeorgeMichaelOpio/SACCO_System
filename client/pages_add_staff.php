<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];
//register new account
if (isset($_POST['create_staff_account'])) {
  //Register  Staff
  $name = $_POST['name'];
  $staff_number = $_POST['staff_number'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $password = sha1(md5($_POST['password']));
  $sex  = $_POST['sex'];

  $profile_pic  = $_FILES["profile_pic"]["name"];
  move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "dist/img/" . $_FILES["profile_pic"]["name"]);

  //Insert Captured information to a database table
  $query = "INSERT INTO ib_staff (name, staff_number, phone, email, password, sex, profile_pic) VALUES (?,?,?,?,?,?,?)";
  $stmt = $mysqli->prepare($query);
  //bind paramaters
  $rc = $stmt->bind_param('sssssss', $name, $staff_number, $phone, $email, $password, $sex, $profile_pic);
  $stmt->execute();

  //declare a varible which will be passed to alert function
  if ($stmt) {
    $success = "Staff Account Created";
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
            <div class="row">
              <div class="col-md-12">
                <div class="card-body pt-0">
                  <h3 class="">Add Staff</h3>
                  <form method="POST" enctype="multipart/form-data" role="form">
                    <div class="row mt-1 g-5">
                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <input
                            class="form-control"
                            type="text"
                            id="inputName"
                            name="name"
                            autofocus required />
                          <label for="inputName">Staff Name</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <input
                            class="form-control"
                            type="text"
                            id="inputEmail"
                            name="email" />
                          <label for="inputEmail">Staff E-mail</label>
                        </div>
                      </div>
                      <?php
                      //PHP function to generate random passenger number
                      $length = 4;
                      $_staffNumber =  substr(str_shuffle('0123456789'), 1, $length);
                      ?>
                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <input
                            type="text" readonly
                            class="form-control"
                            id="inputStaffNumber"
                            name="staff_number" readonly
                            value="Cheapy-STAFF-<?php echo $_staffNumber; ?>" />
                          <label for="inputStaffNumber">Staff Number</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <select class="form-control" name="sex">
                            <option>Select Gender</option>
                            <option>Female</option>
                            <option>Male</option>
                          </select>
                          <label for="address">Sex</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <input
                            class="form-control"
                            type="text"
                            id="inputPhone"
                            name="phone" required />
                          <label for="inputPhone">Staff Phone Number</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <input
                            class="form-control"
                            type="password"
                            id="inputPassword"
                            name="password" require />
                          <label for="inputPassword">Staff Password</label>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-floating form-floating-outline">
                          <input
                            class="form-control"
                            type="file"
                            id="InputProfilePic"
                            name="profile_pic" />
                          <label for="InputProfilePic">Profile Picture</label>
                        </div>
                      </div>
                    </div>
                    <div class="mt-6">
                      <button type="submit" name="create_staff_account" class="btn btn-primary me-3">Add Staff</button>
                    </div>
                  </form>
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