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
