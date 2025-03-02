document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("search-btn").addEventListener("click", searchDiscussions);
    document.getElementById("create-discussion").addEventListener("click", createDiscussion);

    // Load discussions on page load
    fetchDiscussions();
});

// Fetch all discussions (Simulated API Call)
function fetchDiscussions() {
    let discussionsList = document.querySelector(".discussion-list");
    discussionsList.innerHTML = "<p>Loading discussions...</p>";

    // Simulated API Data
    const discussions = [
        { id: 1, title: "What's your favorite book?", author: "Reader123", replies: 12 },
        { id: 2, title: "Thoughts on AI in literature?", author: "BookBot", replies: 8 },
        { id: 3, title: "Best books to read in 2025?", author: "FutureReader", replies: 5 }
    ];

    setTimeout(() => {
        discussionsList.innerHTML = "";

        discussions.forEach(discussion => {
            let discussionElement = document.createElement("div");
            discussionElement.classList.add("discussion");

            discussionElement.innerHTML = `
                <p class="discussion-title">${discussion.title}</p>
                <p class="discussion-info">Started by <strong>${discussion.author}</strong> • ${discussion.replies} replies</p>
            `;

            discussionElement.addEventListener("click", function () {
                window.location.href = `discussion.html?id=${discussion.id}`;
            });

            discussionsList.appendChild(discussionElement);
        });
    }, 1000);
}

// Function to Search Discussions
function searchDiscussions() {
    let query = document.getElementById("search-input").value.trim().toLowerCase();
    let discussions = document.querySelectorAll(".discussion");

    discussions.forEach(discussion => {
        let title = discussion.querySelector(".discussion-title").textContent.toLowerCase();
        discussion.style.display = title.includes(query) ? "block" : "none";
    });
}

// Function to Create a New Discussion (Placeholder)
function createDiscussion() {
    alert("Feature coming soon! Users will be able to start their own discussions.");
}