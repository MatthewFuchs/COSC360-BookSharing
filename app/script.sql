CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    phone_number VARCHAR(20),
    location VARCHAR(100),
    profile_image VARCHAR(255) DEFAULT 'images/default-profile.png',
    role ENUM('user', 'admin') DEFAULT 'user',
    status ENUM('enabled', 'disabled') DEFAULT 'enabled',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE borrow_listings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100),
    thumbnail TEXT,
    description TEXT,
    posted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE discussions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE replies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    discussion_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (discussion_id) REFERENCES discussions(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE messagelog (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sending_userId INT NOT NULL,
    reciv_userId INT NOT NULL,
    textmessage TEXT NOT NULL,
    timeindex DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sending_userId) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (reciv_userId) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type VARCHAR(50),
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE wishlist (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    book_id VARCHAR(255) NOT NULL,
    book_title VARCHAR(255),
    notify BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_wishlist (user_id, book_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);