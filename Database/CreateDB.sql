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
INSERT INTO CinemaHall (CinemaHall_ID, Name, TotalSeats) VALUES (1, 'Hall 1', 120);
INSERT INTO CinemaHall (CinemaHall_ID, Name, TotalSeats) VALUES (2, 'Hall 2', 150);
INSERT INTO CinemaHall (CinemaHall_ID, Name, TotalSeats) VALUES (3, 'Hall 3', 180);
INSERT INTO CinemaHall (CinemaHall_ID, Name, TotalSeats) VALUES (4, 'Hall 4', 100);
INSERT INTO CinemaHall (CinemaHall_ID, Name, TotalSeats) VALUES (5, 'Hall 5', 200);
INSERT INTO CinemaHall (CinemaHall_ID, Name, TotalSeats) VALUES (6, 'Hall 6', 220);
INSERT INTO CinemaHall (CinemaHall_ID, Name, TotalSeats) VALUES (7, 'Hall 7', 140);


-- Screening Table ? 100 
CREATE TABLE Screening (
    Screening_ID INT PRIMARY KEY AUTO_INCREMENT,
    ShowTime TIME,
    CinemaHall_ID INT,
    Movie_ID INT,
    FOREIGN KEY (CinemaHall_ID) REFERENCES CinemaHall(CinemaHall_ID),
    FOREIGN KEY (Movie_ID) REFERENCES Movie(Movie_ID)
);

-- Screenings for Hall 1
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('10:00:00', 1, 1);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('12:30:00', 1, 2);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('15:00:00', 1, 3);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('17:30:00', 1, 4);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('20:00:00', 1, 5);

-- Screenings for Hall 2
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('11:00:00', 2, 6);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('13:30:00', 2, 7);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('16:00:00', 2, 8);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('18:30:00', 2, 9);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('21:00:00', 2, 10);

-- Screenings for Hall 3
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('10:30:00', 3, 11);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('13:00:00', 3, 12);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('15:30:00', 3, 13);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('18:00:00', 3, 14);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('20:30:00', 3, 15);

-- Screenings for Hall 4
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('11:15:00', 4, 16);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('13:45:00', 4, 17);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('16:15:00', 4, 18);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('18:45:00', 4, 19);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('21:15:00', 4, 20);

-- Screenings for Hall 5
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('10:45:00', 5, 21);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('13:15:00', 5, 22);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('15:45:00', 5, 23);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('18:15:00', 5, 24);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('20:45:00', 5, 25);

-- Screenings for Hall 6
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('12:00:00', 6, 26);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('14:30:00', 6, 27);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('17:00:00', 6, 28);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('19:30:00', 6, 29);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('22:00:00', 6, 30);

-- Screenings for Hall 7
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('11:30:00', 7, 31);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('14:00:00', 7, 32);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('16:30:00', 7, 33);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('19:00:00', 7, 34);
INSERT INTO Screening (ShowTime, CinemaHall_ID, Movie_ID) VALUES ('21:30:00', 7, 35);


-- Seat Table ? 100 each
CREATE TABLE Seat (
    Seat_ID INT PRIMARY KEY AUTO_INCREMENT,
    SeatNumber INT,
    Row INT,
    CinemaHall_ID INT,
    FOREIGN KEY (CinemaHall_ID) REFERENCES CinemaHall(CinemaHall_ID)
);

