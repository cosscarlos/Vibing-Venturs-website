// Select the hamburger button and the navigation links container
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');

// Add an event listener to the hamburger button for click events
hamburger.addEventListener('click', () => {
    // Toggle the 'show' class on the navigation links container
    navLinks.classList.toggle('show');
});


