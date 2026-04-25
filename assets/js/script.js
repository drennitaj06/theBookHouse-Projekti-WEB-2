document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const navList = document.querySelector('.ulIndex');

    if (menuToggle && navList) {
        menuToggle.addEventListener('click', function () {
            navList.classList.toggle('show');
        });
    }
});









const sections = document.querySelectorAll('.books-contain');
let currentSectionIndex = 0;
let isAnimating = false;

function showNextSection() {
    if (isAnimating) return;

    isAnimating = true;

    const currentSection = sections[currentSectionIndex];
    currentSection.style.opacity = '0';  // Start fading out the current section

    // Wait for the fade-out to complete before hiding the section and showing the next one
    setTimeout(() => {
        currentSection.classList.remove('activeSection');
        currentSection.style.display = 'none'; // Hide the current section after fade-out

        // Move to the next section
        currentSectionIndex = (currentSectionIndex + 1) % sections.length;

        const nextSection = sections[currentSectionIndex];
        nextSection.style.display = 'flex'; // Show the next section
        setTimeout(() => {
            nextSection.classList.add('activeSection'); // Start fading in the next section
            nextSection.style.opacity = '1';
            isAnimating = false;
        }, 50);  // Add a small delay to ensure the display change is processed before fading in

    }, 600);  // The timeout should match the opacity transition duration (1s)
}

// Change sections every 10 seconds
setInterval(showNextSection, 10000);











// Intersection Observer setup for observing when sections are 50% visible
const observerOptions = {
    threshold: 0.2 // 20% visibility
};

// Function to animate numbers from 0 to the target value
function animateValue(element, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        element.innerHTML = Math.floor(progress * (end - start) + start); // Update number
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

// Callback function to handle section visibility and number animation for section 5
const observerCallback = (entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible'); // Add class to show section

            // Check if section5 is visible and animate the numbers
            if (entry.target.id === 'section5') {
                document.querySelectorAll('.stat-item h1').forEach((statItem) => {
                    const targetValue = parseInt(statItem.getAttribute('data-target'));
                    animateValue(statItem, 0, targetValue, 2000); // Animate over 2 seconds
                });
            }

            observer.unobserve(entry.target); // Stop observing once it has been revealed
        }
    });
};

// Create the observer
const observer = new IntersectionObserver(observerCallback, observerOptions);

// Select all sections and observe each one
document.querySelectorAll('section').forEach(section => {
    observer.observe(section);
});