-- Row 1 Hall 1
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (1, 1, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (2, 2, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (3, 3, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (4, 4, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (5, 5, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (6, 6, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (7, 7, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (8, 8, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (9, 9, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (10, 10, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (11, 11, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (12, 12, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (13, 13, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (14, 14, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (15, 15, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (16, 16, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (17, 17, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (18, 18, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (19, 19, 1, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (20, 20, 1, 1);

-- Row 2 Hall 1
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (21, 1, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (22, 2, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (23, 3, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (24, 4, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (25, 5, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (26, 6, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (27, 7, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (28, 8, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (29, 9, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (30, 10, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (31, 11, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (32, 12, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (33, 13, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (34, 14, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (35, 15, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (36, 16, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (37, 17, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (38, 18, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (39, 19, 2, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (40, 20, 2, 1);

-- Row 3 Hall 1
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (41, 1, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (42, 2, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (43, 3, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (44, 4, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (45, 5, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (46, 6, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (47, 7, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (48, 8, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (49, 9, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (50, 10, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (51, 11, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (52, 12, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (53, 13, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (54, 14, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (55, 15, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (56, 16, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (57, 17, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (58, 18, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (59, 19, 3, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (60, 20, 3, 1);

-- Row 4 Hall 1
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (61, 1, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (62, 2, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (63, 3, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (64, 4, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (65, 5, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (66, 6, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (67, 7, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (68, 8, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (69, 9, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (70, 10, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (71, 11, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (72, 12, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (73, 13, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (74, 14, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (75, 15, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (76, 16, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (77, 17, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (78, 18, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (79, 19, 4, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (80, 20, 4, 1);

-- Row 5 Hall 1
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (81, 1, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (82, 2, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (83, 3, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (84, 4, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (85, 5, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (86, 6, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (87, 7, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (88, 8, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (89, 9, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (90, 10, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (91, 11, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (92, 12, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (93, 13, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (94, 14, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (95, 15, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (96, 16, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (97, 17, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (98, 18, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (99, 19, 5, 1);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (100, 20, 5, 1);

-- Row 1 for Hall 2
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (101, 1, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (102, 2, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (103, 3, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (104, 4, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (105, 5, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (106, 6, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (107, 7, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (108, 8, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (109, 9, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (110, 10, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (111, 11, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (112, 12, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (113, 13, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (114, 14, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (115, 15, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (116, 16, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (117, 17, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (118, 18, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (119, 19, 1, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (120, 20, 1, 2);

-- Row 2 for Hall 2
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (121, 1, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (122, 2, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (123, 3, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (124, 4, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (125, 5, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (126, 6, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (127, 7, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (128, 8, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (129, 9, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (130, 10, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (131, 11, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (132, 12, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (133, 13, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (134, 14, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (135, 15, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (136, 16, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (137, 17, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (138, 18, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (139, 19, 2, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (140, 20, 2, 2);

-- Row 3 for Hall 2
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (141, 1, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (142, 2, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (143, 3, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (144, 4, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (145, 5, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (146, 6, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (147, 7, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (148, 8, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (149, 9, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (150, 10, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (151, 11, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (152, 12, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (153, 13, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (154, 14, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (155, 15, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (156, 16, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (157, 17, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (158, 18, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (159, 19, 3, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (160, 20, 3, 2);

-- Row 4 for Hall 2
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (161, 1, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (162, 2, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (163, 3, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (164, 4, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (165, 5, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (166, 6, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (167, 7, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (168, 8, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (169, 9, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (170, 10, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (171, 11, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (172, 12, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (173, 13, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (174, 14, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (175, 15, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (176, 16, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (177, 17, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (178, 18, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (179, 19, 4, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (180, 20, 4, 2);

-- Row 5 for Hall 2
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (181, 1, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (182, 2, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (183, 3, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (184, 4, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (185, 5, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (186, 6, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (187, 7, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (188, 8, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (189, 9, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (190, 10, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (191, 11, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (192, 12, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (193, 13, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (194, 14, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (195, 15, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (196, 16, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (197, 17, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (198, 18, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (199, 19, 5, 2);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (200, 20, 5, 2);

-- Row 1 for Hall 3
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (201, 1, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (202, 2, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (203, 3, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (204, 4, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (205, 5, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (206, 6, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (207, 7, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (208, 8, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (209, 9, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (210, 10, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (211, 11, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (212, 12, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (213, 13, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (214, 14, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (215, 15, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (216, 16, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (217, 17, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (218, 18, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (219, 19, 1, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (220, 20, 1, 3);

-- Row 2 for Hall 3
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (221, 1, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (222, 2, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (223, 3, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (224, 4, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (225, 5, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (226, 6, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (227, 7, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (228, 8, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (229, 9, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (230, 10, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (231, 11, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (232, 12, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (233, 13, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (234, 14, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (235, 15, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (236, 16, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (237, 17, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (238, 18, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (239, 19, 2, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (240, 20, 2, 3);

-- Row 3 for Hall 3
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (241, 1, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (242, 2, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (243, 3, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (244, 4, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (245, 5, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (246, 6, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (247, 7, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (248, 8, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (249, 9, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (250, 10, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (251, 11, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (252, 12, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (253, 13, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (254, 14, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (255, 15, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (256, 16, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (257, 17, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (258, 18, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (259, 19, 3, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (260, 20, 3, 3);

-- Row 4 for Hall 3 
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (268, 8, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (269, 9, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (270, 10, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (271, 11, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (272, 12, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (273, 13, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (274, 14, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (275, 15, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (276, 16, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (277, 17, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (278, 18, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (279, 19, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (280, 20, 4, 3);

-- Row 5 for Hall 3
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (281, 1, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (282, 2, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (283, 3, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (284, 4, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (285, 5, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (286, 6, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (287, 7, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (288, 8, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (289, 9, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (290, 10, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (291, 11, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (292, 12, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (293, 13, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (294, 14, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (295, 15, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (296, 16, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (297, 17, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (298, 18, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (299, 19, 5, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (300, 20, 5, 3);

-- Row 1 for Hall 4
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (301, 1, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (302, 2, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (303, 3, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (304, 4, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (305, 5, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (306, 6, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (307, 7, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (308, 8, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (309, 9, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (310, 10, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (311, 11, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (312, 12, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (313, 13, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (314, 14, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (315, 15, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (316, 16, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (317, 17, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (318, 18, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (319, 19, 1, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (320, 20, 1, 4);

-- Row 2 for Hall 4
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (321, 1, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (322, 2, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (323, 3, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (324, 4, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (325, 5, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (326, 6, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (327, 7, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (328, 8, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (329, 9, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (330, 10, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (331, 11, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (332, 12, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (333, 13, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (334, 14, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (335, 15, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (336, 16, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (337, 17, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (338, 18, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (339, 19, 2, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (340, 20, 2, 4);

-- Row 3 for Hall 4
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (341, 1, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (342, 2, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (343, 3, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (344, 4, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (345, 5, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (346, 6, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (347, 7, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (348, 8, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (349, 9, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (350, 10, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (351, 11, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (352, 12, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (353, 13, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (354, 14, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (355, 15, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (356, 16, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (357, 17, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (358, 18, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (359, 19, 3, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (360, 20, 3, 4);

-- Row 4 for Hall 4
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (368, 8, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (369, 9, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (370, 10, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (371, 11, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (372, 12, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (373, 13, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (374, 14, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (375, 15, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (376, 16, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (377, 17, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (378, 18, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (379, 19, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (380, 20, 4, 4);

-- Row 5 for Hall 4
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (381, 1, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (382, 2, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (383, 3, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (384, 4, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (385, 5, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (386, 6, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (387, 7, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (388, 8, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (389, 9, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (390, 10, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (391, 11, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (392, 12, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (393, 13, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (394, 14, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (395, 15, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (396, 16, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (397, 17, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (398, 18, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (399, 19, 5, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (400, 20, 5, 4);

-- Row 1 for Hall 5
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (401, 1, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (402, 2, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (403, 3, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (404, 4, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (405, 5, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (406, 6, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (407, 7, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (408, 8, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (409, 9, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (410, 10, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (411, 11, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (412, 12, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (413, 13, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (414, 14, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (415, 15, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (416, 16, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (417, 17, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (418, 18, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (419, 19, 1, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (420, 20, 1, 5);

-- Row 2 for Hall 5
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (421, 1, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (422, 2, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (423, 3, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (424, 4, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (425, 5, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (426, 6, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (427, 7, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (428, 8, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (429, 9, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (430, 10, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (431, 11, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (432, 12, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (433, 13, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (434, 14, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (435, 15, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (436, 16, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (437, 17, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (438, 18, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (439, 19, 2, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (440, 20, 2, 5);

-- Row 3 for Hall 5
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (441, 1, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (442, 2, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (443, 3, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (444, 4, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (445, 5, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (446, 6, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (447, 7, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (448, 8, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (449, 9, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (450, 10, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (451, 11, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (452, 12, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (453, 13, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (454, 14, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (455, 15, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (456, 16, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (457, 17, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (458, 18, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (459, 19, 3, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (460, 20, 3, 5);

-- Row 4 for Hall 5 
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (468, 8, 4, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (469, 9, 4, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (470, 10, 4, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (471, 11, 4, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (472, 12, 4, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (473, 13, 4, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (474, 14, 4, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (475, 15, 4, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (476, 16, 4, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (477, 17, 4, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (478, 18, 4, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (479, 19, 4, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (480, 20, 4, 5);

-- Row 5 for Hall 5
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (481, 1, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (482, 2, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (483, 3, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (484, 4, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (485, 5, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (486, 6, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (487, 7, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (488, 8, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (489, 9, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (490, 10, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (491, 11, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (492, 12, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (493, 13, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (494, 14, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (495, 15, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (496, 16, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (497, 17, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (498, 18, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (499, 19, 5, 5);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (500, 20, 5, 5);

-- Row 1 for Hall 6
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (501, 1, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (502, 2, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (503, 3, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (504, 4, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (505, 5, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (506, 6, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (507, 7, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (508, 8, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (509, 9, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (510, 10, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (511, 11, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (512, 12, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (513, 13, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (514, 14, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (515, 15, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (516, 16, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (517, 17, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (518, 18, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (519, 19, 1, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (520, 20, 1, 6);

-- Row 2 for Hall 6
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (521, 1, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (522, 2, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (523, 3, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (524, 4, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (525, 5, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (526, 6, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (527, 7, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (528, 8, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (529, 9, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (530, 10, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (531, 11, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (532, 12, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (533, 13, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (534, 14, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (535, 15, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (536, 16, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (537, 17, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (538, 18, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (539, 19, 2, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (540, 20, 2, 6);

-- Row 3 for Hall 6
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (541, 1, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (542, 2, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (543, 3, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (544, 4, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (545, 5, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (546, 6, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (547, 7, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (548, 8, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (549, 9, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (550, 10, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (551, 11, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (552, 12, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (553, 13, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (554, 14, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (555, 15, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (556, 16, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (557, 17, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (558, 18, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (559, 19, 3, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (560, 20, 3, 6);

-- Row 4 for Hall 6 
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (568, 8, 4, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (569, 9, 4, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (570, 10, 4, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (571, 11, 4, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (572, 12, 4, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (573, 13, 4, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (574, 14, 4, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (575, 15, 4, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (576, 16, 4, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (577, 17, 4, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (578, 18, 4, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (579, 19, 4, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (580, 20, 4, 6);

-- Row 5 for Hall 6
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (581, 1, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (582, 2, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (583, 3, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (584, 4, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (585, 5, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (586, 6, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (587, 7, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (588, 8, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (589, 9, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (590, 10, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (591, 11, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (592, 12, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (593, 13, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (594, 14, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (595, 15, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (596, 16, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (597, 17, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (598, 18, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (599, 19, 5, 6);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (600, 20, 5, 6);

-- Row 1 for Hall 7
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (601, 1, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (602, 2, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (603, 3, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (604, 4, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (605, 5, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (606, 6, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (607, 7, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (608, 8, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (609, 9, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (610, 10, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (611, 11, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (612, 12, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (613, 13, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (614, 14, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (615, 15, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (616, 16, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (617, 17, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (618, 18, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (619, 19, 1, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (620, 20, 1, 7);

-- Row 2 for Hall 7
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (621, 1, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (622, 2, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (623, 3, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (624, 4, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (625, 5, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (626, 6, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (627, 7, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (628, 8, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (629, 9, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (630, 10, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (631, 11, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (632, 12, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (633, 13, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (634, 14, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (635, 15, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (636, 16, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (637, 17, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (638, 18, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (639, 19, 2, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (640, 20, 2, 7);

-- Row 3 for Hall 7
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (641, 1, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (642, 2, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (643, 3, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (644, 4, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (645, 5, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (646, 6, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (647, 7, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (648, 8, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (649, 9, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (650, 10, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (651, 11, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (652, 12, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (653, 13, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (654, 14, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (655, 15, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (656, 16, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (657, 17, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (658, 18, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (659, 19, 3, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (660, 20, 3, 7);

-- Row 4 for Hall 7
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (668, 8, 4, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (669, 9, 4, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (670, 10, 4, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (671, 11, 4, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (672, 12, 4, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (673, 13, 4, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (674, 14, 4, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (675, 15, 4, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (676, 16, 4, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (677, 17, 4, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (678, 18, 4, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (679, 19, 4, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (680, 20, 4, 7);

-- Row 5 for Hall 7
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (681, 1, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (682, 2, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (683, 3, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (684, 4, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (685, 5, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (686, 6, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (687, 7, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (688, 8, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (689, 9, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (690, 10, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (691, 11, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (692, 12, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (693, 13, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (694, 14, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (695, 15, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (696, 16, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (697, 17, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (698, 18, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (699, 19, 5, 7);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (700, 20, 5, 7);



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