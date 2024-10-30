<?php
session_start();
include('conf/config.php'); // get configuration file
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = sha1(md5($_POST['password'])); // double encrypt to increase security
    $stmt = $mysqli->prepare("SELECT email, password, admin_id FROM ib_admin WHERE email=? AND password=?"); // SQL to log in user
    $stmt->bind_param('ss', $email, $password); // bind fetched parameters
    $stmt->execute(); // execute bind
    $stmt->bind_result($email, $password, $admin_id); // bind result
    $rs = $stmt->fetch();
    $_SESSION['admin_id'] = $admin_id; // assign session to admin id

    if ($rs) { // if successful
        header("location:pages_dashboard.php");
    } else {
        $err = "Access Denied. Please Check Your Credentials";
    }
}

/* Persist System Settings On Brand */
$ret = "SELECT * FROM `ib_systemsettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); // ok
$res = $stmt->get_result();
while ($auth = $res->fetch_object()) {
?>

    <!doctype html>
    <html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free" data-style="light">
    <?php include("components/head.php"); ?>

    <body>
        <!-- Content -->
        <div class="position-relative">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner py-6 mx-4">
                    <!-- Login -->
                    <div class="card shadow-lg p-5" style="border-radius: 15px;">
                        <!-- Logo -->
                        <a href="../index.php">
                            <div class="app-brand justify-content-center mb-4 text-center">
                                <span class="app-brand-logo demo" style="width: 100px; height: 100px;">
                                    <span style="color: #9055fd; font-size: 50px;"> <!-- Adjust size as needed -->
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 88 88" style="background: transparent; width: 100%; height: 100%;">
                                            <g id="Hand_Growth" data-name="Hand Growth">
                                                <path d="M59.002,15a8,8,0,1,0-8,8A8.0092,8.0092,0,0,0,59.002,15Zm-9,5v-.1451a2.8484,2.8484,0,0,1-2-2.7094V17a1,1,0,0,1,2,0v.1455A.8556.8556,0,0,0,50.856,18h.2919a.854.854,0,0,0,.3814-1.6182l-1.95-.9746a2.8439,2.8439,0,0,1,.4224-5.2622V10a1,1,0,0,1,2,0v.145a2.8486,2.8486,0,0,1,2,2.71V13a1,1,0,1,1-2,0v-.1455A.8557.8557,0,0,0,51.1479,12H50.856a.8542.8542,0,0,0-.3819,1.6182l1.95.9746a2.8438,2.8438,0,0,1-.4223,5.2621V20a1,1,0,1,1-2,0Z" style="fill:#8c57ff" />
                                                <circle cx="9" cy="70" r="1" style="fill:#8c57ff" />
                                                <path d="M3,64V86a1.0029,1.0029,0,0,0,1,1H14V63H4A1.0029,1.0029,0,0,0,3,64Zm6,3a3,3,0,1,1-3,3A3.0088,3.0088,0,0,1,9,67Z" style="fill:#8c57ff" />
                                                <path d="M84.32,69.36a5.08,5.08,0,0,0-5.94-2.34l-15.5,4.82A7.5146,7.5146,0,0,1,55.5,78H37a1,1,0,0,1,0-2H55.5a5.5,5.5,0,0,0,0-11H37.47l-.67-.81a14.4356,14.4356,0,0,0-20.1-2.03l-.7.56V87H52.58a12.7593,12.7593,0,0,0,4.69-.88l24.46-9.47A5.0974,5.0974,0,0,0,84.32,69.36Z" style="fill:#8c57ff" />
                                                <path d="M31,40a41.718,41.718,0,0,0,6.69-.62c.82-.13,1.57-.24,2.26-.3-3-1.89-6-3.08-7.95-3.08a1,1,0,0,1,0-2h.003c5.2115.0023,17.9954,8.5357,17.9954,16,0,.0068.0038.0125.004.0193v1.0038A26.723,26.723,0,0,0,32.2,58.33a16.388,16.388,0,0,1,6.14,4.58l.07.09H55.5a7.5119,7.5119,0,0,1,7.46,6.72l11.89-3.69c-3.1126-8.601-12.1635-14.6363-22.848-14.9954V47c0-7.4641,12.7839-15.9975,17.9954-16H70a1,1,0,0,1,0,2c-1.95,0-4.95,1.19-7.95,3.08.69.06,1.44.17,2.26.3A41.718,41.718,0,0,0,71,37c7.11,0,11.75-13.11,11.95-13.67a1.0093,1.0093,0,0,0-.44-1.19.9936.9936,0,0,0-1.26.2c-.02.03-2.62,2.73-9.15,1.53C62.0171,22.01,57.7073,33.4761,57.1139,35.2a25.2444,25.2444,0,0,0-5.1119,5.7015V28.9493a14,14,0,1,0-2,0V43.9084A25.2365,25.2365,0,0,0,44.8861,38.2C44.2927,36.4761,39.9829,25.01,29.9,26.87c-6.53,1.2-9.13-1.5-9.15-1.53a.9936.9936,0,0,0-1.26-.2,1.0093,1.0093,0,0,0-.44,1.19C19.25,26.89,23.89,40,31,40ZM41.002,15a10,10,0,1,1,10,10A10.0114,10.0114,0,0,1,41.002,15Z" style="fill:#8c57ff" />
                                            </g>
                                        </svg>
                                    </span>
                                </span>
                                <span class="app-brand-text demo text-heading fw-semibold" style="font-size: 1.5rem;">Cheapy</span>
                            </div>
                            <!-- /Logo -->

                        </a>
                        <div class="text-center mb-4">
                            <h2 class="welcome-text">Welcome</h2>
                        </div>

                        <p class="text-center mb-5">Please sign in to your account and start the adventure</p>

                        <?php if (isset($err)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $err; ?>
                            </div>
                        <?php endif; ?>

                        <form id="formAuthentication" class="mb-5" method="post">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus required />
                                <label for="email">Email</label>
                            </div>
                            <div class="mb-4">
                                <div class="form-password-toggle">
                                    <div class="input-group input-group-merge">
                                        <div class="form-floating form-floating-outline">
                                            <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                                            <label for="password">Password</label>
                                        </div>
                                        <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line ri-20px"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check mb-0">
                                    <input class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                                </div>
                                <a href="auth-forgot-password-basic.html" class="float-end">
                                    <span>Forgot Password?</span>
                                </a>
                            </div>
                            <div class="mb-4">
                                <button class="btn btn-primary d-grid w-100" name="login" type="submit">Login</button>
                            </div>
                        </form>

                        <p class="text-center mb-5">
                            <span>New on our platform?</span>
                            <a href="auth-register-basic.html">
                                <span>Create an account</span>
                            </a>
                        </p>
                    </div>
                    <!-- /Login -->
                    <img src="../assets/img/tree-3.png" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block" />
                    <img src="../assets/img/auth-basic-mask-light.png" class="authentication-image d-none d-lg-block" height="172" alt="triangle-bg" data-app-light-img="illustrations/auth-basic-mask-light.png" data-app-dark-img="illustrations/auth-basic-mask-dark.png" />
                    <img src="../assets/img/tree.png" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block" />
                </div>
            </div>
        </div>
        <!-- / Content -->

        <!-- script -->
        <?php include 'components/script.php'; ?>

    </body>

    </html>
<?php
} ?>