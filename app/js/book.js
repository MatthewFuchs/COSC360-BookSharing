let currentPage = 0;
const resultsPerPage = 18;

document.addEventListener("DOMContentLoaded", function () {

    // Load books on page load
    let bookId = window.location.search.split("=")[1];
    console.log("📚 Book ID:", bookId);
    fetchBooks(bookId);
});

// Fetch books from Google Books API
function fetchBooks(bookId) {

    //console.clear();
    console.log("🔍 Fetching Books...");

    let apiUrl = "";

    // **Final API URL**
    apiUrl = `https://www.googleapis.com/books/v1/volumes?q=isbn:${encodeURIComponent(bookId)}&printType=books&langRestrict=en`;


    fetch(apiUrl)
        .then(response => {
            console.log("🔹 API Response Status:", response.status);
            return response.json();
        })
        .then(data => {
            console.log("📄 API Response Data:", data);

            if (!data.items || data.items.length === 0) {
                throw new Error("No books found for your search.");
            }
            displayBook(data.items);
        })
        .catch(error => {
            console.error("❌ Error fetching books:", error);
        })
        .finally(() => {
            //searchStatus.style.display = "none";
        });
}
// Function to populate book information
function displayBook(books) {
    //let bookContainer = document.querySelector(".book-container");
    //bookContainer.innerHTML = "";
    books.forEach(book => {
        let info = book.volumeInfo || {};
        let thumbnail = info.imageLinks ? info.imageLinks.thumbnail : "images/default-book.jpg";
        let title = info.title || "Unknown Title";
        let authors = info.authors ? info.authors.join(", ") : "Unknown Author";

        document.querySelector(".book-title").innerHTML = title;
        document.querySelector(".book-author").innerHTML = authors;
        document.querySelector(".book-cover").src = thumbnail;

    });
}
