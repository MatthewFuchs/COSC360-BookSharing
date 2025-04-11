document.addEventListener("DOMContentLoaded", () => {
    fetch("php/get_notifications.php")
        .then(res => res.json())
        .then(data => renderNotifications(data))
        .catch(err => console.error("Error loading notifications:", err));
});

function renderNotifications(data) {
    const container = document.getElementById("notifications-container");
    if (!data.length) {
        container.innerHTML = "<p>No notifications yet.</p>";
        return;
    }

    data.forEach(n => {
        const div = document.createElement("div");
        div.className = "notification" + (n.is_read ? " read" : "");
        div.innerHTML = `
            <p>${n.message}</p>
            <span>${new Date(n.created_at).toLocaleString()}</span>
        `;
        container.appendChild(div);
    });
}