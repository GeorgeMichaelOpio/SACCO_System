<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];
//update logged in user account
if (isset($_POST['update_staff_account'])) {
  //Register  Staff
  $name = $_POST['name'];
  $staff_number = $_GET['staff_number'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  //$password = sha1(md5($_POST['password']));
  $sex  = $_POST['sex'];

  $profile_pic  = $_FILES["profile_pic"]["name"];
  move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "dist/img/" . $_FILES["profile_pic"]["name"]);

  //Insert Captured information to a database table
  $query = "UPDATE ib_staff SET name=?, phone=?, email=?, sex=?, profile_pic=? WHERE staff_number=?";
  $stmt = $mysqli->prepare($query);
  //bind paramaters
  $rc = $stmt->bind_param('ssssss', $name, $phone, $email, $sex, $profile_pic, $staff_number);
  $stmt->execute();

  //declare a varible which will be passed to alert function
  if ($stmt) {
    $success = "Staff Account Udated";
  } else {
    $err = "Please Try Again Or Try Later";
  }
}
//change password
if (isset($_POST['change_staff_password'])) {
  $password = sha1(md5($_POST['password']));
  $staff_number = $_GET['staff_number'];
  //insert unto certain table in database
  $query = "UPDATE ib_staff  SET password=? WHERE  staff_number=?";
  $stmt = $mysqli->prepare($query);
  //bind paramaters
  $rc = $stmt->bind_param('ss', $password, $staff_number);
  $stmt->execute();
  //declare a varible which will be passed to alert function
  if ($stmt) {
    $success = "Staff Password Updated";
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

          <?php
          $staff_number = $_GET['staff_number'];
          $ret = "SELECT * FROM  ib_staff  WHERE staff_number = ? ";
          $stmt = $mysqli->prepare($ret);
          $stmt->bind_param('s', $staff_number);
          $stmt->execute(); //ok
          $res = $stmt->get_result();
          while ($row = $res->fetch_object()) {
            //set automatically logged in user default image if they have not updated their pics
            if ($row->profile_pic == '') {
              $profile_picture = "

                        <img class='img-fluid'
                        src='../dist/img/user_icon.png'
                        alt='User profile picture'>

                        ";
            } else {
              $profile_picture = "

                        <img class=' img-fluid'
                        src='../dist/img/$row->profile_pic'
                        alt='User profile picture'>

                        ";
            }


          ?>

            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-md-12">
                  <div class="card mb-6">
                    <!-- Account -->
                    <div class="card-body">
                      <h3><?php echo $row->name; ?></h3>
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
                                id="inputPhone"
                                name="phone"
                                value="<?php echo $row->phone; ?>"
                                autofocus />
                              <label for="inputPhone">Contact</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <input
                                class="form-control"
                                type="text"
                                id="inputNumber"
                                name="number"
                                value="<?php echo $row->staff_number; ?>"
                                autofocus readonly />
                              <label for="inputNumber">Staff Number</label>
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
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <select class="form-control"
                                name="sex"
                                class="form-control"
                                id="inputSex">
                                <option>Male</option>
                                <option>Female</option>
                              </select>
                              <label for="inputName">Gender</label>
                            </div>
                          </div>
                        </div>
                        <div class="mt-6">
                          <button name="update_staff_account" type="submit" class="btn btn-primary me-3">Update Account</button>
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
                                  type="password"
                                  id="inputPassword"
                                  name="inputPassword"
                                  autofocus />
                                <label for="inputPassword">Old Password</label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-floating form-floating-outline">
                                <input class="form-control" type="password" name="inputPassword" id="lastName" />
                                <label for="inputPassword">New Password</label>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-floating form-floating-outline">
                                <input
                                  type="password"
                                  class="form-control"
                                  id="inputPassword"
                                  name="inputPassword" />
                                <label for="inputPassword">Confirm New Password</label>
                              </div>
                            </div>
                          </div>
                          <div class="mt-6">
                            <button type="submit" class="btn btn-primary me-3">Change Password</button>
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