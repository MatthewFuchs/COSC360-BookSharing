// Wait for the DOM to load before attaching event listeners
document.addEventListener("DOMContentLoaded", function () {
    // Attach event listener after the navigation is updated
    document.addEventListener("updateHeaderNavComplete", function () {
        let menuToggle = document.querySelector(".menu-toggle");
        let navBar = document.querySelector(".tnav");

        if (menuToggle && navBar) {
            menuToggle.addEventListener("click", function () {
                navBar.classList.toggle("active");
            });
        }
    });
});