<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];

$success = null; // Initialize the success message variable
$err = null; // Initialize the error message variable

if (isset($_POST['update_client_account'])) {
    // Get the client number from the URL
    $client_number = $_GET['client_number'];

    // Fetch existing client data
    $query = "SELECT * FROM ib_clients WHERE client_number = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $client_number);
    $stmt->execute();
    $res = $stmt->get_result();
    $existing_data = $res->fetch_object();

    // Get posted data
    $name = $_POST['name'];
    $national_id = $_POST['national_id'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address  = $_POST['address'];

    // Handle profile picture upload
    $profile_pic = $_FILES["profile_pic"]["name"];
    if ($profile_pic) {
        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], "dist/img/" . $profile_pic);
    } else {
        // Retain the existing profile picture if none is uploaded
        $profile_pic = $existing_data->profile_pic;
    }

    // Check for changes before updating
    if ($existing_data->name !== $name || 
        $existing_data->national_id !== $national_id || 
        $existing_data->phone !== $phone || 
        $existing_data->email !== $email || 
        $existing_data->address !== $address || 
        $existing_data->profile_pic !== $profile_pic) {

        // Insert captured information into the database table
        $query = "UPDATE ib_clients SET name=?, national_id=?, phone=?, email=?, address=?, profile_pic=? WHERE client_number = ?";
        $stmt = $mysqli->prepare($query);
        // Bind parameters
        $rc = $stmt->bind_param('sssssss', $name, $national_id, $phone, $email, $address, $profile_pic, $client_number);
        $stmt->execute();

        // Check if update was successful
        if ($stmt) {
            $success = "Client Account Updated";
        } else {
            $err = "Please Try Again Or Try Later";
        }
    } else {
        $err = "No changes were made to the account.";
    }
}

// Change password
if (isset($_POST['change_client_password'])) {
    $password = sha1(md5($_POST['password']));
    $client_number = $_GET['client_number'];
    // Insert into the database
    $query = "UPDATE ib_clients SET password=? WHERE client_number=?";
    $stmt = $mysqli->prepare($query);
    // Bind parameters
    $rc = $stmt->bind_param('ss', $password, $client_number);
    $stmt->execute();
    // Check if update was successful
    if ($stmt) {
        $success = "Client Password Updated";
    } else {
        $err = "Please Try Again Or Try Later";
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

                    <?php
                    $client_number = $_GET['client_number'];
                    $ret = "SELECT * FROM ib_clients WHERE client_number = ?";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->bind_param('s', $client_number);
                    $stmt->execute(); 
                    $res = $stmt->get_result();

                    if ($row = $res->fetch_object()) {
                        // Set profile picture based on whether it exists
                        if ($row->profile_pic == '') {
                            $profile_picture = "<img class='img-fluid' src='../assets/img/user_icon.png' alt='User profile picture'>";
                        } else {
                            $profile_picture = "<img class='img-fluid' src='../assets/img/$row->profile_pic' alt='User profile picture'>";
                        }
                    ?>

                        <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <!-- Success/Error Message -->
                            <?php if ($err): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $err; ?>
                                </div>
                            <?php elseif ($success): ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $success; ?>
                                </div>
                            <?php endif; ?>
                            
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
                                                        <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
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
                                            <form method="POST" enctype="multipart/form-data">
                                                <div class="row mt-1 g-5">
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input class="form-control" type="text" id="inputName" name="name" value="<?php echo $row->name; ?>" autofocus />
                                                            <label for="inputName">Client Name</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input class="form-control" type="text" id="inputPhone" name="phone" value="<?php echo $row->phone; ?>" autofocus />
                                                            <label for="inputPhone">Contact</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input class="form-control" type="text" id="inputNumber" name="number" value="<?php echo $row->client_number; ?>" autofocus readonly />
                                                            <label for="inputNumber">Client Number</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input class="form-control" type="text" id="inputEmail" name="email" value="<?php echo $row->email; ?>" />
                                                            <label for="inputEmail">E-mail</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input class="form-control" type="text" id="InputNational_id" name="national_id" value="<?php echo $row->national_id; ?>" />
                                                            <label for="InputNational_id">National ID NO</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline">
                                                            <input class="form-control" type="text" id="inputAddress" name="address" value="<?php echo $row->address; ?>" />
                                                            <label for="inputAddress">Address</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-6">
                                                    <button name="update_client_account" type="submit" class="btn btn-primary me-3">Update Account</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /Account -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password -->
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
                                                                <input type="password" id="inputNewPassword" class="form-control" name="password" placeholder="Password" required />
                                                                <label for="inputNewPassword">New Password</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-6">
                                                        <button name="change_client_password" type="submit" class="btn btn-primary me-3">Change Password</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        echo "<div class='alert alert-danger'>Client not found.</div>";
                    }
                    ?>
                </div>
                <!-- / Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>
    </div>
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
