document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.querySelector(".menu-toggle");
    const navBar = document.querySelector(".tnav");

    if (!menuToggle || !navBar) return;

    // Toggle nav visibility when clicking the menu icon
    menuToggle.addEventListener("click", function (event) {
        navBar.classList.toggle("active");
        menuToggle.classList.toggle("open");
        event.stopPropagation();
    });

    // Close menu if clicking outside of it
    document.addEventListener("click", function (event) {
        if (!navBar.contains(event.target) && !menuToggle.contains(event.target)) {
            navBar.classList.remove("active");
            menuToggle.classList.remove("open");
        }
    });

    // Close menu when clicking a nav link
    navBar.addEventListener("click", function (event) {
        if (event.target.tagName === "A") {
            navBar.classList.remove("active");
            menuToggle.classList.remove("open");
        }
    });
});