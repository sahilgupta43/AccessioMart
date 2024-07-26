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