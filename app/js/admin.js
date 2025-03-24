document.addEventListener("DOMContentLoaded", () => {
    // Delete user button
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", () => {
            const userId = button.dataset.id;
            if (confirm("Are you sure you want to delete this user?")) {
                fetch("php/admin_users.php", {
                    method: "DELETE",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: `id=${userId}`
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        button.closest("tr").remove();
                    } else {
                        alert("Failed to delete user.");
                    }
                });
            }
        });
    });

    // Delete discussion button
    document.querySelectorAll(".delete-discussion-btn").forEach(button => {
        button.addEventListener("click", () => {
            const id = button.dataset.id;
            if (confirm("Are you sure you want to delete this discussion?")) {
                fetch("php/admin_discussions.php", {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `id=${id}` 
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        button.closest("tr").remove();
                    } else {
                        alert("Failed to delete discussion.");
                    }
                });
            }
        });
    });

    // Toggle enable/disable status
    document.querySelectorAll(".toggle-status-btn").forEach(button => {
        button.addEventListener("click", () => {
            const userId = button.dataset.id;
            const action = button.dataset.status;

            const confirmationText = action === "disable"
                ? "Are you sure you want to disable this user?"
                : "Are you sure you want to enable this user?";

            if (!confirm(confirmationText)) return;

            fetch("php/admin_toggle_status.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `user_id=${userId}&action=${action}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    // Swap status and label
                    const newStatus = action === "disable" ? "enable" : "disable";
                    button.dataset.status = newStatus;
                    button.textContent = newStatus === "enable" ? "Enable" : "Disable";
                } else {
                    alert("Failed to update status.");
                }
            });
        });
    });
});

function openEditModal(id, fullName, email, location, role) {
    document.getElementById("edit-user-id").value = id;
    document.getElementById("edit-full-name").value = fullName;
    document.getElementById("edit-email").value = email;
    document.getElementById("edit-location").value = location;

    const roleGroup = document.getElementById("edit-role-group");
    if (role === "admin") {
        roleGroup.style.display = "none";
    } else {
        roleGroup.style.display = "block";
        document.getElementById("edit-role").value = role;
    }

    document.getElementById("editUserModal").style.display = "block";
}

function closeEditModal() {
    document.getElementById("editUserModal").style.display = "none";
}

function showSection(section) {
    document.querySelectorAll('.dashboard-section').forEach(s => s.classList.remove('active'));
    document.getElementById(`${section}-section`).classList.add('active');

    document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
    event.target.classList.add('active');
}