<ul class="menu-inner py-1">
  <?php
  $current_page = basename($_SERVER['PHP_SELF']);
  ?>

  <!-- Dashboard -->
  <li class="menu-item <?php echo ($current_page == 'pages_dashboard.php') ? 'active' : ''; ?>">
    <a href="pages_dashboard.php" class="menu-link">
      <i class="menu-icon tf-icons ri-home-smile-line"></i>
      <div data-i18n="Dashboard">Dashboard</div>
    </a>
  </li>

  <!-- Account -->
  <li class="menu-item <?php echo ($current_page == 'pages_account.php') ? 'active' : ''; ?>">
    <a href="pages_account.php" class="menu-link">
      <i class="menu-icon tf-icons ri-account-pin-circle-line"></i>
      <div data-i18n="Account">Account</div>
    </a>
  </li>

  <!-- Clients -->
  <li class="menu-item <?php echo ($current_page == 'pages_add_client.php' || $current_page == 'pages_manage_clients.php') ? 'active' : ''; ?>">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
      <i class="menu-icon tf-icons ri-group-2-line"></i>
      <div data-i18n="Clients">Clients</div>
    </a>
    <ul class="menu-sub">
      <li class="menu-item <?php echo ($current_page == 'pages_add_client.php') ? 'active' : ''; ?>">
        <a href="pages_add_client.php" class="menu-link">
          <div data-i18n="Add Client">Add Client</div>
        </a>
      </li>
      <li class="menu-item <?php echo ($current_page == 'pages_manage_clients.php') ? 'active' : ''; ?>">
        <a href="pages_manage_clients.php" class="menu-link">
          <div data-i18n="Manage Clients">Manage Clients</div>
        </a>
      </li>
    </ul>
  </li>

  <!-- Accounts -->
  <li class="menu-item <?php echo in_array($current_page, ['pages_add_acc_type.php', 'pages_manage_accs.php', 'pages_open_acc.php', 'pages_manage_acc_openings.php']) ? 'active' : ''; ?>">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
      <i class="menu-icon tf-icons ri-bank-card-2-line"></i>
      <div data-i18n="Accounts">Accounts</div>
    </a>
    <ul class="menu-sub">
      <li class="menu-item <?php echo ($current_page == 'pages_add_acc_type.php') ? 'active' : ''; ?>">
        <a href="pages_add_acc_type.php" class="menu-link">
          <div data-i18n="Add Acc Type">Add Acc Type</div>
        </a>
      </li>
      <li class="menu-item <?php echo ($current_page == 'pages_manage_accs.php') ? 'active' : ''; ?>">
        <a href="pages_manage_accs.php" class="menu-link">
          <div data-i18n="Manage Acc Types">Manage Acc Types</div>
        </a>
      </li>
      <li class="menu-item <?php echo ($current_page == 'pages_open_acc.php') ? 'active' : ''; ?>">
        <a href="pages_open_acc.php" class="menu-link">
          <div data-i18n="Open Acc">Open Acc</div>
        </a>
      </li>
      <li class="menu-item <?php echo ($current_page == 'pages_manage_acc_openings.php') ? 'active' : ''; ?>">
        <a href="pages_manage_acc_openings.php" class="menu-link">
          <div data-i18n="Manage Acc Openings">Manage Acc Openings</div>
        </a>
      </li>
    </ul>
  </li>

    <!-- Loans -->
    <li class="menu-item <?php echo in_array($current_page, ['pages_loan_request.php', 'pages_loan_pending.php', 'pages_loan_approved.php', 'pages_loan_cancelled.php']) ? 'active' : ''; ?>">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
      <i class="menu-icon tf-icons ri-shake-hands-line"></i>
      <div data-i18n="Loans">Loans</div>
    </a>
    <ul class="menu-sub">
    <li class="menu-item <?php echo ($current_page == 'pages_loan_request.php') ? 'active' : ''; ?>">
        <a href="pages_loan_request.php" class="menu-link">
          <div data-i18n="Request Loan">Request Loan</div>
        </a>
      </li>
      <li class="menu-item <?php echo ($current_page == 'pages_loan_pending.php') ? 'active' : ''; ?>">
        <a href="pages_loan_pending.php" class="menu-link">
          <div data-i18n="Pending">Pending</div>
        </a>
      </li>
      <li class="menu-item <?php echo ($current_page == 'pages_loan_approved.php') ? 'active' : ''; ?>">
        <a href="pages_loan_approved.php" class="menu-link">
          <div data-i18n="Approved">Approved</div>
        </a>
      </li>
      <li class="menu-item <?php echo ($current_page == 'pages_loan_cancelled.php') ? 'active' : ''; ?>">
        <a href="pages_loan_cancelled.php" class="menu-link">
          <div data-i18n="Rejected">Rejected</div>
        </a>
      </li>
    </ul>
  </li>

  <!-- Finances -->
  <li class="menu-item <?php echo in_array($current_page, ['pages_deposits.php', 'pages_withdrawals.php', 'pages_transfers.php', 'pages_balance_enquiries.php']) ? 'active' : ''; ?>">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
      <i class="menu-icon tf-icons ri-money-dollar-circle-line"></i>
      <div data-i18n="Finances">Finances</div>
    </a>
    <ul class="menu-sub">
      <li class="menu-item <?php echo ($current_page == 'pages_deposits.php') ? 'active' : ''; ?>">
        <a href="pages_deposits.php" class="menu-link">
          <div data-i18n="Deposits">Deposits</div>
        </a>
      </li>
      <li class="menu-item <?php echo ($current_page == 'pages_withdrawals.php') ? 'active' : ''; ?>">
        <a href="pages_withdrawals.php" class="menu-link">
          <div data-i18n="Withdrawals">Withdrawals</div>
        </a>
      </li>
      <li class="menu-item <?php echo ($current_page == 'pages_transfers.php') ? 'active' : ''; ?>">
        <a href="pages_transfers.php" class="menu-link">
          <div data-i18n="Transfers">Transfers</div>
        </a>
      </li>
      <li class="menu-item <?php echo ($current_page == 'pages_balance_enquiries.php') ? 'active' : ''; ?>">
        <a href="pages_balance_enquiries.php" class="menu-link">
          <div data-i18n="Balance Enquiries">Balance Enquiries</div>
        </a>
      </li>
    </ul>
  </li>

  <!-- Others -->
  <li class="menu-header mt-7">
    <span class="menu-header-text">Others</span>
  </li>


  <!-- Transactions History -->
  <li class="menu-item <?php echo ($current_page == 'pages_transactions_engine.php') ? 'active' : ''; ?>">
    <a href="pages_transactions_engine.php" class="menu-link">
      <i class="menu-icon tf-icons ri-history-line"></i>
      <div data-i18n="Transactions History">Transactions History</div>
    </a>
  </li>

  <!-- Financial Reports -->
  <li class="menu-item <?php echo in_array($current_page, ['pages_financial_reporting_deposits.php', 'pages_financial_reporting_withdrawals.php', 'pages_financial_reporting_transfers.php']) ? 'active' : ''; ?>">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
      <i class="menu-icon tf-icons ri-file-paper-line"></i>
      <div data-i18n="Financial Reports">Financial Reports</div>
    </a>
    <ul class="menu-sub">
      <li class="menu-item <?php echo ($current_page == 'pages_financial_reporting_deposits.php') ? 'active' : ''; ?>">
        <a href="pages_financial_reporting_deposits.php" class="menu-link">
          <div data-i18n="Deposits">Deposits</div>
        </a>
      </li>
      <li class="menu-item <?php echo ($current_page == 'pages_financial_reporting_withdrawals.php') ? 'active' : ''; ?>">
        <a href="pages_financial_reporting_withdrawals.php" class="menu-link">
          <div data-i18n="Withdrawals">Withdrawals</div>
        </a>
      </li>
      <li class="menu-item <?php echo ($current_page == 'pages_financial_reporting_transfers.php') ? 'active' : ''; ?>">
        <a href="pages_financial_reporting_transfers.php" class="menu-link">
          <div data-i18n="Transfers">Transfers</div>
        </a>
      </li>
    </ul>
  </li>

  <!-- System Settings -->
  <li class="menu-item <?php echo ($current_page == 'pages_system_settings.php') ? 'active' : ''; ?>">
    <a href="pages_system_settings.php" class="menu-link">
      <i class="menu-icon tf-icons ri-settings-2-line"></i>
      <div data-i18n="System Settings">System Settings</div>
    </a>
  </li>

  <!-- Log Out -->
  <li class="menu-item <?php echo ($current_page == 'pages_logout.php') ? 'active' : ''; ?>">
    <a href="pages_logout.php" class="menu-link">
      <i class="menu-icon tf-icons ri-logout-circle-r-line"></i>
      <div data-i18n="Log Out">Log Out</div>
    </a>
  </li>
</ul>