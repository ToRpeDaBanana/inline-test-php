CREATE DATABASE IF NOT EXISTS inline-test-php;
USE inline-test-php;

CREATE TABLE IF NOT EXISTS posts (
    id INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS comments (
    id INT PRIMARY KEY,
    post_id INT NOT NULL,
    body TEXT NOT NULL,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);
