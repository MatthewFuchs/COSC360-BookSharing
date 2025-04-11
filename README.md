# BookTrade

BookTrade is a PHP-based web platform that allows users to list, borrow, and discuss books within a local community. It includes account management, messaging, wishlist tracking, notifications, and a dynamic discussion board.

---

## Tech Stack

- **Frontend:** HTML, CSS (custom + Bootstrap), JavaScript
- **Backend:** PHP (server-side logic), MySQL (database)
- **External APIs:** Google Books API (for book info)
- **Tools:** XAMPP (local dev), GitHub, FileZilla/SSH (for deployment)

---

## Features

### User Functionality
- Register, log in, and update profiles (including profile image uploads)
- Add books to wishlist and receive notifications when they become available
- Browse and search books using the Google Books API
- List books for borrowing, complete with image and owner
- View borrow listings from other users
- Send and receive messages (chat-style messaging)
- Access and participate in a discussion board

### Admin Functionality
- Manage users and listings
- Moderate discussions and reports

### Notifications
- Triggered when a wished-for book is listed
- Shown in the notifications page

### Asynchronous Updates
- Fetch messages, wishlists, and listings using AJAX
- No full page reloads required

---

## Database Structure

### Users
- `id`, `email`, `full_name`, `password`, `phone_number`, `location`, `profile_image`

### Borrow Listings
- `id`, `user_id`, `book_id`, `title`, `author`, `thumbnail`, `timestamp`

### Wishlist
- `id`, `user_id`, `book_id`, `book_title`

### Messages (`messagelog`)
- `id`, `sending_userId`, `reciv_userId`, `textmessage`, `timeindex`

### Discussions
- `id`, `user_id`, `title`, `content`, `timestamp`

### Replies
- `id`, `discussion_id`, `user_id`, `message`, `timestamp`

---

## Deployment

This project is deployed to the UBC COSC360 student server: https://cosc360.ok.ubc.ca/mfuchs02/COSC360-BookSharing/app/index.php 
