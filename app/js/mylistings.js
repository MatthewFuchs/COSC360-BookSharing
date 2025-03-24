document.addEventListener("DOMContentLoaded", () => {
    const searchBtn = document.getElementById("search-btn");
    const searchInput = document.getElementById("search-input");
    const resultsDiv = document.getElementById("search-results");
    const userListings = document.getElementById("user-listings");

    searchBtn.addEventListener("click", () => {
        let query = searchInput.value.trim();
        if (!query) return;

        resultsDiv.innerHTML = "Searching...";
        fetch(`https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                resultsDiv.innerHTML = "";
                if (!data.items) {
                    resultsDiv.innerHTML = "<p>No books found.</p>";
                    return;
                }

                data.items.forEach(book => {
                    let info = book.volumeInfo;
                    let title = info.title || "Unknown Title";
                    let authors = info.authors ? info.authors.join(", ") : "Unknown Author";
                    let description = info.description || "";
                    let thumbnail = info.imageLinks?.thumbnail || "images/default-book.jpg";
                    
                    thumbnail = thumbnail.replace(/^http:\/\//i, "https://");

                    let div = document.createElement("div");
                    div.className = "book";
                    div.innerHTML = `
                        <img src="${thumbnail}" alt="${title}">
                        <p><strong>${title}</strong></p>
                        <p>${authors}</p>
                        <button class="post-btn">Post for Borrowing</button>
                    `;

                    div.querySelector(".post-btn").addEventListener("click", () => {
                        fetch("php/post_listing.php", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({
                                book_id: book.id,
                                title: title,
                                author: authors,
                                thumbnail: thumbnail,
                                description: description
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                alert("Book posted successfully!");
                                loadUserListings();
                            } else {
                                alert(data.error || "Error posting book.");
                            }
                        })
                        .catch(err => {
                            console.error("Error posting:", err);
                            alert("Failed to post book.");
                        });
                    });

                    resultsDiv.appendChild(div);
                });
            })
            .catch(err => {
                console.error("Search failed:", err);
                resultsDiv.innerHTML = "<p>Failed to load books. Try again later.</p>";
            });
    });

    function loadUserListings() {
        fetch("php/get_listings.php")
            .then(res => res.json())
            .then(data => {
                userListings.innerHTML = "";
                if (!data.length) {
                    userListings.innerHTML = "<p>No listings yet.</p>";
                    return;
                }

                data.forEach(listing => {
                    let div = document.createElement("div");
                    div.className = "book";
                    div.innerHTML = `
                        <img src="${listing.thumbnail}" alt="${listing.title}">
                        <p><strong>${listing.title}</strong></p>
                        <p>${listing.author}</p>
                        <button class="remove-btn" data-id="${listing.id}">Remove</button>
                    `;

                    div.querySelector(".remove-btn").addEventListener("click", () => {
                        fetch("php/delete_listing.php", {
                            method: "DELETE",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ id: listing.id })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                div.remove();
                            } else {
                                alert("Error removing book.");
                            }
                        })
                        .catch(err => {
                            console.error("Delete failed:", err);
                            alert("Failed to remove book.");
                        });
                    });

                    userListings.appendChild(div);
                });
            })
            .catch(err => {
                console.error("Loading listings failed:", err);
                userListings.innerHTML = "<p>Error loading listings.</p>";
            });
    }

    // Load current listings on page load
    loadUserListings();
});