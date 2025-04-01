document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("login-form").addEventListener("submit", function (e) {
        const username = document.getElementById("login-username").value.trim();
        const password = document.getElementById("login-password").value;

        if (!username || !password) {
            alert("All login fields must be filled out!");
            e.preventDefault();
        } else if (password.length < 8) {
            alert("Password must be at least 8 characters long!");
            e.preventDefault();
        }
    });

    document.getElementById("signup-form").addEventListener("submit", function (e) {
        const email = document.getElementById("signup-email").value.trim();
        const username = document.getElementById("signup-username").value.trim();
        const password = document.getElementById("signup-password").value;
        const confirm = document.getElementById("signup-confirm-password").value;

        if (!email || !username || !password || !confirm) {
            alert("All sign-up fields must be filled out!");
            e.preventDefault();
        } else if (password.length < 8) {
            alert("Password must be at least 8 characters long!");
            e.preventDefault();
        } else if (password !== confirm) {
            alert("Passwords do not match!");
            e.preventDefault();
        }
    });
});