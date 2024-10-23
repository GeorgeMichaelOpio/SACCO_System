<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];
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

          <?php
            $admin_id = $_SESSION['admin_id'];
            $ret = "SELECT * FROM  ib_admin  WHERE admin_id = ? ";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('i', $admin_id);
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
                      <form id="formAccountSettings" method="POST" onsubmit="return false">
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
                              <label for="firstName">Staff Name</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <input
                                class="form-control"
                                type="text"
                                id="email"
                                name="email"
                                value="<?php echo $row->email; ?>" />
                              <label for="email">Staff E-mail</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <input
                                type="text"
                                class="form-control"
                                id="organization"
                                name="organization" readonly
                                value="<?php echo $row->number; ?>" />
                              <label for="organization">Staff Number</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="input-group input-group-merge">
                              <div class="form-floating form-floating-outline">
                                <input
                                  type="text"
                                  id="phoneNumber"
                                  name="phoneNumber"
                                  class="form-control"
                                  placeholder="202 555 0111" />
                                <label for="phoneNumber">Phone Number</label>
                              </div>
                              <span class="input-group-text">US (+1)</span>
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
                                id="state"
                                name="state"
                                placeholder="California" />
                              <label for="state">State</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <input
                                type="text"
                                class="form-control"
                                id="zipCode"
                                name="zipCode"
                                placeholder="231465"
                                maxlength="6" />
                              <label for="zipCode">Zip Code</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <select id="country" class="select2 form-select">
                                <option value="">Select</option>
                                <option value="Australia">Australia</option>
                                <option value="Bangladesh">Bangladesh</option>
                                <option value="Belarus">Belarus</option>
                                <option value="Brazil">Brazil</option>
                                <option value="Canada">Canada</option>
                                <option value="China">China</option>
                                <option value="France">France</option>
                                <option value="Germany">Germany</option>
                                <option value="India">India</option>
                                <option value="Indonesia">Indonesia</option>
                                <option value="Israel">Israel</option>
                                <option value="Italy">Italy</option>
                                <option value="Japan">Japan</option>
                                <option value="Korea">Korea, Republic of</option>
                                <option value="Mexico">Mexico</option>
                                <option value="Philippines">Philippines</option>
                                <option value="Russia">Russian Federation</option>
                                <option value="South Africa">South Africa</option>
                                <option value="Thailand">Thailand</option>
                                <option value="Turkey">Turkey</option>
                                <option value="Ukraine">Ukraine</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="United States">United States</option>
                              </select>
                              <label for="country">Country</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <select id="language" class="select2 form-select">
                                <option value="">Select Language</option>
                                <option value="en">English</option>
                                <option value="fr">French</option>
                                <option value="de">German</option>
                                <option value="pt">Portuguese</option>
                              </select>
                              <label for="language">Language</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <select id="timeZones" class="select2 form-select">
                                <option value="">Select Timezone</option>
                                <option value="-12">(GMT-12:00) International Date Line West</option>
                                <option value="-11">(GMT-11:00) Midway Island, Samoa</option>
                                <option value="-10">(GMT-10:00) Hawaii</option>
                                <option value="-9">(GMT-09:00) Alaska</option>
                                <option value="-8">(GMT-08:00) Pacific Time (US & Canada)</option>
                                <option value="-8">(GMT-08:00) Tijuana, Baja California</option>
                                <option value="-7">(GMT-07:00) Arizona</option>
                                <option value="-7">(GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                <option value="-7">(GMT-07:00) Mountain Time (US & Canada)</option>
                                <option value="-6">(GMT-06:00) Central America</option>
                                <option value="-6">(GMT-06:00) Central Time (US & Canada)</option>
                                <option value="-6">(GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                <option value="-6">(GMT-06:00) Saskatchewan</option>
                                <option value="-5">(GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                <option value="-5">(GMT-05:00) Eastern Time (US & Canada)</option>
                                <option value="-5">(GMT-05:00) Indiana (East)</option>
                                <option value="-4">(GMT-04:00) Atlantic Time (Canada)</option>
                                <option value="-4">(GMT-04:00) Caracas, La Paz</option>
                              </select>
                              <label for="timeZones">Timezone</label>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                              <select id="currency" class="select2 form-select">
                                <option value="">Select Currency</option>
                                <option value="usd">USD</option>
                                <option value="euro">Euro</option>
                                <option value="pound">Pound</option>
                                <option value="bitcoin">Bitcoin</option>
                              </select>
                              <label for="currency">Currency</label>
                            </div>
                          </div>
                        </div>
                        <div class="mt-6">
                          <button type="submit" class="btn btn-primary me-3">Add Staff</button>
                        </div>
                      </form>
                    </div>
                    <!-- /Account -->
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
    <script src="../assets/js/pages-account-settings-account.js"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
