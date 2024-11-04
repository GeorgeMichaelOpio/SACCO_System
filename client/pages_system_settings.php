<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();

$success = '';
$errors = []; // Changed to an array for multiple error messages

if (isset($_POST['systemSettings'])) {
    // Error Handling and prevention of posting double entries
    $error = false; // Changed to a boolean for clarity

    // Validate system name
    if (isset($_POST['sys_name']) && !empty($_POST['sys_name'])) {
        $sys_name = mysqli_real_escape_string($mysqli, trim($_POST['sys_name']));
    } else {
        $error = true;
        $errors[] = "System Name Cannot Be Empty"; // Collecting errors
    }

    // Validate system tagline
    if (isset($_POST['sys_tagline']) && !empty($_POST['sys_tagline'])) {
        $sys_tagline = mysqli_real_escape_string($mysqli, trim($_POST['sys_tagline']));
    } else {
        $error = true;
        $errors[] = "System Tagline Cannot Be Empty"; // Collecting errors
    }

    // Handle logo upload
    $sys_logo = $_FILES['sys_logo']['name'];
    if (empty($sys_logo)) {
        $error = true;
        $errors[] = "Logo cannot be empty"; // Collecting errors
    } else {
        $target_dir = "dist/img/";
        $target_file = $target_dir . basename($sys_logo);
        
        // Check if file upload is successful
        if (!move_uploaded_file($_FILES["sys_logo"]["tmp_name"], $target_file)) {
            $error = true;
            $errors[] = "File upload failed."; // Collecting errors
        }
    }

    // If no errors, proceed with the update
    if (!$error) {
        $id = $_POST['id'];
        $query = "UPDATE ib_systemsettings SET sys_name = ?, sys_logo = ?, sys_tagline = ? WHERE id = ?";
        $stmt = $mysqli->prepare($query);

        if ($stmt) {
            $rc = $stmt->bind_param('sssi', $sys_name, $sys_logo, $sys_tagline, $id);
            if ($stmt->execute()) {
                $success = "Settings Updated"; // Set success message
            } else {
                $errors[] = "Error updating settings: " . $stmt->error; // Collecting errors
            }
        } else {
            $errors[] = "Error preparing statement: " . $mysqli->error; // Collecting errors
        }
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
                    <!-- Display success or error messages -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo implode('<br>', $errors); ?>
                            </div>
                        <?php elseif ($success): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $success; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Content -->
                        <div class="row">
                            <div class="col-xl">
                                <div class="card mb-6">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">System Settings</h5>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        /* Persist System Settings On Brand */
                                        $ret = "SELECT * FROM `ib_systemsettings` ";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($sys = $res->fetch_object()) {
                                        ?>
                                            <form method="post" enctype="multipart/form-data" role="form">
                                                <input type="hidden" name="id" value="<?php echo $sys->id; ?>" />
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input type="text" class="form-control" id="Sys_Name" name="sys_name" required value="<?php echo htmlspecialchars($sys->sys_name); ?>" />
                                                    <label for="sys_name">Company Name</label>
                                                </div>
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input type="text" class="form-control" id="Sys_Tagline" name="sys_tagline" required value="<?php echo htmlspecialchars($sys->sys_tagline); ?>" />
                                                    <label for="sys_tagline">Company Tagline</label>
                                                </div>
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input type="file" name="sys_logo" class="form-control" />
                                                    <label for="Sys_Logo">System Logo</label>
                                                </div>
                                                <button type="submit" name="systemSettings" class="btn btn-primary">Send</button>
                                            </form>
                                        <?php
                                        } ?>
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
