let currentPage = 0;
const resultsPerPage = 18;

// Google Books API doesn't have a "non-fiction" category, so we'll use "history" as the default
const nonFictionDefaultCategory = "history"; 

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("search-btn").addEventListener("click", () => fetchBooks());
    document.getElementById("category-filter").addEventListener("change", () => fetchBooks());

    document.getElementById("prev-page").addEventListener("click", prevPage);
    document.getElementById("next-page").addEventListener("click", nextPage);

    // Load books on page load
    fetchBooks("fiction");
});

// Fetch books from Google Books API
function fetchBooks(defaultQuery = "") {
    let searchQuery = document.getElementById("search-input").value.trim();
    let selectedCategory = document.getElementById("category-filter").value;
    let searchStatus = document.getElementById("search-status");

    if(!searchQuery.match(/^[A-Za-z0-9 ]*$/)) {
        alert("Please enter a valid search query.");
        return;
    }

    console.clear();
    console.log("Fetching Books...");

    // Show search status
    searchStatus.textContent = "Searching...";
    searchStatus.style.display = "block";

    let apiUrl = "";
    let categoryFilter = "";

    // ISBN Search
    if (/^\d{10,13}$/.test(searchQuery)) {
        apiUrl = `https://www.googleapis.com/books/v1/volumes?q=isbn:${searchQuery}`;
    } else {
        // Handle "non-fiction" category
        if (selectedCategory === "non-fiction") {
            categoryFilter = `+subject:${encodeURIComponent(nonFictionDefaultCategory)}`;
            searchQuery = "";
        } 
        // Handle all other categories
        else if (selectedCategory !== "all") {
            categoryFilter = `+subject:${encodeURIComponent(selectedCategory)}`;
            searchQuery = ""; 
        } 
        else {
            searchQuery = defaultQuery || searchQuery || "fiction"; // Default to fiction if empty
        }

        apiUrl = `https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(searchQuery)}${categoryFilter}&maxResults=${resultsPerPage}&printType=books&langRestrict=en&startIndex=${currentPage * resultsPerPage}`;
    }

    fetch(apiUrl)
        .then(response => {
            console.log("🔹 API Response Status:", response.status);
            return response.json();
        })
        .then(data => {
            console.log("API Response Data:", data);
            
            if (!data.items || data.items.length === 0) {
                throw new Error("No books found for your search.");
            }
            displayBooks(data.items);
            updatePaginationButtons(data.totalItems || resultsPerPage);
        })
        .catch(error => {
            console.error("Error fetching books:", error);
            document.querySelector(".book-grid").innerHTML = `<p class="no-results">${error.message}</p>`;
        })
        .finally(() => {
            searchStatus.style.display = "none";
        });
}    

// Function to display books
function displayBooks(books) {
    let bookContainer = document.querySelector(".book-grid");
    bookContainer.innerHTML = "";

    if (!books || books.length === 0) {
        bookContainer.innerHTML = `<p class="no-results">No books found. Try a different search.</p>`;
        return;
    }

    books.forEach(book => {
        let info = book.volumeInfo || {};
        let thumbnail = info.imageLinks ? info.imageLinks.thumbnail : "images/default-book.jpg";
        let title = info.title || "Unknown Title";
        let authors = info.authors ? info.authors.join(", ") : "Unknown Author";
        let bookId = book.id;
        let bookISBN = info.industryIdentifiers ? info.industryIdentifiers[0].identifier : "null";

        let bookElement = document.createElement("div");
        bookElement.classList.add("book");

        bookElement.innerHTML = `
            <img src="${thumbnail}" alt="${title}">
            <p><strong>${title}</strong></p>
            <p>by ${authors}</p>
            <a href="BookDetail.html?id=${bookISBN}">View Details</a>
        `;

        bookContainer.appendChild(bookElement);
    });
}

// Pagination Functions
function nextPage() {
    currentPage++;
    fetchBooks();
}

function prevPage() {
    if (currentPage > 0) {
        currentPage--;
        fetchBooks();
    }
}

// Update Pagination Controls
function updatePaginationButtons(totalItems) {
    document.getElementById("page-number").textContent = `Page ${currentPage + 1}`;
    document.getElementById("prev-page").disabled = currentPage === 0;

    // Disable "Next" if the last page is reached
    let totalPages = Math.ceil(totalItems / resultsPerPage);
    document.getElementById("next-page").disabled = currentPage >= totalPages - 1;
}