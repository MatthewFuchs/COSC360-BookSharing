document.addEventListener("DOMContentLoaded", function () {
    const discussionList = document.getElementById("discussion-threads");
    const reviewList = document.getElementById("recent-reviews");
    const searchInput = document.getElementById("search-discussions");
    const searchButton = document.getElementById("search-btn");
    const viewMoreButton = document.getElementById("view-more");
    const startDiscussionButton = document.getElementById("start-discussion");

    // Temporary Mock Data for Discussions & Reviews
    let discussions = [
        { title: "Best Sci-Fi Books?", id: 1, author: "Alice", likes: 5 },
        { title: "Underrated Fantasy Reads?", id: 2, author: "Bob", likes: 8 },
        { title: "How to Start Reading Classics?", id: 3, author: "Charlie", likes: 4 }
    ];

    let reviews = [
        { book: "Dune", user: "Dave", rating: "⭐⭐⭐⭐⭐", comment: "Amazing world-building!" },
        { book: "The Hobbit", user: "Emma", rating: "⭐⭐⭐⭐", comment: "A great adventure story." },
        { book: "1984", user: "Frank", rating: "⭐⭐⭐⭐⭐", comment: "A chilling dystopian novel." }
    ];

    // Function to Load Discussions
    function loadDiscussions(filter = "") {
        discussionList.innerHTML = ""; // Clear list

        let filteredDiscussions = discussions.filter(d => 
            d.title.toLowerCase().includes(filter.toLowerCase())
        );

        filteredDiscussions.forEach(discussion => {
            let li = document.createElement("li");
            li.innerHTML = `
                <a href="discussion.html?id=${discussion.id}">
                    <h4>${discussion.title}</h4>
                </a>
                <p>By ${discussion.author} • 👍 ${discussion.likes}</p>
            `;
            discussionList.appendChild(li);
        });

        if (filteredDiscussions.length === 0) {
            discussionList.innerHTML = "<p class='no-results'>No discussions found.</p>";
        }
    }

    // Function to Load Reviews
    function loadReviews() {
        reviewList.innerHTML = ""; // Clear list

        reviews.forEach(review => {
            let li = document.createElement("li");
            li.innerHTML = `
                <strong>${review.book}</strong> - ${review.rating} <br>
                <em>by ${review.user}:</em> "${review.comment}"
            `;
            reviewList.appendChild(li);
        });
    }

    // Search Functionality
    searchButton.addEventListener("click", () => {
        let query = searchInput.value.trim();
        loadDiscussions(query);
    });

    // View More Discussions (Redirect Later)
    viewMoreButton.addEventListener("click", () => {
        window.location.href = "discussions.html"; // Future implementation
    });

    // Start a Discussion (Redirect Later)
    startDiscussionButton.addEventListener("click", () => {
        window.location.href = "new-discussion.html"; // Future implementation
    });

    // Load Initial Data
    loadDiscussions();
    loadReviews();
});