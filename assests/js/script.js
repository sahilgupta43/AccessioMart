// JavaScript to handle date and time display and menu toggle

document.addEventListener('DOMContentLoaded', () => {
    const dateTimeElement = document.getElementById('date-time');
    const updateTime = () => {
        const now = new Date();
        const dateString = now.toLocaleDateString();
        const timeString = now.toLocaleTimeString();
        dateTimeElement.textContent = `${dateString} ${timeString}`;
    };
    updateTime();
    setInterval(updateTime, 1000);

    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    menuToggle.addEventListener('click', () => {
        navLinks.classList.toggle('active');
    });
});

//search
document.addEventListener('DOMContentLoaded', function() {
    const searchIcon = document.getElementById('search-icon');
    const searchPopup = document.getElementById('search-popup');
    const overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);

    searchIcon.addEventListener('click', function(e) {
        e.preventDefault();
        searchPopup.style.display = 'block';
        overlay.style.display = 'block';
    });

    overlay.addEventListener('click', function() {
        searchPopup.style.display = 'none';
        overlay.style.display = 'none';
    });
});

//newsletter
document.getElementById('newsletter-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    fetch('subscribe.php', { // Path to the PHP script
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const popupMessage = document.getElementById('popup-message');

        if (data.success) {
            popupMessage.textContent = 'Successfully subscribed!';
            popupMessage.style.backgroundColor = '#28a745'; // Green for success
        } else {
            popupMessage.textContent = data.error;
            popupMessage.style.backgroundColor = '#dc3545'; // Red for error
        }

        popupMessage.style.display = 'block';
        setTimeout(() => {
            popupMessage.style.display = 'none';
        }, 2000);
    })
    .catch(error => {
        console.error('Error:', error);
        const popupMessage = document.getElementById('popup-message');
        popupMessage.textContent = 'An error occurred. Please try again.';
        popupMessage.style.backgroundColor = '#dc3545'; // Red for error
        popupMessage.style.display = 'block';

        setTimeout(() => {
            popupMessage.style.display = 'none';
        }, 2000);
    });
});

//signup
function validateForm() {
    // Get form elements
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const password = document.getElementById('password').value;
    const conpassword = document.getElementById('conpassword').value;

    // Regular expressions for validation
    const nameRegex = /^[a-zA-Z\s]+$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phoneRegex = /^\d{10}$/;
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    // Validate name
    if (!nameRegex.test(name)) {
        alert('Name must contain only alphabets and spaces.');
        return false;
    }

    // Validate email
    if (!emailRegex.test(email)) {
        alert('Invalid email format.');
        return false;
    }

    // Validate phone
    if (!phoneRegex.test(phone)) {
        alert('Phone number must be 10 digits.');
        return false;
    }

    // Validate password
    if (!passwordRegex.test(password)) {
        alert('Password must be at least 8 characters long and contain an uppercase letter, a lowercase letter, a number, and a special character.');
        return false;
    }

    // Validate confirm password
    if (password !== conpassword) {
        alert('Passwords do not match.');
        return false;
    }

    // If all validations pass
    return true;
}

//user_dashboard
function showSection(sectionId) {
    var sections = document.getElementsByClassName('content-section');
    for (var i = 0; i < sections.length; i++) {
        sections[i].classList.remove('active');
    }
    document.getElementById(sectionId).classList.add('active');
}

document.addEventListener('DOMContentLoaded', function() {
    showSection('user-info');
});

function validatePassword(password) {
    var pattern = /^(?=.[a-z])(?=.[A-Z])(?=.\d)(?=.[@$!%?&])[A-Za-z\d@$!%?&]{8,}$/;
    return pattern.test(password);
}

function updatePassword() {
    var currentPassword = document.getElementById('current-password').value;
    var newPassword = document.getElementById('new-password').value;
    var confirmNewPassword = document.getElementById('confirm-new-password').value;
    var errorMessage = document.getElementById('error-message');
    var successMessage = document.getElementById('success-message');

    if (newPassword !== confirmNewPassword) {
        errorMessage.textContent = 'New passwords do not match.';
        return false;
    }

    if (!validatePassword(newPassword)) {
        errorMessage.textContent = 'Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.';
        return false;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_password.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            if (xhr.responseText === 'success') {
                successMessage.textContent = 'Password successfully changed.';
            } else {
                errorMessage.textContent = xhr.responseText;
            }
        } else {
            errorMessage.textContent = 'An error occurred while updating the password.';
        }
    };
    xhr.send('current_password=' + encodeURIComponent(currentPassword) + '&new_password=' + encodeURIComponent(newPassword));
}