-- Active: 1701030521725@@127.0.0.1@3306@gestion_biblio_db
use gestion_biblio_db;

CREATE TABLE book (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100),
    author VARCHAR(50),
    genre VARCHAR(30),
    description VARCHAR(150),
    publicationYear DATE,
    totalCopies INT,
    availiable_copies INT
);

CREATE TABLE role (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50)
);

CREATE TABLE user (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fullname VARCHAR(50),
    lastname VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(255),
    phone VARCHAR(15),
    budget INT
);

CREATE TABLE roleUser (
    userId INT,
    roleId INT,
    PRIMARY KEY (userId, roleId),
    FOREIGN KEY (userId) REFERENCES user(id),
    FOREIGN KEY (roleId) REFERENCES role(id)
);

CREATE TABLE reservation (
    id INT PRIMARY KEY AUTO_INCREMENT,
    userID INT,
    bookID INT,
    description VARCHAR(100),
    reservationDate DATE,
    returnDate DATE,
    isReturned INT,
    FOREIGN KEY (userID) REFERENCES user(id),
    FOREIGN KEY (bookID) REFERENCES book(id)
);

ALTER TABLE user
MODIFY COLUMN budget FLOAT;


-- Insert data 
INSERT INTO role (name) VALUES
('Admin'),
('Librarian'),
('Member');


INSERT INTO user (fullname, lastname, email, password, phone, budget) VALUES
('John', 'Doe', 'john.doe@email.com', 'password123', '123456789', 500),
('Jane', 'Smith', 'jane.smith@email.com', 'pass456', '987654321', 300);


INSERT INTO roleUser (userId, roleId) VALUES
(1, 1),
(2, 3); 


INSERT INTO book (title, author, genre, description, publicationYear, totalCopies, availiable_copies) VALUES
('The Hitchhiker s Guide to the Galaxy', 'Douglas Adams', 'Fiction', 'A humorous science fiction series that follows the misadventures of an unwitting human', '1979-10-12', 20, 5),
('The Catcher in the Rye', 'J.D. Salinger', 'Coming-of-Age Fiction', 'A novel following the experiences of a young man in New York City', '1951-07-16', 15, 10),
('The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 'An epic fantasy adventure novel set in Middle-earth', '1937-09-21', 20, 10),
('Pride and Prejudice', 'Jane Austen', 'Classic, Romance', 'A classic novel exploring themes of love, class, and morality', '1813-01-28', 15, 8);


INSERT INTO reservation (userID, bookID, description, reservationDate, returnDate, isReturned) VALUES
(1, 1, 'Reserved for John Doe', '2023-01-15', '2023-02-01', 0),
(2, 2, 'Reserved for Jane Smith', '2023-02-01', '2023-02-15', 0);
