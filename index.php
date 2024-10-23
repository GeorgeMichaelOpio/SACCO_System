<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Cheapy SACCO</title>
    <meta name="description" content="Cheapy SACCO - Building Financial Freedom Together" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom CSS -->
    <style>
      /* Colors */
      :root {
        --primary-color: #6a0dad;
        --secondary-color: #4b0082;
        --light-color: #f5f5f5;
        --dark-color: #343a40;
        --text-light: #ffffff;
      }

      body {
        background-color: var(--light-color);
        font-family: 'Open Sans', sans-serif;
      }

      /* Navbar */
      .navbar {
        background-color: var(--dark-color);
      }
      .navbar .nav-link {
        color: var(--text-light);
      }
      .navbar .nav-link:hover {
        color: var(--primary-color);
      }

      /* Hero Section */
      .hero-section {
        text-align: center;
        padding: 100px 20px;
        background-color: var(--primary-color);
        color: var(--text-light);
      }
      .hero-section h1 {
        font-size: 3rem;
        font-weight: 700;
      }
      .hero-section p {
        font-size: 1.2rem;
        margin-bottom: 30px;
      }
      .hero-section .btn {
        padding: 15px 30px;
        font-size: 1.1rem;
        border-radius: 30px;
        background-color: var(--secondary-color);
        border: none;
        color: var(--text-light);
        transition: background-color 0.3s ease;
      }
      .hero-section .btn:hover {
        background-color: var(--primary-color);
        color: var(--text-light);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      }

      /* Features Section */
      .features-section {
        padding: 50px 20px;
        background-color: var(--light-color);
      }
      .features-section h3 {
        text-align: center;
        margin-bottom: 50px;
        font-weight: 600;
      }
      .feature-card {
        border: none;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        padding: 30px;
        text-align: center;
      }
      .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
      }
      .feature-card img {
        width: 80px;
        margin-bottom: 20px;
      }
      .feature-card h4 {
        color: var(--primary-color);
        font-weight: 600;
      }

      /* Testimonials Section */
      .testimonials-section {
        padding: 50px 20px;
        background-color: var(--primary-color);
        color: var(--text-light);
      }
      .testimonials-section h3 {
        text-align: center;
        margin-bottom: 50px;
        font-weight: 600;
        color: var(--text-light);
      }
      .testimonial-card {
        background-color: var(--secondary-color);
        border-radius: 10px;
        padding: 20px;
        color: var(--text-light);
        margin-bottom: 20px;
      }

      /* CTA Section */
      .cta-section {
        text-align: center;
        margin-top: 50px;
      }
      .cta-section .btn {
        margin: 10px;
        padding: 15px 40px;
        font-size: 1.1rem;
        border-radius: 30px;
        background-color: var(--primary-color);
        color: var(--text-light);
        transition: background-color 0.3s ease, box-shadow 0.3s;
      }
      .cta-section .btn:hover {
        background-color: var(--secondary-color);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      }

      /* Footer */
      footer {
        padding: 20px;
        text-align: center;
        background-color: var(--dark-color);
        color: var(--text-light);
        margin-top: 50px;
      }
      footer a {
        color: var(--text-light);
        text-decoration: none;
        margin: 0 10px;
      }
      footer a:hover {
        text-decoration: underline;
      }

      /* Media Queries */
      @media (max-width: 768px) {
        .hero-section h1 {
          font-size: 2.5rem;
        }
        .hero-section p {
          font-size: 1rem;
        }
        .features-section {
          padding: 30px 10px;
        }
      }
    </style>
  </head>

  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="">Cheapy SACCO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="">Features</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="">Contact</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Login
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="admin/pages_login.php">Login as Admin</a>
                <a class="dropdown-item" href="#">Login as Client</a>
                <a class="dropdown-item" href="#">Login as Staff</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
      <h1>Welcome to Cheapy SACCO</h1>
      <p>"Empowering Financial Growth through Savings & Credit."</p>
      <a href="#" class="btn btn-lg mt-4">Join Cheapy SACCO</a>
    </div>

    <!-- Features Section -->
    <div class="features-section container">
      <h3 id="features">Why Choose Cheapy SACCO?</h3>
      <div class="row">
        <div class="col-md-4 mb-4">
          <div class="card feature-card">
            <img src="assets/img/icons/savings.svg" alt="Savings Plans" />
            <h4>Flexible Savings Plans</h4>
            <p>Save securely and watch your money grow with high interest rates.</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card feature-card">
            <img src="assets/img/icons/loans.svg" alt="Affordable Loans" />
            <h4>Affordable Loans</h4>
            <p>Access low-interest loans to meet your personal and business needs.</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="card feature-card">
            <img src="assets/img/icons/community.svg" alt="Community Support" />
            <h4>Community Support</h4>
            <p>Be part of a thriving community that supports your financial journey.</p>
          </div>
        </div>
      </div>

      <!-- Call-to-Action Section -->
      <div class="cta-section">
        <a href="#" class="btn btn-primary btn-lg mt-4">Apply for a Loan</a>
        <a href="#" class="btn btn-primary btn-lg mt-4">Learn About Savings</a>
        <a href="#" class="btn btn-primary btn-lg mt-4">Contact Us</a>
      </div>
    </div>

    <!-- Testimonials Section -->
    <div class="testimonials-section">
      <h3>What Our Members Say</h3>
      <div class="container">
        <div class="row">
          <div class="col-md-4 mb-4">
            <div class="testimonial-card">
              <p>"Cheapy SACCO helped me grow my business with an affordable loan. The process was smooth and transparent."</p>
              <small>- John K., Business Owner</small>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="testimonial-card">
              <p>"I have been saving with Cheapy SACCO for 3 years and the interest rates are fantastic. My financial future is secure."</p>
              <small>- Sarah M., Teacher</small>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="testimonial-card">
              <p>"Being a part of Cheapy SACCO has given me financial freedom. The community support is amazing."</p>
              <small>- Kevin L., Farmer</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer>
      <p>&copy; 2024 Cheapy SACCO. All Rights Reserved.</p>
      <p>
        <a href="#">Support</a> |
        <a href="#">Documentation</a> |
        <a href="#">Changelog</a>
      </p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
