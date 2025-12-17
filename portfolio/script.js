// Menu toggle behavior
const menuButton = document.getElementById('menu-button');
const navLinks = document.getElementById('nav-links');

function toggleMenu() {
  navLinks.classList.toggle('open');
  const isExpanded = navLinks.classList.contains('open');
  menuButton.setAttribute('aria-expanded', isExpanded);
  menuButton.innerHTML = isExpanded ? '✕' : '☰';
}

if (menuButton) {
  menuButton.addEventListener('click', toggleMenu);
  // Close menu when a link is clicked (mobile)
  navLinks.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      if (navLinks.classList.contains('open')) toggleMenu();
    });
  });
}

// Contact form handling
const contactForm = document.getElementById('contact-form-id');
const messageDiv = document.getElementById('form-message');

if (contactForm && messageDiv) {
  contactForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const nameInput = document.getElementById('name').value.trim();
    const emailInput = document.getElementById('email').value.trim();

    if (!nameInput || !emailInput) {
      messageDiv.textContent = 'Please fill out all required fields.';
      messageDiv.style.color = 'tomato';
      // focus first empty
      if (!nameInput) document.getElementById('name').focus();
      else document.getElementById('email').focus();
      return;
    }

    // Simple email validation
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailInput)) {
      messageDiv.textContent = 'Please enter a valid email address.';
      messageDiv.style.color = 'tomato';
      document.getElementById('email').focus();
      return;
    }

    // Mock submission success
    messageDiv.textContent = 'Thank you for your message! I will be in touch shortly.';
    messageDiv.style.color = 'lightgreen';
    contactForm.reset();
  });
}

// Set copyright year
document.getElementById('year').textContent = new Date().getFullYear();
