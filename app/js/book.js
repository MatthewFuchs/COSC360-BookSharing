document.addEventListener("DOMContentLoaded", () => {
    fetchBookDetails();
});

// Fetch book details and matching listings
function fetchBookDetails() {
    const urlParams = new URLSearchParams(window.location.search);
    const bookId = urlParams.get("id");
    const apiUrl = `https://www.googleapis.com/books/v1/volumes/${bookId}`;

    fetch(apiUrl)
        .then(response => response.json())
        .then(book => {
            displayBookDetails(book);
            fetchBorrowListings(book.id);
        })
        .catch(error => console.error("Error fetching book details:", error));
}

function displayBookDetails(book) {
    const info = book.volumeInfo;
    const bookDetails = document.getElementById("book-details");

    const title = info.title || "Unknown Title";
    const authors = info.authors ? info.authors.join(", ") : "Unknown Author";
    const description = info.description
        ? `<p class="book-description">${info.description.replace(/\n/g, "<br>")}</p>`
        : "<p class='book-description'>No description available.</p>";
    const thumbnail = info.imageLinks?.thumbnail || "images/default-book.jpg";

    bookDetails.innerHTML = `
        <div class="book-info">
            <img src="${thumbnail}" alt="${title}">
            <div class="book-text">
                <p class="book-title">${title}</p>
                <p class="book-author">by ${authors}</p>
                ${description}
            </div>
        </div>
    `;
}

function fetchBorrowListings(bookId) {
    fetch(`php/get_book_listings.php?book_id=${encodeURIComponent(bookId)}`)
        .then(res => res.json())
        .then(data => displayBorrowListings(data))
        .catch(error => console.error("Failed to load listings", error));
}

function displayBorrowListings(listings) {
    const section = document.getElementById("borrow-listings");
    section.innerHTML = "";

    if (!listings.length) {
        section.innerHTML = "<p>No one has listed this book for borrowing yet.</p>";
        return;
    }

    listings.forEach(item => {
        const div = document.createElement("div");
        div.className = "borrow-card";
        div.innerHTML = `
            <img src="${item.thumbnail}" alt="${item.title}">
            <div class="borrow-info">
                <p><strong>${item.title}</strong> by ${item.author}</p>
                <p>Listed by <strong>${item.username}</strong></p>
                ${isLoggedIn ? `<a href="message.php?to=${item.user_id}" class="message-btn">Message</a>` : `<p><em><a href="login.php">Log in</a> to message.</em></p>`}
            </div>
        `;
        section.appendChild(div);
    });
}