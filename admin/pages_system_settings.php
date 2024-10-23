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

    <title>Admin | System Settings</title>

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
                      <h5 class="mb-0">Basic Layout</h5>
                      <small class="text-body float-end">Default label</small>
                    </div>
                    <div class="card-body">
                      <form>
                        <div class="form-floating form-floating-outline mb-6">
                          <input type="text" class="form-control" id="basic-default-fullname" placeholder="John Doe" />
                          <label for="basic-default-fullname">Full Name</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-6">
                          <input type="text" class="form-control" id="basic-default-company" placeholder="ACME Inc." />
                          <label for="basic-default-company">Company</label>
                        </div>
                        <div class="mb-6">
                          <div class="input-group input-group-merge">
                            <div class="form-floating form-floating-outline">
                              <input
                                type="text"
                                id="basic-default-email"
                                class="form-control"
                                placeholder="john.doe"
                                aria-label="john.doe"
                                aria-describedby="basic-default-email2" />
                              <label for="basic-default-email">Email</label>
                            </div>
                            <span class="input-group-text" id="basic-default-email2">@example.com</span>
                          </div>
                          <div class="form-text">You can use letters, numbers & periods</div>
                        </div>
                        <div class="form-floating form-floating-outline mb-6">
                          <input
                            type="text"
                            id="basic-default-phone"
                            class="form-control phone-mask"
                            placeholder="658 799 8941" />
                          <label for="basic-default-phone">Phone No</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-6">
                          <textarea
                            id="basic-default-message"
                            class="form-control"
                            placeholder="Hi, Do you have a moment to talk Joe?"
                            style="height: 60px"></textarea>
                          <label for="basic-default-message">Message</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- Merged -->
                <div class="col-xl">
                  <div class="card mb-6">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="mb-0">Basic with Icons</h5>
                      <small class="text-body float-end">Merged input group</small>
                    </div>
                    <div class="card-body">
                      <form>
                        <div class="input-group input-group-merge mb-6">
                          <span id="basic-icon-default-fullname2" class="input-group-text"
                            ><i class="ri-user-line ri-20px"></i
                          ></span>
                          <input
                            type="text"
                            class="form-control"
                            id="basic-icon-default-fullname"
                            placeholder="John Doe"
                            aria-label="John Doe"
                            aria-describedby="basic-icon-default-fullname2" />
                        </div>
                        <div class="input-group input-group-merge mb-6">
                          <span id="basic-icon-default-company2" class="input-group-text"
                            ><i class="ri-building-4-line ri-20px"></i
                          ></span>
                          <input
                            type="text"
                            id="basic-icon-default-company"
                            class="form-control"
                            placeholder="ACME Inc."
                            aria-label="ACME Inc."
                            aria-describedby="basic-icon-default-company2" />
                        </div>
                        <div class="mb-6">
                          <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="ri-mail-line ri-20px"></i></span>
                            <input
                              type="text"
                              id="basic-icon-default-email"
                              class="form-control"
                              placeholder="john.doe"
                              aria-label="john.doe"
                              aria-describedby="basic-icon-default-email2" />
                            <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>
                          </div>
                          <div class="form-text">You can use letters, numbers & periods</div>
                        </div>
                        <div class="input-group input-group-merge mb-6">
                          <span id="basic-icon-default-phone2" class="input-group-text"
                            ><i class="ri-phone-fill ri-20px"></i
                          ></span>
                          <input
                            type="text"
                            id="basic-icon-default-phone"
                            class="form-control phone-mask"
                            placeholder="658 799 8941"
                            aria-label="658 799 8941"
                            aria-describedby="basic-icon-default-phone2" />
                        </div>
                        <div class="input-group input-group-merge mb-6">
                          <span id="basic-icon-default-message2" class="input-group-text"
                            ><i class="ri-chat-4-line ri-20px"></i
                          ></span>
                          <textarea
                            id="basic-icon-default-message"
                            class="form-control"
                            placeholder="Hi, Do you have a moment to talk Joe?"
                            aria-label="Hi, Do you have a moment to talk Joe?"
                            aria-describedby="basic-icon-default-message2"
                            style="height: 60px"></textarea>
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
