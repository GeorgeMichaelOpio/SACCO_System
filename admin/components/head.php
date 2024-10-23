<?php
/* Persisit System Settings On Brand */
$ret = "SELECT * FROM `ib_systemsettings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) { 
?>

<head>
<meta charset="utf-8" />
<meta
  name="viewport"
  content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

<title><?php echo $sys->sys_name; ?> - <?php echo $sys->sys_tagline; ?></title>

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
<!-- Page -->
<link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />

<!-- Helpers -->
<script src="../assets/vendor/js/helpers.js"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="../assets/js/config.js"></script>

        <!--Inject SWAL-->
        <?php if (isset($success)) { ?>
            <!--This code for injecting success alert-->
            <script>
                setTimeout(function() {
                        swal("Success", "<?php echo $success; ?>", "success");
                    },
                    100);
            </script>

        <?php } ?>

        <?php if (isset($err)) { ?>
            <!--This code for injecting error alert-->
            <script>
                setTimeout(function() {
                        swal("Failed", "<?php echo $err; ?>", "error");
                    },
                    100);
            </script>

        <?php } ?>
        <?php if (isset($info)) { ?>
            <!--This code for injecting info alert-->
            <script>
                setTimeout(function() {
                        swal("Success", "<?php echo $info; ?>", "warning");
                    },
                    100);
            </script>

        <?php } ?>
        <?php if (isset($transaction_error)) { ?>
            <!--This code for injecting info alert-->
            <script>
                setTimeout(function() {
                        swal("Error", "<?php echo $transaction_error; ?>", "error");
                    },
                    100);
            </script>

        <?php } ?>
        <script>
            function getiBankAccs(val)

            {
                $.ajax({
                    //get account rates
                    type: "POST",
                    url: "pages_ajax.php",
                    data: 'iBankAccountType=' + val,
                    success: function(data) {
                        //alert(data);
                        $('#AccountRates').val(data);
                    }
                });

                $.ajax({
                    //get account transferable name
                    type: "POST",
                    url: "pages_ajax.php",
                    data: 'iBankAccNumber=' + val,
                    success: function(data) {
                        //alert(data);
                        $('#ReceivingAcc').val(data);
                    }
                });

                $.ajax({
                    //get account transferable holder | owner
                    type: "POST",
                    url: "pages_ajax.php",
                    data: 'iBankAccHolder=' + val,
                    success: function(data) {
                        //alert(data);
                        $('#AccountHolder').val(data);
                    }
                });
            }
        </script>
        
    </head>
<?php } ?>