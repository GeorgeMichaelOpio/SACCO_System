<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('conf/config.php');
include('conf/checklogin.php');
check_login();
$client_id = $_SESSION['client_id'];
//register new account
if (isset($_POST['open_account'])) {
	//Client open account
	$acc_name = $_POST['acc_name'];
	$account_number = $_POST['account_number'];
	$acc_type = $_POST['acc_type'];
	$acc_rates = $_POST['acc_rates'];
	$acc_status = $_POST['acc_status'];
	$acc_amount = $_POST['acc_amount'];
	$client_id  = $_SESSION['client_id'];
	$client_national_id = $_POST['client_national_id'];
	$client_name = $_POST['client_name'];
	$client_phone = $_POST['client_phone'];
	$client_number = $_POST['client_number'];
	$client_email  = $_POST['client_email'];
	$client_adr  = $_POST['client_adr'];

	//Insert Captured information to a database table
	$query = "INSERT INTO ib_bankaccounts (acc_name, account_number, acc_type, acc_rates, acc_status, acc_amount, client_id, client_name, client_national_id, client_phone, client_number, client_email, client_adr) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$stmt = $mysqli->prepare($query);
	//bind paramaters
	$rc = $stmt->bind_param('sssssssssssss', $acc_name, $account_number, $acc_type, $acc_rates, $acc_status, $acc_amount, $client_id, $client_name, $client_national_id, $client_phone, $client_number, $client_email, $client_adr);
	$stmt->execute();

	//declare a varible which will be passed to alert function
	if ($stmt) {
		$success = "Account Opened";
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

<?php include 'components/head.php'; ?>

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
					<!-- Alert messages -->
					<?php if (isset($success)): ?>
						<div class="alert alert-success mt-3"><?php echo $success; ?></div>
					<?php elseif (isset($err)): ?>
						<div class="alert alert-danger mt-3"><?php echo $err; ?></div>
					<?php endif; ?>
					<!-- Content -->

					<?php
					 $client_id = $_SESSION['client_id'];
					$ret = "SELECT * FROM  ib_clients WHERE client_id = ? ";
					$stmt = $mysqli->prepare($ret);
					$stmt->bind_param('i', $client_id);
					$stmt->execute(); //ok
					$res = $stmt->get_result();
					$cnt = 1;
					while ($row = $res->fetch_object()) {

					?>

						<div class="container-xxl flex-grow-1 container-p-y">
							<!-- Basic Layout -->
							<div class="row">
								<div class="col-xl">
									<div class="card mb-6">
										<div class="card-header d-flex justify-content-between align-items-center">
											<h5 class="mb-0">Open <?php echo $row->name; ?> Banking Account</h5>
										</div>
										<div class="card-body pt-0">
											<form method="post" enctype="multipart/form-data" role="form">
												<div class="row mt-1 g-5">
													<div class="col-md-6">
														<div class="form-floating form-floating-outline">
															<input type="text" readonly name="client_name" value="<?php echo $row->name; ?>" required class="form-control" id="client_name">
															<label for="client_name">Client Name</label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-floating form-floating-outline">
															<input type="text" readonly name="client_number" value="<?php echo $row->client_number; ?>" class="form-control" id="ClientNumber">
															<label for="clientNumber">Client Number</label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-floating form-floating-outline">
															<input type="text" readonly name="client_phone" value="<?php echo $row->phone; ?>" required class="form-control" id="ClientPhoneNumber">
															<label for="clientPhoneNumber">Client Phone Number</label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-floating form-floating-outline">
															<input type="text" readonly value="<?php echo $row->national_id; ?>" name="client_national_id" required class="form-control" id="ClientNationalId">
															<label for="ClientNationalId">Client National ID No.</label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-floating form-floating-outline">
															<input type="email" readonly name="client_email" value="<?php echo $row->email; ?>" required class="form-control" id="ClientEmail">
															<label for="client_name">Client Email</label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-floating form-floating-outline">
															<input type="text" name="client_adr" readonly value="<?php echo $row->address; ?>" required class="form-control" id="ClientAddress">
															<label for="client_name">Client Address</label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-floating form-floating-outline">
															<select class="form-control" onChange="getiBankAccs(this.value);" name="acc_type">
																<option>Select Any Account types</option>
																<?php
																//fetch all ib_acc_types
																$ret = "SELECT * FROM  ib_acc_types ORDER BY RAND() ";
																$stmt = $mysqli->prepare($ret);
																$stmt->execute(); //ok
																$res = $stmt->get_result();
																$cnt = 1;
																while ($row = $res->fetch_object()) {

																?>
																	<option value="<?php echo $row->name; ?> "> <?php echo $row->name; ?> </option>
																<?php } ?>
															</select>
															<label for="AccountType">Account Type</label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-floating form-floating-outline">
															<input type="text" name="acc_rates" readonly required class="form-control" id="AccountRates">
															<label for="client_name">Account Type Rates (%)</label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-floating form-floating-outline">
															<input type="text" name="acc_name" required class="form-control" id="AccountName">
															<label for="client_name">Account Name</label>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-floating form-floating-outline">
															<?php
															//PHP function to generate random account number
															$length = 12;
															$_accnumber =  substr(str_shuffle('0123456789'), 1, $length);
															?>
															<input type="text" name="account_number" value="<?php echo $_accnumber; ?>" required class="form-control" id="AccountNumber<">
															<label for="client_name">Account Number</label>
														</div>
													</div>
													<div class=" col-md-6 form-group" style="display:none">
														<label for="exampleInputEmail1">Account Status</label>
														<input type="text" name="acc_status" value="Active" readonly required class="form-control">
													</div>

													<div class=" col-md-6 form-group" style="display:none">
														<label for="exampleInputEmail1">Account Amount</label>
														<input type="text" name="acc_amount" value="0" readonly required class="form-control">
													</div>
												</div>
												<div class="mt-6">
													<button name="open_account" type="submit" class="btn btn-primary me-3">Open Bank Account</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!-- / Content -->


							<div class="content-backdrop fade"></div>
						</div>
					<?php } ?>
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

		<script>
			function getiBankAccs(accountType) {
				// Create a new XMLHttpRequest
				var xhr = new XMLHttpRequest();
				xhr.open("GET", "fetch_account_rates.php?acc_type=" + accountType, true);
				xhr.onload = function() {
					if (xhr.status === 200) {
						// Update the Account Rates input field with the response
						document.getElementById("AccountRates").value = xhr.responseText;
					} else {
						// Handle errors here
						console.error("Error fetching account rates");
					}
				};
				xhr.send();
			}
		</script>

</body>

</html>