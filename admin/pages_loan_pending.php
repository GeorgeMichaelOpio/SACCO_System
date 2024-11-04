<?php
session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$admin_id = $_SESSION['admin_id'];

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../assets/vendor/phpmailer/src/Exception.php';
require '../assets/vendor/phpmailer/src/PHPMailer.php';
require '../assets/vendor/phpmailer/src/SMTP.php';

// Function to send email
function sendEmail($email, $name, $loan_code, $status) {
    $mail = new PHPMailer(true);
    try {
       // Server settings
       $mail->isSMTP();
       $mail->Host = 'smtp.gmail.com';
       $mail->SMTPAuth = true;
       $mail->Username = 'georgemichaelopio@gmail.com'; // Gmail username
       $mail->Password = 'igrvwtdrzijdtfth'; // Gmail app-specific password
       $mail->SMTPSecure = 'ssl';
       $mail->Port = 465;

        $mail->setFrom('no-reply@example.com', 'Loan Management');
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "Loan Application Update";
        $mail->Body = "Dear $name,<br>Your loan with code <strong>$loan_code</strong> has been <strong>$status</strong>.<br>Thank you.";

        $mail->send();
        return "Email sent successfully to $email.";
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Approve Loan
if (isset($_GET['approve_loan'])) {
    $loan_id = intval($_GET['approve_loan']);
    $query = "UPDATE ib_loans SET ln_status = 'Approved' WHERE ln_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $loan_id);
    $stmt->execute();
    if ($stmt) {
        $success = "Loan Approved Successfully";
        
        // Fetch client details
        $stmt = $mysqli->prepare("SELECT client_email, client_name, ln_code FROM ib_loans WHERE ln_id = ?");
        $stmt->bind_param('i', $loan_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $loan = $res->fetch_object();

        // Send email
        $emailResult = sendEmail($loan->client_email, $loan->client_name, $loan->ln_code, 'approved');
        $success .= " " . $emailResult;
    } else {
        $err = "Please Try Again Later";
    }
    $stmt->close();
}

// Reject Loan
if (isset($_GET['reject_loan'])) {
    $loan_id = intval($_GET['reject_loan']);
    $query = "UPDATE ib_loans SET ln_status = 'Rejected' WHERE ln_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $loan_id);
    $stmt->execute();
    if ($stmt) {
        $success = "Loan Rejected Successfully";
        
        // Fetch client details
        $stmt = $mysqli->prepare("SELECT client_email, client_name, ln_code FROM ib_loans WHERE ln_id = ?");
        $stmt->bind_param('i', $loan_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $loan = $res->fetch_object();

        // Send email
        $emailResult = sendEmail($loan->client_email, $loan->client_name, $loan->ln_code, 'rejected');
        $success .= " " . $emailResult;
    } else {
        $err = "Please Try Again Later";
    }
    $stmt->close();
}

?>

<!doctype html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free" data-style="light">

<?php include("components/head.php"); ?>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <?php include 'components/app_brand.php'; ?>
        <div class="menu-inner-shadow"></div>
        <?php include 'components/side_bar.php'; ?>
      </aside>

      <div class="layout-page">
        <?php include 'components/nav_bar.php'; ?>

        <div class="content-wrapper">

          <?php if (isset($success)): ?>
            <div class="alert alert-success mt-3"><?php echo $success; ?></div>
          <?php elseif (isset($err)): ?>
            <div class="alert alert-danger mt-3"><?php echo $err; ?></div>
          <?php endif; ?>


          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-6">
              <div class="col-12">
                <div class="card overflow-hidden">
                  <div class="card-header">
                    <h5 class="card-title m-0 me-2">Pending Loans</h5>
                    <h7 class="card-title m-0 me-2">Approve and Reject Loans</h7>
                  </div>

                  <div class="table-responsive">
                    <table id="export" class="table table-hover table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Loan Code</th>
                          <th>Account No.</th>
                          <th>Account Name</th>
                          <th>Amount</th>
                          <th>Client Name</th>
                          <th>Phone</th>
                          <th>Timestamp</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Get pending loans
                        $ret = "SELECT * FROM ib_loans WHERE ln_status = 'Pending' ORDER BY created_at DESC";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        $cnt = 1;
                        while ($row = $res->fetch_object()) {
                        ?>
                          <tr>
                            <td><?php echo $cnt; ?></td>
                            <td><?php echo $row->ln_code; ?></td>
                            <td><?php echo $row->account_number; ?></td>
                            <td><?php echo $row->acc_name; ?></td>
                            <td>$ <?php echo $row->ln_amount; ?></td>
                            <td><?php echo $row->client_name; ?></td>
                            <td><?php echo $row->client_phone; ?></td>
                            <td><?php echo date("d-M-Y h:i:s", strtotime($row->created_at)); ?></td>

                            <td>
                              <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                  <i class="ri-more-2-line"></i>
                                </button>
                                <div class="dropdown-menu">
                                  <a class="dropdown-item" href="?approve_loan=<?php echo $row->ln_id; ?>"><i class="ri-check-line"></i> Approve</a>
                                  <a class="dropdown-item" href="?reject_loan=<?php echo $row->ln_id; ?>"><i class="ri-close-circle-line"></i> Reject</a>
                                </div>
                              </div>
                            </td>
                          </tr>
                        <?php $cnt++;
                        } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Hoverable Table rows -->

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

  <!-- page script -->
  <script>
    $('#export').DataTable({
      dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
      buttons: {
        buttons: [{
            extend: 'excel',
            className: 'btn'
          },
          {
            extend: 'print',
            className: 'btn'
          }
        ]
      },
      "oLanguage": {
        "oPaginate": {
          "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
          "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
        },
        "sInfo": "Showing page _PAGE_ of _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Search...",
        "sLengthMenu": "Results :  _MENU_",
      },
      "stripeClasses": [],
      "lengthMenu": [7, 10, 20, 50],
      "pageLength": 7
    });
  </script>
</body>

</html>
