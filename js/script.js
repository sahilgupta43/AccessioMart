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

