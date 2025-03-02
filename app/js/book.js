document.addEventListener("DOMContentLoaded", function () {
    fetchBookDetails();
});

// Fetch Book Details from Google Books API
function fetchBookDetails() {
    const urlParams = new URLSearchParams(window.location.search);
    const bookId = urlParams.get("id");
    const apiUrl = `https://www.googleapis.com/books/v1/volumes/${bookId}`;

    fetch(apiUrl)
        .then(response => response.json())
        .then(book => displayBookDetails(book))
        .catch(error => console.error("Error fetching book details:", error));
}

// Display Book Details
function displayBookDetails(book) {
    const info = book.volumeInfo;
    const bookDetails = document.getElementById("book-details");

    const title = info.title || "Unknown Title";
    const authors = info.authors ? info.authors.join(", ") : "Unknown Author";
    const description = info.description
        ? `<p class="book-description">${info.description.replace(/\n/g, "<br>")}</p>`
        : "<p class='book-description'>No description available.</p>";
    const thumbnail = info.imageLinks ? info.imageLinks.thumbnail : "images/default-book.jpg";

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