document.addEventListener("DOMContentLoaded", function () {
    const discussionList = document.getElementById("discussion-threads");
    const searchInput = document.getElementById("search-discussions");
    const searchButton = document.getElementById("search-btn");
    const viewMoreButton = document.getElementById("view-more");
    const startDiscussionButton = document.getElementById("start-discussion");

    let discussions = [];

    // Fetch discussions from backend
    function fetchDiscussions() {
        fetch("php/get_discussions.php")
            .then(res => res.json())
            .then(data => {
                discussions = data;
                renderDiscussions();
            })
            .catch(err => {
                console.error("Failed to load discussions:", err);
                discussionList.innerHTML = "<li>Error loading discussions.</li>";
            });
    }

    // Render filtered discussions
    function renderDiscussions(filter = "") {
        discussionList.innerHTML = "";

        const filtered = discussions.filter(d => 
            d.title.toLowerCase().includes(filter.toLowerCase())
        );

        if (filtered.length === 0) {
            discussionList.innerHTML = "<p class='no-results'>No discussions found.</p>";
            return;
        }

        filtered.forEach(d => {
            const li = document.createElement("li");
            li.innerHTML = `
                <a href="discussion.php?id=${d.id}">
                    <h4>${d.title}</h4>
                </a>
                <p>By ${d.username} • ${new Date(d.created_at).toLocaleDateString()}</p>
            `;
            discussionList.appendChild(li);
        });
    }

    // Search functionality
    searchButton.addEventListener("click", () => {
        const query = searchInput.value.trim();
        renderDiscussions(query);
    });

    // View More 
    viewMoreButton.addEventListener("click", () => {
        window.location.href = "discussions.php";
    });

    // Start New Discussion
    startDiscussionButton.addEventListener("click", () => {
        window.location.href = "new-discussion.php";
    });

    // Initial load
    fetchDiscussions();
});