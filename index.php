<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Cheapy</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/svg/icon.svg" rel="icon">
  <link href="assets/svg/icon.svg" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="" class="logo d-flex align-items-center me-auto me-xl-0">
        <h1 class="sitename">Cheapy</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#contact">Contact</a></li>
          <li class="dropdown"><a href="#"><span>Login</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="client/pages_login.php">Client</a></li>
              <li><a href="admin/pages_login.php">Admin</a></li>
            </ul>
          </li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="#about">Get Started</a>
    </div>
  </header>

  <main class="main">

  <section id="hero" class="hero section">
      <div class="container" data-aos="fade-up">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="hero-content">
              <h1 class="mb-4">
                Financial Empowerment <br>
                <span class="accent-text">For a Brighter Future</span>
              </h1>
              <p class="mb-4 mb-md-5">
                Join Cheapy SACCO today to save, borrow, and grow. We are here to help you achieve financial freedom and support your goals.
              </p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="hero-image" data-aos="zoom-out">
              <img src="assets/img/illustration-1.webp" alt="SACCO Services" class="img-fluid">
            </div>
          </div>
        </div>
      </div>
    </section>

    

    
    <!-- Contact Section -->
    <section id="contact" class="contact section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row g-4 g-lg-5">
        <div class="col-lg-5">
  <div class="info-box" data-aos="fade-up" data-aos-delay="200">
    <h3>Contact Info</h3>
    <p>We'd love to hear from you! Reach out for inquiries, support, or just to say hello.</p>

    <div class="info-item" data-aos="fade-up" data-aos-delay="300">
      <div class="icon-box">
        <i class="bi bi-geo-alt"></i>
      </div>
      <div class="content">
        <h4>Our Location</h4>
        <p>123 Innovation Way</p>
        <p>Mbarara, Uganda</p>
      </div>
    </div>

    <div class="info-item" data-aos="fade-up" data-aos-delay="400">
      <div class="icon-box">
        <i class="bi bi-telephone"></i>
      </div>
      <div class="content">
        <h4>Phone Number</h4>
        <p>+256 770 123456</p>
        <p>+256 774 654321</p>
      </div>
    </div>

    <div class="info-item" data-aos="fade-up" data-aos-delay="500">
      <div class="icon-box">
        <i class="bi bi-envelope"></i>
      </div>
      <div class="content">
        <h4>Email Address</h4>
        <p>info@yourdomain.com</p>
        <p>support@yourdomain.com</p>
      </div>
    </div>
  </div>
</div>


          <div class="col-lg-7">
            <div class="contact-form" data-aos="fade-up" data-aos-delay="300">
              <h3>Get In Touch</h3>
              <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
                <div class="row gy-4">

                  <div class="col-md-6">
                    <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                  </div>

                  <div class="col-md-6 ">
                    <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                  </div>

                  <div class="col-12">
                    <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                  </div>

                  <div class="col-12">
                    <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                  </div>

                  <div class="col-12 text-center">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your message has been sent. Thank you!</div>

                    <button type="submit" class="btn">Send Message</button>
                  </div>

                </div>
              </form>

            </div>
          </div>

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer">

<div class="container footer-top">
  <div class="row gy-4">
    <div class="col-lg-4 col-md-6 footer-about">
      <a class="logo d-flex align-items-center">
        <span class="sitename">Cheapy SACCO</span>
      </a>
      <div class="footer-contact pt-3">
        <p>123 Prosperity Street</p>
        <p>Mbarara, Uganda</p>
        <p class="mt-3"><strong>Phone:</strong> <span>+256 123 456 789</span></p>
        <p><strong>Email:</strong> <span>support@cheapysacco.com</span></p>
      </div>
      <div class="social-links d-flex mt-4">
        <a ><i class="bi bi-twitter"></i></a>
        <a ><i class="bi bi-facebook"></i></a>
        <a ><i class="bi bi-instagram"></i></a>
        <a ><i class="bi bi-linkedin"></i></a>
      </div>
    </div>

    <div class="col-lg-2 col-md-3 footer-links">
      <h4>Quick Links</h4>
      <ul>
        <li><a >Home</a></li>
        <li><a >About Us</a></li>
        <li><a >Services</a></li>
        <li><a >Contact</a></li>
        <li><a >FAQs</a></li>
      </ul>
    </div>

    <div class="col-lg-2 col-md-3 footer-links">
      <h4>Our Services</h4>
      <ul>
        <li><a >Savings Accounts</a></li>
        <li><a >Loan Services</a></li>
        <li><a >Insurance</a></li>
        <li><a >Financial Literacy</a></li>
        <li><a >Business Support</a></li>
      </ul>
    </div>

<!-- Newsletter Subscription Section -->
<div class="col-lg-4 col-md-6 footer-newsletter">
  <h4 class="newsletter-title">Join Our Newsletter</h4>
  <p class="newsletter-text">
    Stay updated with the latest offers, news, and insights from Cheapy SACCO. Subscribe now!
  </p>
  <form action="" method="post" class="newsletter-form d-flex">
    <input type="email" name="email" placeholder="Enter your email" required class="form-control newsletter-input me-2">
    <button type="submit" class="btn btn-subscribe">Subscribe</button>
  </form>
</div>

  </div>
</div>

<div class="container text-center mt-4">
  <p>© <strong class="px-1 sitename">Cheapy SACCO</strong> | All Rights Reserved</p>
</div>

</footer>


  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/index_main.js"></script>

</body>

</html>