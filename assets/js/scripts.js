window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink');
        } else {
            navbarCollapsible.classList.add('navbar-shrink');
        }
    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    //  Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

    // Loan calculation functionality
    document.getElementById('loan-form').addEventListener('submit', calculateResults);

    function calculateResults(e) {
        const amount = document.getElementById('amount');
        const interest = document.getElementById('interest');
        const years = document.getElementById('years');
        const monthlyPayment = document.getElementById('monthly-payment');
        const totalPayment = document.getElementById('total-payment');
        const totalInterest = document.getElementById('total-interest');

        const principal = parseFloat(amount.value);
        const calculatedInterest = parseFloat(interest.value) / 100 / 12;
        const calculatedPayment = parseFloat(years.value) * 12;

        const x = Math.pow(1 + calculatedInterest, calculatedPayment);
        const monthly = (principal * x * calculatedInterest) / (x - 1);

        if (isFinite(monthly)) {
            monthlyPayment.value = monthly.toFixed(2);
            totalPayment.value = (monthly * calculatedPayment).toFixed(2);
            totalInterest.value = ((monthly * calculatedPayment) - principal).toFixed(2);
        } else {
            showError("Please check your numbers");
        }

        e.preventDefault();
    }

    function showError(error) {
        const errorDiv = document.createElement('div');
        const card = document.querySelector('.card');
        const heading = document.querySelector('.heading');
        errorDiv.className = 'alert alert-danger';
        errorDiv.appendChild(document.createTextNode(error));
        card.insertBefore(errorDiv, heading);
        setTimeout(clearError, 3000);
    }

    function clearError() {
        document.querySelector('.alert').remove();
    }

    // EmailJS Integration for Contact Form
    (function () {
        emailjs.init("YOUR_USER_ID"); // Replace with your EmailJS User ID
    })();

    document.getElementById('contactForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const name = document.getElementById("name").value;
        const email = document.getElementById("email").value;
        const phone = document.getElementById("phone").value;
        const message = document.getElementById("message").value;

        // Send the form data via EmailJS
        emailjs.send("YOUR_SERVICE_ID", "YOUR_TEMPLATE_ID", {
            from_name: name,
            from_email: email,
            phone: phone,
            message: message
        }).then(function (response) {
            console.log('SUCCESS!', response.status, response.text);
            document.getElementById("submitSuccessMessage").classList.remove('d-none');
        }, function (error) {
            console.log('FAILED...', error);
            document.getElementById("submitErrorMessage").classList.remove('d-none');
        });
    });

});
