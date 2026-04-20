document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector('.menu-toggle');
    const navList = document.querySelector('.ulIndex');

    if (menuToggle && navList) {
        menuToggle.addEventListener('click', function () {
            navList.classList.toggle('show');
        });
    }
});