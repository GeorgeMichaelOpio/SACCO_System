<?php
/* Persist System Settings On Brand */
$ret = "SELECT * FROM `ib_systemsettings`";
$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) { 
?>

<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<title><?php echo htmlspecialchars($sys->sys_name); ?> - <?php echo htmlspecialchars($sys->sys_tagline); ?></title>

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="../assets/svg/icon.svg" />

<!-- Fonts & Icons -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="../assets/vendor/fonts/remixicon/remixicon.css" />

<!-- Stylesheets -->
<link rel="stylesheet" href="../assets/libs/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="../assets/vendor/libs/node-waves/node-waves.css" />
<link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="../assets/css/demo.css" />
<link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
<link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />

<!-- Helpers -->
<script src="../assets/vendor/js/helpers.js"></script>
<script src="../assets/js/config.js"></script>

<!-- Alerts & Notifications -->
<?php if (isset($success) || isset($err) || isset($info) || isset($transaction_error)) { ?>
<script>
    function showAlert(type, message) {
        setTimeout(function() {
            swal(type === "success" ? "Success" : type === "error" ? "Failed" : "Warning", message, type);
        }, 100);
    }
    <?php if (isset($success)) { echo "showAlert('success', '" . addslashes($success) . "');"; } ?>
    <?php if (isset($err)) { echo "showAlert('error', '" . addslashes($err) . "');"; } ?>
    <?php if (isset($info)) { echo "showAlert('warning', '" . addslashes($info) . "');"; } ?>
    <?php if (isset($transaction_error)) { echo "showAlert('error', '" . addslashes($transaction_error) . "');"; } ?>
</script>
<?php } ?>

<script>
    function getiBankAccs(val) {
        $.ajax({
            type: "POST",
            url: "pages_ajax.php",
            data: { iBankAccountType: val, iBankAccNumber: val, iBankAccHolder: val },
            success: function(response) {
                const data = JSON.parse(response);
                $('#AccountRates').val(data.AccountRates);
                $('#ReceivingAcc').val(data.ReceivingAcc);
                $('#AccountHolder').val(data.AccountHolder);
            }
        });
    }
</script>

</head>
<?php } ?>
