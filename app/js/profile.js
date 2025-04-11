document.addEventListener("DOMContentLoaded", () => {
    loadWishlist();
});

function loadWishlist() {
    fetch("php/get_wishlist.php")
        .then(res => res.json())
        .then(wishlistItems => {
            const container = document.getElementById("wishlist-container");
            container.innerHTML = "";

            if (!wishlistItems.length) {
                container.classList.add("empty");
                container.innerHTML = `
                    <p>No items in your wishlist yet.</p>
                    <button onclick="window.location.href='browse.php'">Browse Books</button>
                `;
                return;
            }

            wishlistItems.forEach(book => {
                const item = document.createElement("div");
                item.className = "wishlist-item";
                item.innerHTML = `
                    <p><strong>${book.book_title}</strong></p>
                    <button onclick="removeFromWishlist('${book.book_id}')">Remove</button>
                `;
                container.appendChild(item);
            });
        })
        .catch(err => {
            console.error("Failed to load wishlist:", err);
            document.getElementById("wishlist-container").innerHTML = "<p>Could not load wishlist.</p>";
        });
}

function removeFromWishlist(bookId) {
    fetch("php/remove_from_wishlist.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `book_id=${encodeURIComponent(bookId)}`
    })
    .then(res => res.text())
    .then(response => {
        alert(response);
        loadWishlist();
    })
    .catch(err => {
        console.error("Error removing wishlist item:", err);
        alert("Something went wrong while removing the book.");
    });
}