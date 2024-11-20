DROP DATABASE IF EXISTS c5di1yb93_dwp;
CREATE DATABASE c5di1yb93_dwp;
USE c5di1yb93_dwp;

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
    TrailerLink VARCHAR(255),
    Genre_ID INT,
    Version_ID INT,
    FOREIGN KEY (Genre_ID) REFERENCES Genre(Genre_ID),
    FOREIGN KEY (Version_ID) REFERENCES Version(Version_ID)
);
INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(1, 'The Dark Knight', 'Christopher Nolan', 'English', 2008, '02:32:00', 9, 'A crime drama about Batman taking on the Joker.', 'https://www.youtube.com/watch?v=EXeTwQWrcwY', 1, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(2, 'Inception', 'Christopher Nolan', 'English', 2010, '02:28:00', 8, 'A thriller about entering dreams within dreams.', 'https://www.youtube.com/watch?v=YoHD9XEInc0', 12, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(3, 'Toy Story', 'John Lasseter', 'English', 1995, '01:21:00', 8, 'The story of toys that come to life.', 'https://www.youtube.com/watch?v=KYz2wyBy3kc', 10, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(4, 'The Good, the Bad and the Ugly', 'Sergio Leone', 'Italian', 1966, '02:41:00', 9, 'A Western about three men in search of treasure.', 'https://www.youtube.com/watch?v=H-8AzDPe0g0', 2, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(5, 'Schindler''s List', 'Steven Spielberg', 'English', 1993, '03:15:00', 9, 'A historical drama about the Holocaust.', 'https://www.youtube.com/watch?v=JdQ8fB0C1gI', 5, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(6, 'Mad Max: Fury Road', 'George Miller', 'English', 2015, '02:00:00', 8, 'An action movie about survival in a dystopian wasteland.', 'https://www.youtube.com/watch?v=hEJnMQG9ev8', 1, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(7, 'The Matrix', 'Lana Wachowski', 'English', 1999, '02:16:00', 9, 'A sci-fi thriller about an alternate reality.', 'https://www.youtube.com/watch?v=vKQi0Ph9zI8', 14, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(8, 'Avengers: Endgame', 'Anthony Russo', 'English', 2019, '03:01:00', 9, 'The epic conclusion of the Avengers saga.', 'https://www.youtube.com/watch?v=TcMBFSGVi1c', 1, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(9, 'The Godfather', 'Francis Ford Coppola', 'English', 1972, '02:55:00', 9, 'A crime drama about the mafia.', 'https://www.youtube.com/watch?v=sY1S34973zA', 8, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(10, 'The Exorcist', 'William Friedkin', 'English', 1973, '02:12:00', 8, 'A horror movie about a girl possessed by a demon.', 'https://www.youtube.com/watch?v=YDGw2lTEsU4', 13, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(11, 'Finding Nemo', 'Andrew Stanton', 'English', 2003, '01:40:00', 8, 'A cartoon adventure about a lost fish.', 'https://www.youtube.com/watch?v=wZdpNglLbt8', 10, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(12, 'Pulp Fiction', 'Quentin Tarantino', 'English', 1994, '02:34:00', 9, 'A crime drama about intersecting lives.', 'https://www.youtube.com/watch?v=wZ7qR1Y5yX0', 8, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(13, 'The Lord of the Rings: The Fellowship of the Ring', 'Peter Jackson', 'English', 2001, '03:48:00', 9, 'A fantasy adventure in Middle Earth.', 'https://www.youtube.com/watch?v=V75dMMIW2B4', 15, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(14, 'Star Wars: A New Hope', 'George Lucas', 'English', 1977, '02:01:00', 9, 'A sci-fi adventure about the rebellion against the Empire.', 'https://www.youtube.com/watch?v=1g3_CFmnU7I', 14, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(15, 'Jurassic Park', 'Steven Spielberg', 'English', 1993, '02:07:00', 8, 'A sci-fi thriller about a park filled with cloned dinosaurs.', 'https://www.youtube.com/watch?v=lc0UehYemQA', 14, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(16, 'Alien', 'Ridley Scott', 'English', 1979, '01:57:00', 8, 'A sci-fi horror movie about a deadly alien creature.', 'https://www.youtube.com/watch?v=LjLamj-b0I4', 13, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(17, 'Blade Runner', 'Ridley Scott', 'English', 1982, '01:57:00', 8, 'A sci-fi movie about a dystopian future.', 'https://www.youtube.com/watch?v=1jP1A7FbT3M', 14, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(18, 'The Silence of the Lambs', 'Jonathan Demme', 'English', 1991, '01:58:00', 9, 'A thriller about a young FBI agent hunting a serial killer.', 'https://www.youtube.com/watch?v=R1zI3C8a6to', 12, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(19, 'Interstellar', 'Christopher Nolan', 'English', 2014, '02:49:00', 8, 'A sci-fi adventure about space exploration.', 'https://www.youtube.com/watch?v=zSWdZVtXT7E', 14, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(20, 'Forrest Gump', 'Robert Zemeckis', 'English', 1994, '02:22:00', 8, 'A drama about a man who lives through historic events.', 'https://www.youtube.com/watch?v=bLvqoHBptjg', 5, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(21, 'Gladiator', 'Ridley Scott', 'English', 2000, '02:35:00', 8, 'A historical drama about a Roman general turned gladiator.', 'https://www.youtube.com/watch?v=owK1qxDselE', 5, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(22, 'The Shawshank Redemption', 'Frank Darabont', 'English', 1994, '02:22:00', 9, 'A drama about two men in prison.', 'https://www.youtube.com/watch?v=6hB0d_xzH8o', 5, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(23, 'Black Panther', 'Ryan Coogler', 'English', 2018, '02:14:00', 8, 'A superhero movie about the king of Wakanda.', 'https://www.youtube.com/watch?v=xjDjIWPwcPU', 1, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(24, 'Fight Club', 'David Fincher', 'English', 1999, '02:19:00', 8, 'A drama about a secret fight club.', 'https://www.youtube.com/watch?v=SUXWAu6l1i8', 8, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(25, 'The Lion King', 'Roger Allers', 'English', 1994, '01:28:00', 8, 'An animated movie about a young lion prince.', 'https://www.youtube.com/watch?v=4sj1MT05l4I', 10, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(26, 'The Departed', 'Martin Scorsese', 'English', 2006, '02:31:00', 8, 'A crime thriller about an undercover cop and a mole in the police.', 'https://www.youtube.com/watch?v=auq0C1n5rjA', 8, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(27, 'Harry Potter and the Sorcerer''s Stone', 'Chris Columbus', 'English', 2001, '02:32:00', 7, 'A fantasy movie about a young wizard.', 'https://www.youtube.com/watch?v=VyHV0BRtdxo', 15, 2);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(28, '12 Angry Men', 'Sidney Lumet', 'English', 1957, '01:36:00', 9, 'A courtroom drama about a jury deliberating a murder trial.', 'https://www.youtube.com/watch?v=haP8dy4_3cA', 5, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(29, 'Braveheart', 'Mel Gibson', 'English', 1995, '03:02:00', 8, 'A historical epic about William Wallace.', 'https://www.youtube.com/watch?v=IY0XIH8ZPzo', 5, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(30, 'The Terminator', 'James Cameron', 'English', 1984, '01:47:00', 8, 'A sci-fi movie about a killer robot from the future.', 'https://www.youtube.com/watch?v=k64pq2N9h4Q', 14, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(31, 'Rocky', 'John G. Avildsen', 'English', 1976, '02:00:00', 8, 'A drama about a boxer''s rise to fame.', 'https://www.youtube.com/watch?v=5M2n1qGZVfA', 12, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(32, 'A Beautiful Mind', 'Ron Howard', 'English', 2001, '02:15:00', 8, 'A drama about the life of John Nash.', 'https://www.youtube.com/watch?v=1X5L_UF7-Ho', 5, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(33, 'Casablanca', 'Michael Curtiz', 'English', 1942, '01:42:00', 9, 'A drama about love and sacrifice during World War II.', 'https://www.youtube.com/watch?v=B38G2l3dclE', 5, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(34, 'The Shining', 'Stanley Kubrick', 'English', 1980, '02:26:00', 8, 'A horror movie about a haunted hotel.', 'https://www.youtube.com/watch?v=5Cb3ik6zP2I', 13, 1);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID) VALUES 
(35, 'Indiana Jones and the Last Crusade', 'Steven Spielberg', 'English', 1989, '02:07:00', 8, 'An adventure movie about the search for the Holy Grail.', 'https://www.youtube.com/watch?v=OeR2JbI-Lbo', 11, 1);



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
    DiscountAmount DECIMAL(10, 2),
    ExpireDate DATE
);

INSERT INTO Coupon (Coupon_ID, CouponCode, DiscountAmount, ExpireDate)
VALUES (1, 'SUMMER2024', 20.00, '2025-08-15');

INSERT INTO Coupon (Coupon_ID, CouponCode, DiscountAmount, ExpireDate)
VALUES (2, 'WINTER2024', 25.00, '2025-12-31');

INSERT INTO Coupon (Coupon_ID, CouponCode, DiscountAmount, ExpireDate)
VALUES (3, 'SPRING2025', 30.00, '2025-04-10');

INSERT INTO Coupon (Coupon_ID, CouponCode, DiscountAmount, ExpireDate)
VALUES (4, 'FALL2025', 50.00, '2025-09-30');

INSERT INTO Coupon (Coupon_ID, CouponCode, DiscountAmount, ExpireDate)
VALUES (5, 'HOLIDAY2025', 35.00, '2025-12-25');


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


-- Screening Table ? 35
CREATE TABLE Screening (
    Screening_ID INT PRIMARY KEY AUTO_INCREMENT,
    ShowDate DATE,  
    ShowTime TIME,
    CinemaHall_ID INT,  
    Movie_ID INT,  
    FOREIGN KEY (CinemaHall_ID) REFERENCES CinemaHall(CinemaHall_ID) ON DELETE CASCADE,
    FOREIGN KEY (Movie_ID) REFERENCES Movie(Movie_ID) ON DELETE CASCADE
);

INSERT INTO Screening (Screening_ID, ShowDate, ShowTime, CinemaHall_ID, Movie_ID) VALUES
-- Week 1: 2024-11-18 to 2024-11-24
(1, '2024-11-18', '10:00:00', 1, 1),
(2, '2024-11-18', '13:00:00', 1, 2),
(3, '2024-11-18', '16:00:00', 1, 3),
(4, '2024-11-18', '19:00:00', 1, 4),
(5, '2024-11-18', '10:15:00', 2, 5),
(6, '2024-11-18', '13:45:00', 2, 6),
(7, '2024-11-18', '16:30:00', 2, 7),
(8, '2024-11-18', '19:00:00', 2, 1),
(9, '2024-11-18', '11:00:00', 3, 2),
(10, '2024-11-18', '14:00:00', 3, 3),
(11, '2024-11-18', '17:30:00', 3, 4),
(12, '2024-11-18', '20:30:00', 3, 5),
(13, '2024-11-18', '10:30:00', 4, 6),
(14, '2024-11-18', '13:30:00', 4, 7),
(15, '2024-11-18', '16:30:00', 4, 1),

(16, '2024-11-19', '10:00:00', 1, 2),
(17, '2024-11-19', '13:00:00', 1, 3),
(18, '2024-11-19', '16:00:00', 1, 4),
(19, '2024-11-19', '19:00:00', 1, 5),
(20, '2024-11-19', '10:15:00', 2, 6),
(21, '2024-11-19', '13:45:00', 2, 7),
(22, '2024-11-19', '16:30:00', 2, 1),
(23, '2024-11-19', '19:00:00', 2, 2),
(24, '2024-11-19', '11:00:00', 3, 3),
(25, '2024-11-19', '14:00:00', 3, 4),
(26, '2024-11-19', '17:30:00', 3, 5),
(27, '2024-11-19', '20:30:00', 3, 6),
(28, '2024-11-19', '10:30:00', 4, 7),
(29, '2024-11-19', '13:30:00', 4, 1),
(30, '2024-11-19', '16:30:00', 4, 2),

(31, '2024-11-20', '10:00:00', 1, 3),
(32, '2024-11-20', '13:00:00', 1, 4),
(33, '2024-11-20', '16:00:00', 1, 5),
(34, '2024-11-20', '19:00:00', 1, 6),
(35, '2024-11-20', '10:15:00', 2, 7),
(36, '2024-11-20', '13:45:00', 2, 1),
(37, '2024-11-20', '16:30:00', 2, 2),
(38, '2024-11-20', '19:00:00', 2, 3),
(39, '2024-11-20', '11:00:00', 3, 4),
(40, '2024-11-20', '14:00:00', 3, 5),
(41, '2024-11-20', '17:30:00', 3, 6),
(42, '2024-11-20', '20:30:00', 3, 7),
(43, '2024-11-20', '10:30:00', 4, 1),
(44, '2024-11-20', '13:30:00', 4, 2),
(45, '2024-11-20', '16:30:00', 4, 3),
(46, '2024-11-21', '10:00:00', 1, 4),
(47, '2024-11-21', '13:00:00', 1, 5),
(48, '2024-11-21', '16:00:00', 1, 6),
(49, '2024-11-21', '19:00:00', 1, 7),
(50, '2024-11-21', '10:15:00', 2, 1),
(51, '2024-11-21', '13:45:00', 2, 2),
(52, '2024-11-21', '16:30:00', 2, 3),
(53, '2024-11-21', '19:00:00', 2, 4),
(54, '2024-11-21', '11:00:00', 3, 5),
(55, '2024-11-21', '14:00:00', 3, 6),
(56, '2024-11-21', '17:30:00', 3, 7),
(57, '2024-11-21', '20:30:00', 3, 1),
(58, '2024-11-21', '10:30:00', 4, 2),
(59, '2024-11-21', '13:30:00', 4, 3),
(60, '2024-11-21', '16:30:00', 4, 4),

(61, '2024-11-22', '10:00:00', 1, 5),
(62, '2024-11-22', '13:00:00', 1, 6),
(63, '2024-11-22', '16:00:00', 1, 7),
(64, '2024-11-22', '19:00:00', 1, 1),
(65, '2024-11-22', '10:15:00', 2, 2),
(66, '2024-11-22', '13:45:00', 2, 3),
(67, '2024-11-22', '16:30:00', 2, 4),
(68, '2024-11-22', '19:00:00', 2, 5),
(69, '2024-11-22', '11:00:00', 3, 6),
(70, '2024-11-22', '14:00:00', 3, 7),
(71, '2024-11-22', '17:30:00', 3, 1),
(72, '2024-11-22', '20:30:00', 3, 2),
(73, '2024-11-22', '10:30:00', 4, 3),
(74, '2024-11-22', '13:30:00', 4, 4),
(75, '2024-11-22', '16:30:00', 4, 5),
(76, '2024-11-23', '10:00:00', 1, 6),
(77, '2024-11-23', '13:00:00', 1, 7),
(78, '2024-11-23', '16:00:00', 1, 1),
(79, '2024-11-23', '19:00:00', 1, 2),
(80, '2024-11-23', '10:15:00', 2, 3),
(81, '2024-11-23', '13:45:00', 2, 4),
(82, '2024-11-23', '16:30:00', 2, 5),
(83, '2024-11-23', '19:00:00', 2, 6),
(84, '2024-11-23', '11:00:00', 3, 7),
(85, '2024-11-23', '14:00:00', 3, 1),
(86, '2024-11-23', '17:30:00', 3, 2),
(87, '2024-11-23', '20:30:00', 3, 3),
(88, '2024-11-23', '10:30:00', 4, 4),
(89, '2024-11-23', '13:30:00', 4, 5),
(90, '2024-11-23', '16:30:00', 4, 6),
(91, '2024-11-24', '10:00:00', 1, 7),
(92, '2024-11-24', '13:00:00', 1, 1),
(93, '2024-11-24', '16:00:00', 1, 2),
(94, '2024-11-24', '19:00:00', 1, 3),
(95, '2024-11-24', '10:15:00', 2, 4),
(96, '2024-11-24', '13:45:00', 2, 5),
(97, '2024-11-24', '16:30:00', 2, 6),
(98, '2024-11-24', '19:00:00', 2, 7),
(99, '2024-11-24', '11:00:00', 3, 1),
(100, '2024-11-24', '14:00:00', 3, 2),
(101, '2024-11-24', '17:30:00', 3, 3),
(102, '2024-11-24', '20:30:00', 3, 4),
(103, '2024-11-24', '10:30:00', 4, 5),
(104, '2024-11-24', '13:30:00', 4, 6),
(105, '2024-11-24', '16:30:00', 4, 7);


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
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (261, 1, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (262, 2, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (263, 3, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (264, 4, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (265, 5, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (266, 6, 4, 3);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (267, 7, 4, 3);
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
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (361, 1, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (362, 2, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (363, 3, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (364, 4, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (365, 5, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (366, 6, 4, 4);
INSERT INTO Seat (Seat_ID, SeatNumber, Row, CinemaHall_ID) VALUES (367, 7, 4, 4);
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



-- Ticket Price Table
CREATE TABLE TicketPrice (
    Price_ID INT PRIMARY KEY AUTO_INCREMENT,
    Type VARCHAR(50),  
    Price DECIMAL(10, 2),
    ValidFrom DATE,
    ValidTo DATE
);

INSERT INTO TicketPrice (Type, Price, ValidFrom, ValidTo)
VALUES
('Standard', 135.00, NULL, NULL),
('Child', 100.00, NULL, NULL),
('Senior', 110.00, NULL, NULL),
('VIP', 200.00, NULL, NULL),
('Weekend Special', 120.00, '2024-12-01', '2024-12-31');  



-- Modified Ticket Table
CREATE TABLE Ticket (
    Ticket_ID INT PRIMARY KEY AUTO_INCREMENT,
    Screening_ID INT,
    Seat_ID INT,
    Price_ID INT,
    Coupon_ID INT,
    FOREIGN KEY (Screening_ID) REFERENCES Screening(Screening_ID),
    FOREIGN KEY (Seat_ID) REFERENCES Seat(Seat_ID),
    FOREIGN KEY (Price_ID) REFERENCES TicketPrice(Price_ID),
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
    DatePosted DATE
);

INSERT INTO News (News_ID, Title, Content, DatePosted) VALUES 
(1, 'Blockbuster Release: ''The Last Adventure''', 'This weekend, cinema-goers will be treated to the much-anticipated release of ''The Last Adventure,'' directed by acclaimed filmmaker Sarah Johnson. The film promises to deliver breathtaking visuals and an engaging story that keeps audiences on the edge of their seats. Don’t miss it!', '2024-10-28');

INSERT INTO News (News_ID, Title, Content, DatePosted) VALUES 
(2, 'Film Festival Highlights: A Celebration of Indie Cinema', 'The annual Indie Film Festival kicks off this Friday, showcasing a selection of groundbreaking films from emerging filmmakers. With workshops, panels, and screenings, this festival is a must-visit for cinephiles and aspiring artists alike.', '2024-10-29');

INSERT INTO News (News_ID, Title, Content, DatePosted) VALUES 
(3, 'Oscar Buzz: Early Favorites for 2025', 'As awards season approaches, industry insiders are already discussing the frontrunners for the 2025 Academy Awards. Films like ''Echoes of Time'' and ''Silent Whispers'' have garnered significant acclaim, setting the stage for an exciting race.', '2024-10-30');

INSERT INTO News (News_ID, Title, Content, DatePosted) VALUES 
(4, 'Behind the Scenes: Making ''Mystery of the Lost Treasure''', 'Get a sneak peek behind the scenes of the upcoming adventure film ''Mystery of the Lost Treasure.'' We explore the creative process, the talented cast, and the breathtaking locations that bring this thrilling story to life.', '2024-10-27');

INSERT INTO News (News_ID, Title, Content, DatePosted) VALUES 
(5, 'Iconic Film Remake: ''The Phantom Opera'' Returns', 'Fans of classic cinema are in for a treat as ''The Phantom Opera'' is set to be remade with a fresh twist. The film will feature a star-studded cast and modern music, promising to capture the essence of the original while appealing to a new generation.', '2024-10-25');


-- Company Table
CREATE TABLE Company (
    Company_ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255),
    Description TEXT,
    OpeningHours VARCHAR(100),
    Email VARCHAR(255),
    Location VARCHAR(255)
); 
-- Insert data into Company table for FilmFusion cinema with a detailed description
INSERT INTO Company (Company_ID, Name, Description, OpeningHours, Email, Location)
VALUES 
('1',
 'FilmFusion', 
 'FilmFusion is your destination for an unparalleled cinema experience, blending the latest technology with a warm, welcoming ambiance. Located in the heart of MovieTown, FilmFusion features a mix of blockbuster films, independent cinema, and exclusive screenings that cater to all tastes. Our venue boasts luxurious reclining seats, advanced Dolby Atmos surround sound, and crystal-clear 4K projection in every theater. With spacious aisles, gourmet concessions, and a dedicated lounge for VIP members, FilmFusion transforms moviegoing into a memorable event. Our team is committed to exceptional service, ensuring each guest feels like a star. Whether you\'re here for a family outing, a date night, or a solo escape into the magic of film, FilmFusion offers a viewing experience that\'s both comfortable and captivating. Join us for seasonal film festivals, midnight premieres, and our signature “Retro Movie Nights” that celebrate the classics. FilmFusion—where the magic of cinema comes alive.',
 'Mon-Fri: 10:00 AM - 11:00 PM; Sat-Sun: 9:00 AM - 12:00 AM', 
 'contact@filmfusion.com', 
 '123 Cinema Street, MovieTown, MT 12345');



CREATE TABLE Admin (
    Admin_ID INT PRIMARY KEY AUTO_INCREMENT,
    Email VARCHAR(100),
    Password VARCHAR(255)
);

-- Media Table
CREATE TABLE Media (
    Media_ID INT PRIMARY KEY AUTO_INCREMENT,
    FileName VARCHAR(255),
    UploadAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    IsFeatured BOOLEAN DEFAULT 0,
    `Format` ENUM('jpg', 'png') NOT NULL,
    Movie_ID INT DEFAULT NULL,
    News_ID INT DEFAULT NULL,
    FOREIGN KEY (Movie_ID) REFERENCES Movie(Movie_ID) ON DELETE CASCADE,
    FOREIGN KEY (News_ID) REFERENCES News(News_ID) ON DELETE CASCADE,
    CHECK ((Movie_ID IS NOT NULL AND News_ID IS NULL) OR (Movie_ID IS NULL AND News_ID IS NOT NULL))
);


-- Inserting data into Media Table
INSERT INTO Media (Media_ID, FileName, UploadAt, IsFeatured, Format, Movie_ID, News_ID) VALUES
(1, '979a6575f6a496682a0b69ff2a5993e4.jpg', '2024-11-15 14:00:14', 0, 'jpg', NULL, 1),
(2, '44c64ccf7fdfdebe5be61b73a74371cb.jpg', '2024-11-15 14:07:16', 0, 'jpg', NULL, 2),
(3, 'b0eb6fef1fdc205c5942a48911a6eb63.jpg', '2024-11-15 14:07:49', 0, 'jpg', NULL, 3),
(4, '3d77bbf031df90963c843b47243bae8b.jpg', '2024-11-15 14:08:31', 0, 'jpg', NULL, 4),
(5, '6dd7df067727d698f3eaac28e56847c2.png', '2024-11-15 14:10:42', 0, 'png', NULL, 5);
INSERT INTO media (Media_ID, FileName, UploadAt, IsFeatured, Format, Movie_ID, News_ID) VALUES
(6, 'ed10d9830d9f17a1bcbd932fb153bb03.jpg', '2024-11-20 12:17:52', 1, 'jpg', 35, NULL),
(7, '6043a7285eb367996b0d792cbf8f4e5a.jpg', '2024-11-20 12:18:27', 1, 'jpg', 34, NULL),
(8, '2d31d140fe3ca1789cccb37b53c115c8.jpg', '2024-11-20 12:19:06', 1, 'jpg', 33, NULL),
(9, 'ab573415e2e4c5d8256685f53487bf2e.jpg', '2024-11-20 12:19:27', 1, 'jpg', 32, NULL),
(10, 'd29b28ff78e2a88672e935092b19b1d9.png', '2024-11-20 12:19:51', 1, 'png', 31, NULL),
(11, 'aa7e1b655fbf10536b0817f432eb9c57.jpg', '2024-11-20 12:20:16', 1, 'jpg', 30, NULL),
(12, '4924ce5cddb16eba29a3194533f07320.jpg', '2024-11-20 12:20:38', 1, 'jpg', 29, NULL),
(13, '84759a7ac8b79d3bfa9ab2cd6dafd9c8.jpg', '2024-11-20 12:21:03', 1, 'jpg', 28, NULL),
(14, '00b8955d243716c8da3451b67fa9d18c.jpg', '2024-11-20 12:21:23', 1, 'jpg', 27, NULL),
(15, '5061d6e46fd88979bca2a4acd3ba5997.jpg', '2024-11-20 12:21:49', 1, 'jpg', 26, NULL),
(16, '472cbb7294bbc46ed0b5cec8c085172a.png', '2024-11-20 12:22:44', 1, 'png', 25, NULL),
(17, 'c9b66bf01a9cb00b778889f885629acb.jpg', '2024-11-20 12:23:13', 1, 'jpg', 24, NULL),
(18, '4e7bbdc88bb25d2c9b7ec37dfd87876e.jpg', '2024-11-20 12:23:36', 1, 'jpg', 23, NULL),
(19, '50ef7b4edde81e899984cc65d137cc17.jpg', '2024-11-20 12:23:57', 1, 'jpg', 22, NULL),
(20, '37af30277455bf61a01fc89ab2700857.jpg', '2024-11-20 12:24:20', 1, 'jpg', 21, NULL),
(21, '9316dc34b5839c06df215436e36f233e.jpg', '2024-11-20 12:26:21', 1, 'jpg', 20, NULL),
(22, '09e7581729efd860e90436d2cb6688ea.jpg', '2024-11-20 12:26:44', 1, 'jpg', 19, NULL),
(23, 'afd5d2c762f23ee2fb9cb2cf6ffdf949.jpg', '2024-11-20 12:27:09', 1, 'jpg', 18, NULL),
(24, 'debcf8ec26703278c25e1c10955bde61.jpg', '2024-11-20 12:27:31', 1, 'jpg', 17, NULL),
(25, 'dcd47665ff1bf69c44496851412b9f51.png', '2024-11-20 12:28:16', 1, 'png', 16, NULL),
(26, 'eb91b693c8f6f9140eaa2773032715b9.jpg', '2024-11-20 12:29:16', 1, 'jpg', 15, NULL),
(28, 'd29278a6a700ab3f6c0f369479b3359a.jpg', '2024-11-20 12:29:16', 1, 'jpg', 14, NULL),
(29, '9e108a08445a839d5830b7aae64884e0.jpg', '2024-11-20 12:29:16', 1, 'jpg', 13, NULL),
(30, '5ab204dec60cbfbd0d9474245de89a4a.jpg', '2024-11-20 12:29:16', 1, 'jpg', 12, NULL),
(31, '0fd84f82a6995461ef4a9af3e2650648.png', '2024-11-20 12:29:16', 1, 'png', 11, NULL),
(32, '08d53432287e89ba784f053a0d2d47ae.jpg', '2024-11-20 12:29:16', 1, 'jpg', 10, NULL),
(33, 'c0f4ccef15b7b45f4fd01058928e8015.jpg', '2024-11-20 12:29:16', 1, 'jpg', 9, NULL),
(34, '772750f4db33f096f0b91689daa642ba.jpg', '2024-11-20 12:29:16', 1, 'jpg', 8, NULL),
(35, '7a096f5b714de7a9ea3a5b6223e400c0.jpg', '2024-11-20 12:29:16', 1, 'jpg', 7, NULL),
(36, 'e1c25415eaef17547f29f907e37a651f.jpg', '2024-11-20 12:29:16', 1, 'jpg', 6, NULL),
(37, 'f66222db8574079aab282780b9897de1.jpg', '2024-11-20 12:29:16', 1, 'jpg', 5, NULL),
(38, '7c7dfe2ffa15cc734cdfdd8e8872995b.jpg', '2024-11-20 12:29:16', 1, 'jpg', 4, NULL),
(39, '2f2caa6dd073469c788b9f3b582bcd95.jpg', '2024-11-20 12:29:16', 1, 'jpg', 3, NULL),
(40, 'f70e6aaa1f50c003022e135330c7b6ca.jpg', '2024-11-20 12:29:16', 1, 'jpg', 2, NULL),
(41, 'a0d5605f20b03783b73db10c6930faa7.jpg', '2024-11-20 12:29:16', 1, 'jpg', 1, NULL);


