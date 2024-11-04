<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)" aria-label="Toggle menu">
      <i class="ri-menu-fill ri-24px"></i>
    </a>
  </div>

  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
    <ul class="navbar-nav flex-row align-items-center ms-auto">
      <?php
         $client_id = $_SESSION['client_id'];
         $ret = "SELECT * FROM  ib_clients  WHERE client_id = ? ";
         $stmt = $mysqli->prepare($ret);
         $stmt->bind_param('i', $client_id);
         $stmt->execute(); //ok
         $res = $stmt->get_result();

        while ($row = $res->fetch_object()) {
          // Set default profile picture if user hasn't uploaded one
          $profile_picture = $row->profile_pic ? "../assets/img/" . htmlspecialchars($row->profile_pic) : "../dist/img/user_icon.png";
      ?>

      <!-- User -->
      <li class="nav-item dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
          <div class="avatar avatar-online">
            <img src="<?= $profile_picture; ?>" alt="User profile picture" class="w-px-40 h-auto rounded-circle img-fluid">
          </div>
        </a>
        
        <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
          <li>
            <a class="dropdown-item" href="#">
              <div class="d-flex align-items-center">
                <div class="flex-shrink-0 me-2">
                  <div class="avatar avatar-online">
                    <img src="<?= $profile_picture; ?>" alt="User profile picture" class="w-px-40 h-auto rounded-circle img-fluid">
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-0 small"><?= htmlspecialchars($row->name); ?></h6>
                  <small class="text-muted">Admin</small>
                </div>
              </div>
            </a>
          </li>
          
          <li><div class="dropdown-divider"></div></li>

          <li>
            <a class="dropdown-item" href="pages_account.php">
              <i class="ri-user-3-line ri-22px me-2"></i>
              <span class="align-middle">My Profile</span>
            </a>
          </li>
          
          <li>
            <a class="dropdown-item" href="pages_system_settings.php">
              <i class="ri-settings-4-line ri-22px me-2"></i>
              <span class="align-middle">Settings</span>
            </a>
          </li>

          <li><div class="dropdown-divider"></div></li>

          <li>
            <div class="d-grid px-4 pt-2 pb-1">
              <a class="btn btn-danger d-flex align-items-center" href="pages_logout.php">
                <small class="align-middle">Logout</small>
                <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
              </a>
            </div>
          </li>
        </ul>
      </li>
      <!-- /User -->
      <?php } ?>
    </ul>
  </div>
</nav>
<!-- /Navbar -->
