DROP DATABASE IF EXISTS dwp;
CREATE DATABASE dwp;
USE dwp;

-- Genre Table
CREATE TABLE Genre (
    Genre_ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Description TEXT
);
INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(1, 'Action', 'This genre focuses on action and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(2, 'Westerns', 'This genre focuses on westerns and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(3, 'War', 'This genre focuses on war and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(4, 'Detectives', 'This genre focuses on detectives and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(5, 'Dramas', 'This genre focuses on dramas and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(6, 'Historical', 'This genre focuses on historical events and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(7, 'Comedies', 'This genre focuses on comedies and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(8, 'Crime', 'This genre focuses on crime and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(9, 'Melodramas', 'This genre focuses on melodramas and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(10, 'Cartoons', 'This genre focuses on cartoons and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(11, 'Adventures', 'This genre focuses on adventures and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(12, 'Thrillers', 'This genre focuses on thrillers and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(13, 'Horror', 'This genre focuses on horror and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(14, 'Sci-Fi', 'This genre focuses on sci-fi and brings thrilling experiences to the audience.');

INSERT INTO Genre (Genre_ID, Name, Description) VALUES 
(15, 'Fantasy', 'This genre focuses on fantasy and brings thrilling experiences to the audience.');


-- Version Table
CREATE TABLE Version (
    Version_ID INT PRIMARY KEY AUTO_INCREMENT,
    Format VARCHAR(50),
    AdditionalFee DECIMAL(10, 2)
);

INSERT INTO Version (Version_ID, Format, AdditionalFee) VALUES (1, '2D', 0.00);
INSERT INTO Version (Version_ID, Format, AdditionalFee) VALUES (2, '3D', 3.00);
INSERT INTO Version (Version_ID, Format, AdditionalFee) VALUES (3, 'IMAX 2D', 5.00);
INSERT INTO Version (Version_ID, Format, AdditionalFee) VALUES (4, 'IMAX 3D', 7.00);
INSERT INTO Version (Version_ID, Format, AdditionalFee) VALUES (5, '4DX', 10.00);
INSERT INTO Version (Version_ID, Format, AdditionalFee) VALUES (6, 'Dolby Cinema', 8.00);


-- Movie Table
CREATE TABLE Movie (
    Movie_ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255),
    Director VARCHAR(100),
    Language VARCHAR(50),
    Year INT,
    Duration TIME,
    Rating INT,
    Description TEXT,
    Genre_ID INT,
    Version_ID INT,
    FOREIGN KEY (Genre_ID) REFERENCES Genre(Genre_ID),
    FOREIGN KEY (Version_ID) REFERENCES Version(Version_ID)
);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(1, 'The Dark Knight', 'Christopher Nolan', 'English', 2008, '02:32:00', 9, 'A crime drama about Batman taking on the Joker.', 1, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(2, 'Inception', 'Christopher Nolan', 'English', 2010, '02:28:00', 8, 'A thriller about entering dreams within dreams.', 12, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(3, 'Toy Story', 'John Lasseter', 'English', 1995, '01:21:00', 8, 'The story of toys that come to life.', 10, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(4, 'The Good, the Bad and the Ugly', 'Sergio Leone', 'Italian', 1966, '02:41:00', 9, 'A Western about three men in search of treasure.', 2, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(5, 'Schindler''s List', 'Steven Spielberg', 'English', 1993, '03:15:00', 9, 'A historical drama about the Holocaust.', 5, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(6, 'Mad Max: Fury Road', 'George Miller', 'English', 2015, '02:00:00', 8, 'An action movie about survival in a dystopian wasteland.', 1, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(7, 'The Matrix', 'Lana Wachowski', 'English', 1999, '02:16:00', 9, 'A sci-fi thriller about an alternate reality.', 14, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(8, 'Avengers: Endgame', 'Anthony Russo', 'English', 2019, '03:01:00', 9, 'The epic conclusion of the Avengers saga.', 1, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(9, 'The Godfather', 'Francis Ford Coppola', 'English', 1972, '02:55:00', 9, 'A crime drama about the mafia.', 8, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(10, 'The Exorcist', 'William Friedkin', 'English', 1973, '02:12:00', 8, 'A horror movie about a girl possessed by a demon.', 13, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(11, 'Finding Nemo', 'Andrew Stanton', 'English', 2003, '01:40:00', 8, 'A cartoon adventure about a lost fish.', 10, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(12, 'Pulp Fiction', 'Quentin Tarantino', 'English', 1994, '02:34:00', 9, 'A crime drama about intersecting lives.', 8, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(13, 'The Lord of the Rings: The Fellowship of the Ring', 'Peter Jackson', 'English', 2001, '03:48:00', 9, 'A fantasy adventure in Middle Earth.', 15, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(14, 'Star Wars: A New Hope', 'George Lucas', 'English', 1977, '02:01:00', 9, 'A sci-fi adventure about the rebellion against the Empire.', 14, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(15, 'Jurassic Park', 'Steven Spielberg', 'English', 1993, '02:07:00', 8, 'A sci-fi thriller about a park filled with cloned dinosaurs.', 14, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(16, 'Alien', 'Ridley Scott', 'English', 1979, '01:57:00', 8, 'A sci-fi horror movie about a deadly alien creature.', 13, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(17, 'Blade Runner', 'Ridley Scott', 'English', 1982, '01:57:00', 8, 'A sci-fi movie about a dystopian future.', 14, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(18, 'The Silence of the Lambs', 'Jonathan Demme', 'English', 1991, '01:58:00', 9, 'A thriller about a young FBI agent hunting a serial killer.', 12, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(19, 'Interstellar', 'Christopher Nolan', 'English', 2014, '02:49:00', 8, 'A sci-fi adventure about space exploration.', 14, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, Genre_ID, Version_ID) VALUES 
(20, 'Forrest Gump', 'Robert Zemeckis', 'English', 1994, '02:22:00', 8, 'A drama about a man who lives through historic events.', 5, 1);


-- Payment Table
CREATE TABLE Payment (
    Payment_ID INT PRIMARY KEY AUTO_INCREMENT,
    AmountPaid DECIMAL(10, 2),
    PaymentMethod VARCHAR(50),
    PaymentDate DATE,
    PaymentStatus VARCHAR(50)
);

-- Invoice Table
CREATE TABLE Invoice (
    Invoice_ID INT PRIMARY KEY AUTO_INCREMENT,
    InvoiceDate DATE,
    AmountDue DECIMAL(10, 2),
    InvoiceStatus VARCHAR(50)
);

-- Coupon Table
CREATE TABLE Coupon (
    Coupon_ID INT PRIMARY KEY AUTO_INCREMENT,
    CouponCode VARCHAR(50),
    DiscountAmount DECIMAL(10, 2)
);

-- CinemaHall Table
CREATE TABLE CinemaHall (
    CinemaHall_ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255),
    TotalSeats INT
);

-- Screening Table
CREATE TABLE Screening (
    Screening_ID INT PRIMARY KEY AUTO_INCREMENT,
    MovieTitle VARCHAR(255),
    ShowTime TIME,
    CinemaHall_ID INT,
    FOREIGN KEY (CinemaHall_ID) REFERENCES CinemaHall(CinemaHall_ID)
);


-- Seat Table
CREATE TABLE Seat (
    Seat_ID INT PRIMARY KEY AUTO_INCREMENT,
    SeatNumber INT,
    Row INT,
    Status VARCHAR(50),
    CinemaHall_ID INT,
    FOREIGN KEY (CinemaHall_ID) REFERENCES CinemaHall(CinemaHall_ID)
);

-- Ticket Table
CREATE TABLE Ticket (
    Ticket_ID INT PRIMARY KEY AUTO_INCREMENT,
    TotalPrice DECIMAL(10, 2),
    Type VARCHAR(50),
    Screening_ID INT,
    Seat_ID INT,
    Coupon_ID INT,
    FOREIGN KEY (Screening_ID) REFERENCES Screening(Screening_ID),
    FOREIGN KEY (Seat_ID) REFERENCES Seat(Seat_ID),
    FOREIGN KEY (Coupon_ID) REFERENCES Coupon(Coupon_ID)
);

-- User Table
CREATE TABLE User (
    User_ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Email VARCHAR(100),
    TelephoneNumber INT,
    Password VARCHAR(255)
);

-- GuestUser Table
CREATE TABLE GuestUser (
    GuestUser_ID INT PRIMARY KEY AUTO_INCREMENT,
    Firstname VARCHAR(100),
    Lastname VARCHAR(100),
    Email VARCHAR(100),
    TelephoneNumber INT
);

-- Booking Table
CREATE TABLE Booking (
    Booking_ID INT PRIMARY KEY AUTO_INCREMENT,
    Movie_ID INT,
    User_ID INT,
    GuestUser_ID INT,
    BookingDate DATE,
    NumberOfTickets INT,
    PaymentStatus VARCHAR(50),
    TotalPrice DECIMAL(10, 2),
    Ticket_ID INT,
    Payment_ID INT,
    Invoice_ID INT,
    FOREIGN KEY (Movie_ID) REFERENCES Movie(Movie_ID),
    FOREIGN KEY (User_ID) REFERENCES User(User_ID),
    FOREIGN KEY (GuestUser_ID) REFERENCES GuestUser(GuestUser_ID),
    FOREIGN KEY (Ticket_ID) REFERENCES Ticket(Ticket_ID),
    FOREIGN KEY (Payment_ID) REFERENCES Payment(Payment_ID),
    FOREIGN KEY (Invoice_ID) REFERENCES Invoice(Invoice_ID)
);

-- News Table
CREATE TABLE News (
    News_ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255),
    Content TEXT,
    DatePosted DATE,
    IsFeatured BOOLEAN
);

-- Company Table
CREATE TABLE Company (
    Company_ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255),
    Description TEXT,
    OpeningHours VARCHAR(50),
    ContactInfo VARCHAR(255)
);


CREATE TABLE Admin (
    Admin_ID INT PRIMARY KEY AUTO_INCREMENT,
    Email VARCHAR(100),
    Password VARCHAR(255)
)