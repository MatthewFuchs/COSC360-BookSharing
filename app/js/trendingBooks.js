const resultsPerPage = 10;
let currentPage = 0;

document.addEventListener("DOMContentLoaded", function () {
    
    // Load books on page load
    fetchBooks("fiction");

});

let recentLikesReviews = [
    { likes: "34", reviews: "10", user: "Dave", rating: "⭐⭐⭐⭐⭐", comment: "Thrilling!" },
    { likes: "30", reviews: "9", user: "Emma", rating: "⭐⭐⭐⭐", comment: "A great adventure story." },
    { likes: "27", reviews: "8", user: "Bob", rating: "⭐⭐⭐⭐⭐", comment: "Couldn't put it down." },
    { likes: "25", reviews: "7", user: "Sally", rating: "⭐⭐⭐⭐⭐", comment: "Couldn't put it down." },
    { likes: "22", reviews: "6", user: "Frank", rating: "⭐⭐⭐⭐⭐", comment: "Real page turner." },
    { likes: "20", reviews: "5", user: "Billy", rating: "⭐⭐⭐⭐⭐", comment: "Loved it." },
    { likes: "20", reviews: "4", user: "Sam", rating: "⭐⭐⭐⭐⭐", comment: "Best book I read all year!" },
    { likes: "18", reviews: "3", user: "Bart", rating: "⭐⭐⭐⭐⭐", comment: "I cried so much" },
    { likes: "17", reviews: "2", user: "Liz", rating: "⭐⭐⭐⭐⭐", comment: "Incredibly good." },
    { likes: "10", reviews: "1", user: "Izzy", rating: "⭐⭐⭐⭐⭐", comment: "Addicting read." }
];
let curBook = 0;

// Fetch books from Google Books API
function fetchBooks(defaultQuery = "") {
    let searchQuery = "";
    let selectedCategory = "fiction";
    let searchStatus = document.getElementById("search-status");

    console.clear();
    console.log("🔍 Fetching Books...");

    // Show search status
    searchStatus.textContent = "Searching...";
    searchStatus.style.display = "block";

    let apiUrl = "";
    let categoryFilter = "";

    if (/^\d{10,13}$/.test(searchQuery)) {
        // **ISBN Search**
        apiUrl = `https://www.googleapis.com/books/v1/volumes?q=isbn:${searchQuery}`;
    } else {
        // **Handling Categories**
        if (selectedCategory === "non-fiction") {
            // **Fixed, consistent category for non-fiction**
            categoryFilter = `+subject:${encodeURIComponent(nonFictionDefaultCategory)}`;
            searchQuery = "";
        }
        else if (selectedCategory !== "all") {
            categoryFilter = `+subject:${encodeURIComponent(selectedCategory)}`;
            searchQuery = "";
        }
        else {
            searchQuery = defaultQuery || searchQuery || "fiction"; // Default to fiction if empty
        }

        // **Final API URL**
        apiUrl = `https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(searchQuery)}${categoryFilter}&maxResults=${resultsPerPage}&printType=books&langRestrict=en&startIndex=${currentPage * resultsPerPage}`;
    }

    fetch(apiUrl)
        .then(response => {
            console.log("API Response Status:", response.status);
            return response.json();
        })
        .then(data => {
            console.log("API Response Data:", data);

            if (!data.items || data.items.length === 0) {
                throw new Error("No books found for your search.");
            }
            displayBooks(data.items);
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
            <p>#${curBook + 1}</p>

            <img src="${thumbnail}" alt="${title}">
            <p><strong>${title}</strong><br>
            by ${authors}</p>

            <p>Recent Likes: ${recentLikesReviews[curBook].likes}<br>
            Recent Reviews: ${recentLikesReviews[curBook].reviews}</p>
            <p>Most Recent Review: ${recentLikesReviews[curBook].rating} ${recentLikesReviews[curBook].user} says &quot${recentLikesReviews[curBook].comment}&quot</p>
            <a href="BookDetail.html?id=${bookISBN}">View Details</a>
        `;

        bookContainer.appendChild(bookElement);
        curBook++;
    });
}