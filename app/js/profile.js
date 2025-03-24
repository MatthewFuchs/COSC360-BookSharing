document.addEventListener("DOMContentLoaded", () => {
    loadProfile();
    loadWishlist();
});

function loadProfile() {
    // This should be updated later with backend integration
    document.getElementById("name").value = "Jane Doe";
    document.getElementById("email").value = "jane.doe@example.com";
    document.getElementById("phone").value = "+1 250 555 1234";
    document.getElementById("location").value = "Kelowna, BC";
}

function loadWishlist() {
    const wishlistContainer = document.getElementById("wishlist-container");

    const wishlistItems = [];

    if (wishlistItems.length === 0) {
        wishlistContainer.classList.add("empty");
        wishlistContainer.innerHTML = `
            <p>No items in your wishlist yet.</p>
            <button onclick="window.location.href='browse.html'">Browse Books</button>
        `;
    } else {
        wishlistItems.forEach(book => {
            const item = document.createElement("div");
            item.classList.add("wishlist-item");
            item.innerHTML = `
                <p><strong>${book.title}</strong></p>
                <button onclick="removeFromWishlist('${book.id}')">Remove</button>
            `;
            wishlistContainer.appendChild(item);
        });
    }
}

function removeFromWishlist(bookId) {
    alert(`Removing book ID: ${bookId} from wishlist (not implemented)`);
}