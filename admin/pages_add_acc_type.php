<!doctype html>

<html
  lang="en"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Admin | Add Account</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="../assets/vendor/fonts/remixicon/remixicon.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>

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
                      <h5 class="mb-0">Create Account Categories</h5>
                    </div>
                    <div class="card-body">
                      <form>
                        <div class="form-floating form-floating-outline mb-6">
                          <input type="text" class="form-control" id="basic-default-fullname" placeholder="" />
                          <label for="basic-default-fullname">Account Category Name</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-6">
                          <input type="text" class="form-control" id="basic-default-company" placeholder="" />
                          <label for="basic-default-company">Account Category Rates % Per Year</label>
                        </div>
                        <?php
                          //PHP function to generate random passenger number
                          $length = 5;
                          $_Number =  substr(str_shuffle('0123456789QWERTYUIOPLKJHGFDSAZXCVBNM'), 1, $length);
                            ?>
                        <div class="form-floating form-floating-outline mb-6">
                          <input type="text" class="form-control" id="basic-default-company" value="ACC-CAT-<?php echo $_Number; ?>" placeholder="" />
                          <label for="basic-default-company">Account Category Code</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-6">
                          <textarea
                            id="basic-default-message"
                            class="form-control"
                            placeholder=""
                            style="height: 60px"></textarea>
                          <label for="basic-default-message">Account Category Decription</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
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
