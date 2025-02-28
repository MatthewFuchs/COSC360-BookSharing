// Function to load header and footer dynamically
function loadComponents() {
    fetch("nav/header.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("header-placeholder").innerHTML = data;
            updateHeaderNav();
        });

    fetch("nav/footer.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("footer-placeholder").innerHTML = data;
        });
}

// Function to update the header based on user login status
function updateHeaderNav() {
    let user = JSON.parse(localStorage.getItem("user")); 

    let navBar = document.querySelector(".tnav");
    if (!navBar) return;

    navBar.innerHTML = ""; 

    if (user) {
        // If user is logged in
        navBar.innerHTML += `
            <a href="index.html">Home</a>
            <a href="browse.html">Browse Books</a>
            <a href="community.html">Community</a>
            <a href="messages.html">Messages</a>
            <a href="mylistings.html">My Listings</a>
            ${user.role === "admin" ? `<a href="admin.html">Admin Dashboard</a>` : `<a href="profile.html">Profile</a>`}
            <a href="notifications.html">Notifications</a>
            <a href="#" onclick="logoutUser()">Logout</a>
        `;
    } else {
        // Guest view
        navBar.innerHTML += `
            <a href="index.html">Home</a>
            <a href="browse.html">Browse Books</a>
            <a href="community.html">Community</a>
            <a href="login.html">Login / Sign Up</a>
        `;
    }

    // Ensure toggle menu functionality is attached AFTER nav is populated
    attachMenuToggle();

    // Dispatch an event to signal that the header nav is ready
    document.dispatchEvent(new Event("updateHeaderNavComplete"));
}

function attachMenuToggle() {
    let menuToggle = document.querySelector(".menu-toggle");
    let navBar = document.querySelector(".tnav");

    if (!menuToggle || !navBar) return;

    menuToggle.addEventListener("click", function (event) {
        navBar.classList.toggle("active");

        menuToggle.classList.toggle("open");

        event.stopPropagation();
    });

    // Close menu when clicking outside
    document.addEventListener("click", function (event) {
        if (!navBar.contains(event.target) && !menuToggle.contains(event.target)) {
            navBar.classList.remove("active");
            menuToggle.classList.remove("open"); 
        }
    });

    // Close menu when clicking a link
    navBar.addEventListener("click", function (event) {
        if (event.target.tagName === "A") {
            navBar.classList.remove("active");
            menuToggle.classList.remove("open"); 
        }
    });
}

// Function to log out user
function logoutUser() {
    localStorage.removeItem("user"); // Clear stored user data
    window.location.href = "index.html"; // Redirect to home page
}

// Load components when the page loads
window.onload = loadComponents;