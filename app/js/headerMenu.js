document.addEventListener("DOMContentLoaded", function () {
    if (window.headerMenuInitialized) return;
    window.headerMenuInitialized = true;

    const menuToggle = document.querySelector(".menu-toggle");
    const navBar = document.querySelector(".tnav");

    if (!menuToggle || !navBar) {
        console.warn("Menu toggle or nav bar not found");
        return;
    }

    console.log("Attaching mobile nav toggle");

    menuToggle.addEventListener("click", function (event) {
        console.log("Hamburger clicked");
        navBar.classList.toggle("active");
        menuToggle.classList.toggle("open");
        event.stopPropagation();
    });

    document.addEventListener("click", function (event) {
        if (!navBar.contains(event.target) && !menuToggle.contains(event.target)) {
            navBar.classList.remove("active");
            menuToggle.classList.remove("open");
        }
    });

    navBar.addEventListener("click", function (event) {
        if (event.target.tagName === "A") {
            navBar.classList.remove("active");
            menuToggle.classList.remove("open");
        }
    });
});