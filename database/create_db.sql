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
    AgeLimit INT,
    Genre_ID INT,
    Version_ID INT,
    FOREIGN KEY (Genre_ID) REFERENCES Genre(Genre_ID),
    FOREIGN KEY (Version_ID) REFERENCES Version(Version_ID)
);
INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(1, 'The Dark Knight', 'Christopher Nolan', 'English', 2008, '02:32:00', 9, 'A crime drama about Batman taking on the Joker.', 'https://www.youtube.com/embed/EXeTwQWrcwY?si=ZMBW7Y-W88cDaEGu', 1, 1, 13);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(2, 'Inception', 'Christopher Nolan', 'English', 2010, '02:28:00', 8, 'A thriller about entering dreams within dreams.', 'https://www.youtube.com/embed/YoHD9XEInc0?si=WSR7T1zZsWyPUPBu', 12, 2, 13);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(3, 'Toy Story', 'John Lasseter', 'English', 1995, '01:21:00', 8, 'The story of toys that come to life.', 'https://www.youtube.com/embed/v-PjgYDrg70?si=kGVkuHosvV4Emsrs', 10, 1, 3);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(4, 'The Good, the Bad and the Ugly', 'Sergio Leone', 'Italian', 1966, '02:41:00', 9, 'A Western about three men in search of treasure.', 'https://www.youtube.com/embed/J9EZGHcu3E8?si=8S4DEzoMjdqB2OZp', 2, 1, 16);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(5, 'Schindler''s List', 'Steven Spielberg', 'English', 1993, '03:15:00', 9, 'A historical drama about the Holocaust.', 'https://www.youtube.com/embed/gG22XNhtnoY?si=YlEUkr2-40yS8WcC', 5, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(6, 'Mad Max: Fury Road', 'George Miller', 'English', 2015, '02:00:00', 8, 'An action movie about survival in a dystopian wasteland.', 'https://www.youtube.com/embed/hEJnMQG9ev8?si=2KRrId7NLVOJt3eb', 1, 2, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(7, 'The Matrix', 'Lana Wachowski', 'English', 1999, '02:16:00', 9, 'A sci-fi thriller about an alternate reality.', 'https://www.youtube.com/embed/9ix7TUGVYIo?si=MWzDWLjo8XRVxyfz', 14, 1, 16);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(8, 'Avengers: Endgame', 'Anthony Russo', 'English', 2019, '03:01:00', 9, 'The epic conclusion of the Avengers saga.', 'https://www.youtube.com/embed/TcMBFSGVi1c?si=6JpGxZu26UfXZn8S', 1, 2, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(9, 'The Godfather', 'Francis Ford Coppola', 'English', 1972, '02:55:00', 9, 'A crime drama about the mafia.', 'https://www.youtube.com/embed/UaVTIH8mujA?si=IB9j5e2k_kqSST7r', 8, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(10, 'The Exorcist', 'William Friedkin', 'English', 1973, '02:12:00', 8, 'A horror movie about a girl possessed by a demon.', 'https://www.youtube.com/embed/PIxpPMyGcpU?si=kOq6qwyAnpeLMf4M', 13, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(11, 'Finding Nemo', 'Andrew Stanton', 'English', 2003, '01:40:00', 8, 'A cartoon adventure about a lost fish.', 'https://www.youtube.com/embed/SPHfeNgogVs?si=RrWjOw0FPk5QjQIB', 10, 1, 3);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(12, 'Pulp Fiction', 'Quentin Tarantino', 'English', 1994, '02:34:00', 9, 'A crime drama about intersecting lives.', 'https://www.youtube.com/embed/tGpTpVyI_OQ?si=zlZ1qOo9-Cys6qi0', 8, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(13, 'The Lord of the Rings: The Fellowship of the Ring', 'Peter Jackson', 'English', 2001, '03:48:00', 9, 'A fantasy adventure in Middle Earth.', 'https://www.youtube.com/embed/V75dMMIW2B4?si=qPq7zB3rAa-Pw7ob', 15, 1, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(14, 'Star Wars: A New Hope', 'George Lucas', 'English', 1977, '02:01:00', 9, 'A sci-fi adventure about the rebellion against the Empire.', 'https://www.youtube.com/embed/vZ734NWnAHA?si=yDwWg0vn3rUOs4HL', 14, 2, 8);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(15, 'Jurassic Park', 'Steven Spielberg', 'English', 1993, '02:07:00', 8, 'A sci-fi thriller about a park filled with cloned dinosaurs.', 'https://www.youtube.com/embed/E8WaFvwtphY?si=HEz2xuHI2CnE_EzK', 14, 1, 10);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(16, 'Alien', 'Ridley Scott', 'English', 1979, '01:57:00', 8, 'A sci-fi horror movie about a deadly alien creature.', 'https://www.youtube.com/embed/OzY2r2JXsDM?si=qZXziVTjlQNR_FuD', 13, 2, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(17, 'Blade Runner', 'Ridley Scott', 'English', 1982, '01:57:00', 8, 'A sci-fi movie about a dystopian future.', 'https://www.youtube.com/embed/eogpIG53Cis?si=mlMkkhWiGbu-rL5i', 14, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(18, 'The Silence of the Lambs', 'Jonathan Demme', 'English', 1991, '01:58:00', 9, 'A thriller about a young FBI agent hunting a serial killer.', 'https://www.youtube.com/embed/6iB21hsprAQ?si=0LiS7DnlrC4IFFUO', 12, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(19, 'Interstellar', 'Christopher Nolan', 'English', 2014, '02:49:00', 8, 'A sci-fi adventure about space exploration.', 'https://www.youtube.com/embed/UDVtMYqUAyw?si=ufJ7etrLXe_O1dhf', 14, 2, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(20, 'Forrest Gump', 'Robert Zemeckis', 'English', 1994, '02:22:00', 8, 'A drama about a man who lives through historic events.', 'https://www.youtube.com/embed/bLvqoHBptjg?si=5DfxnijId-4P8spE', 5, 1, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(21, 'Gladiator', 'Ridley Scott', 'English', 2000, '02:35:00', 8, 'A historical drama about a Roman general turned gladiator.', 'https://www.youtube.com/embed/P5ieIbInFpg?si=fqPn4Ci_xE-dsgqO', 5, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(22, 'The Shawshank Redemption', 'Frank Darabont', 'English', 1994, '02:22:00', 9, 'A drama about two men in prison.', 'https://www.youtube.com/embed/PLl99DlL6b4?si=u-OUlWSvQF-K0_rs', 5, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(23, 'Black Panther', 'Ryan Coogler', 'English', 2018, '02:14:00', 8, 'A superhero movie about the king of Wakanda.', 'https://www.youtube.com/embed/_Z3QKkl1WyM?si=Z8zWeDluiRXT1IsV', 1, 2, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(24, 'Fight Club', 'David Fincher', 'English', 1999, '02:19:00', 8, 'A drama about a secret fight club.', 'https://www.youtube.com/embed/qtRKdVHc-cE?si=95sWWb1pDWT5zCDr', 8, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(25, 'The Lion King', 'Roger Allers', 'English', 1994, '01:28:00', 8, 'An animated movie about a young lion prince.', 'https://www.youtube.com/embed/GibiNy4d4gc?si=kApUktxMi4FiuMvq', 10, 1, 3);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(26, 'The Departed', 'Martin Scorsese', 'English', 2006, '02:31:00', 8, 'A crime thriller about an undercover cop and a mole in the police.', 'https://www.youtube.com/embed/iojhqm0JTW4?si=Er4FopuZb8bEqHek', 8, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(27, 'Harry Potter and the Sorcerer''s Stone', 'Chris Columbus', 'English', 2001, '02:32:00', 7, 'A fantasy movie about a young wizard.', 'https://www.youtube.com/embed/VyHV0BRtdxo?si=8JijmOOCcgeQr3hE', 15, 2, 8);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(28, '12 Angry Men', 'Sidney Lumet', 'English', 1957, '01:36:00', 9, 'A courtroom drama about a jury deliberating a murder trial.', 'https://www.youtube.com/embed/TEN-2uTi2c0?si=HiuCscamrqeQPR-j', 5, 1, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(29, 'Braveheart', 'Mel Gibson', 'English', 1995, '03:02:00', 8, 'A historical epic about William Wallace.', 'https://www.youtube.com/embed/1NJO0jxBtMo?si=_7f5H_MVOpWqqOjA', 5, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(30, 'The Terminator', 'James Cameron', 'English', 1984, '01:47:00', 8, 'A sci-fi movie about a killer robot from the future.', 'https://www.youtube.com/embed/nGrW-OR2uDk?si=MAm8MSzqRjJDpCrk', 14, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(31, 'Rocky', 'John G. Avildsen', 'English', 1976, '02:00:00', 8, 'A drama about a boxer''s rise to fame.', 'https://www.youtube.com/embed/-Hk-LYcavrw?si=9ruCB5pSnTqOENe7', 12, 1, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(32, 'A Beautiful Mind', 'Ron Howard', 'English', 2001, '02:15:00', 8, 'A drama about the life of John Nash.', 'https://www.youtube.com/embed/EajIlG_OCvw?si=ija2DZEbP5HoQdks', 5, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(33, 'Casablanca', 'Michael Curtiz', 'English', 1942, '01:42:00', 9, 'A drama about love and sacrifice during World War II.', 'https://www.youtube.com/embed/VHBcS0fYWfc?si=nx1HFkQP8tG0Ih28', 5, 1, 8);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(34, 'The Shining', 'Stanley Kubrick', 'English', 1980, '02:26:00', 8, 'A horror movie about a haunted hotel.', 'https://www.youtube.com/embed/FZQvIJxG9Xs?si=HGbTMLGj0hz5QVKp', 13, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(35, 'Indiana Jones and the Last Crusade', 'Steven Spielberg', 'English', 1989, '02:07:00', 8, 'An adventure movie about the search for the Holy Grail.', 'https://www.youtube.com/embed/DKg36LBVgfg?si=ycMV5NduMRSqwAfi', 11, 1, 12);



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
    TotalAmount DECIMAL(10, 2),
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

-- Week 2: 2024-11-26 to 2024-12-02
(1, '2024-11-26', '10:00:00', 1, 1),
(2, '2024-11-26', '13:00:00', 1, 2),
(3, '2024-11-26', '16:00:00', 1, 3),
(4, '2024-11-26', '19:00:00', 1, 4),
(5, '2024-11-26', '10:15:00', 2, 5),
(6, '2024-11-26', '13:45:00', 2, 6),
(7, '2024-11-26', '16:30:00', 2, 7),
(8, '2024-11-26', '19:00:00', 2, 1),
(9, '2024-11-26', '11:00:00', 3, 2),
(10, '2024-11-26', '14:00:00', 3, 3),
(11, '2024-11-26', '17:30:00', 3, 4),
(12, '2024-11-26', '20:30:00', 3, 5),
(13, '2024-11-26', '10:30:00', 4, 6),
(14, '2024-11-26', '13:30:00', 4, 7),
(15, '2024-11-26', '16:30:00', 4, 1),

(16, '2024-11-27', '10:00:00', 1, 2),
(17, '2024-11-27', '13:00:00', 1, 3),
(18, '2024-11-27', '16:00:00', 1, 4),
(19, '2024-11-27', '19:00:00', 1, 5),
(20, '2024-11-27', '10:15:00', 2, 6),
(21, '2024-11-27', '13:45:00', 2, 7),
(22, '2024-11-27', '16:30:00', 2, 1),
(23, '2024-11-27', '19:00:00', 2, 2),
(24, '2024-11-27', '11:00:00', 3, 3),
(25, '2024-11-27', '14:00:00', 3, 4),
(26, '2024-11-27', '17:30:00', 3, 5),
(27, '2024-11-27', '20:30:00', 3, 6),
(28, '2024-11-27', '10:30:00', 4, 7),
(29, '2024-11-27', '13:30:00', 4, 1),
(30, '2024-11-27', '16:30:00', 4, 2),

(31, '2024-11-28', '10:00:00', 1, 3),
(32, '2024-11-28', '13:00:00', 1, 4),
(33, '2024-11-28', '16:00:00', 1, 5),
(34, '2024-11-28', '19:00:00', 1, 6),
(35, '2024-11-28', '10:15:00', 2, 7),
(36, '2024-11-28', '13:45:00', 2, 1),
(37, '2024-11-28', '16:30:00', 2, 2),
(38, '2024-11-28', '19:00:00', 2, 3),
(39, '2024-11-28', '11:00:00', 3, 4),
(40, '2024-11-28', '14:00:00', 3, 5),
(41, '2024-11-28', '17:30:00', 3, 6),
(42, '2024-11-28', '20:30:00', 3, 7),
(43, '2024-11-28', '10:30:00', 4, 1),
(44, '2024-11-28', '13:30:00', 4, 2),
(45, '2024-11-28', '16:30:00', 4, 3),

(46, '2024-11-29', '10:00:00', 1, 4),
(47, '2024-11-29', '13:00:00', 1, 5),
(48, '2024-11-29', '16:00:00', 1, 6),
(49, '2024-11-29', '19:00:00', 1, 7),
(50, '2024-11-29', '10:15:00', 2, 1),
(51, '2024-11-29', '13:45:00', 2, 2),
(52, '2024-11-29', '16:30:00', 2, 3),
(53, '2024-11-29', '19:00:00', 2, 4),
(54, '2024-11-29', '11:00:00', 3, 5),
(55, '2024-11-29', '14:00:00', 3, 6),
(56, '2024-11-29', '17:30:00', 3, 7),
(57, '2024-11-29', '20:30:00', 3, 1),
(58, '2024-11-29', '10:30:00', 4, 2),
(59, '2024-11-29', '13:30:00', 4, 3),
(60, '2024-11-29', '16:30:00', 4, 4),

(61, '2024-11-30', '10:00:00', 1, 5),
(62, '2024-11-30', '13:00:00', 1, 6),
(63, '2024-11-30', '16:00:00', 1, 7),
(64, '2024-11-30', '19:00:00', 1, 1),
(65, '2024-11-30', '10:15:00', 2, 2),
(66, '2024-11-30', '13:45:00', 2, 3),
(67, '2024-11-30', '16:30:00', 2, 4),
(68, '2024-11-30', '19:00:00', 2, 5),
(69, '2024-11-30', '11:00:00', 3, 6),
(70, '2024-11-30', '14:00:00', 3, 7),
(71, '2024-11-30', '17:30:00', 3, 1),
(72, '2024-11-30', '20:30:00', 3, 2),
(73, '2024-11-30', '10:30:00', 4, 3),
(74, '2024-11-30', '13:30:00', 4, 4),
(75, '2024-11-30', '16:30:00', 4, 5),

(76, '2024-12-01', '10:00:00', 1, 6),
(77, '2024-12-01', '13:00:00', 1, 7),
(78, '2024-12-01', '16:00:00', 1, 1),
(79, '2024-12-01', '19:00:00', 1, 2),
(80, '2024-12-01', '10:15:00', 2, 3),
(81, '2024-12-01', '13:45:00', 2, 4),
(82, '2024-12-01', '16:30:00', 2, 5),
(83, '2024-12-01', '19:00:00', 2, 6),
(84, '2024-12-01', '11:00:00', 3, 7),
(85, '2024-12-01', '14:00:00', 3, 1),
(86, '2024-12-01', '17:30:00', 3, 2),
(87, '2024-12-01', '20:30:00', 3, 3),
(88, '2024-12-01', '10:30:00', 4, 4),
(89, '2024-12-01', '13:30:00', 4, 5),
(90, '2024-12-01', '16:30:00', 4, 6),

(91, '2024-12-02', '10:00:00', 1, 7),
(92, '2024-12-02', '13:00:00', 1, 1),
(93, '2024-12-02', '16:00:00', 1, 2),
(94, '2024-12-02', '19:00:00', 1, 3),
(95, '2024-12-02', '10:15:00', 2, 4),
(96, '2024-12-02', '13:45:00', 2, 5),
(97, '2024-12-02', '16:30:00', 2, 6),
(98, '2024-12-02', '19:00:00', 2, 7),
(99, '2024-12-02', '11:00:00', 3, 1),
(100, '2024-12-02', '14:00:00', 3, 2),
(101, '2024-12-02', '17:30:00', 3, 3),
(102, '2024-12-02', '20:30:00', 3, 4),
(103, '2024-12-02', '10:30:00', 4, 5),
(104, '2024-12-02', '13:30:00', 4, 6),
(105, '2024-12-02', '16:30:00', 4, 7);


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
    User_ID INT DEFAULT NULL,
    GuestUser_ID INT DEFAULT NULL,
    BookingDate DATE,
    NumberOfTickets INT,
    PaymentStatus VARCHAR(50),
    TotalPrice DECIMAL(10, 2),
    Payment_ID INT,
    Invoice_ID INT,
    FOREIGN KEY (Movie_ID) REFERENCES Movie(Movie_ID),
    FOREIGN KEY (User_ID) REFERENCES User(User_ID),
    FOREIGN KEY (GuestUser_ID) REFERENCES GuestUser(GuestUser_ID),
    FOREIGN KEY (Payment_ID) REFERENCES Payment(Payment_ID),
    FOREIGN KEY (Invoice_ID) REFERENCES Invoice(Invoice_ID),
    CHECK ((User_ID IS NOT NULL AND GuestUser_ID IS NULL) OR (User_ID IS NULL AND GuestUser_ID IS NOT NULL))
);


-- Modified Ticket Table
CREATE TABLE Ticket (
    Ticket_ID INT PRIMARY KEY AUTO_INCREMENT,
    Screening_ID INT,
    Seat_ID INT,
    Price_ID INT,
    Coupon_ID INT,
    Booking_ID INT,
    FOREIGN KEY (Screening_ID) REFERENCES Screening(Screening_ID),
    FOREIGN KEY (Booking_ID) REFERENCES Booking(Booking_ID),
    FOREIGN KEY (Seat_ID) REFERENCES Seat(Seat_ID),
    FOREIGN KEY (Price_ID) REFERENCES TicketPrice(Price_ID),
    FOREIGN KEY (Coupon_ID) REFERENCES Coupon(Coupon_ID)
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
 'Mon-Fri: 10:00 AM - 11:00 PM; Sat-Sun: 9:00 AM - 12:00 AM;', 
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
INSERT INTO Media (Media_ID, FileName, UploadAt, IsFeatured, Format, Movie_ID, News_ID) VALUES
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
INSERT INTO Media (Media_ID, FileName, UploadAt, IsFeatured, Format, Movie_ID, News_ID)
VALUES
(42, '23a316172125538b4c296c426039adc3.jpg', '2024-11-26 11:00:40', 0, 'jpg', 1, NULL),
(43, '8f298896598dc615fce62d72f570cb35.png', '2024-11-26 11:00:40', 0, 'png', 1, NULL),
(44, 'b8e99580e94ff2fceaad808924495ab4.jpg', '2024-11-26 11:00:40', 0, 'jpg', 1, NULL),
(45, 'cdab0350ef6af5109a6276b151dd527c.jpg', '2024-11-26 11:00:40', 0, 'jpg', 1, NULL),
(46, 'f96d0092c2957f5c868d0fb3d0fe12e4.jpg', '2024-11-26 11:00:40', 0, 'jpg', 1, NULL),
(47, '2c3617af910fb4c9ec800f4ef74bc793.jpg', '2024-11-26 11:00:40', 0, 'jpg', 2, NULL),
(48, '7df8463644e06de20dd9c72702f7c6eb.jpg', '2024-11-26 11:00:40', 0, 'jpg', 2, NULL),
(49, '93e6b99cd2a3852834dcd91f8984f0fd.jpg', '2024-11-26 11:00:40', 0, 'jpg', 2, NULL),
(50, 'dd9a3065dff8f78b7fc221055d40b5fe.jpg', '2024-11-26 11:00:40', 0, 'jpg', 2, NULL),
(51, 'f5c4f2c299322b848178d2a844ad27ae.png', '2024-11-26 11:00:40', 0, 'png', 2, NULL),
(52, '1aaeb3ce9b5e2ff2d8967611bc8d49b9.jpg', '2024-11-26 11:00:40', 0, 'jpg', 3, NULL),
(53, '8bf8c401a93cbabc2fe217c72586b84b.png', '2024-11-26 11:00:40', 0, 'png', 3, NULL),
(54, 'c506c4e98774636ad5893543a24c1b0e.png', '2024-11-26 11:00:40', 0, 'png', 3, NULL),
(55, 'f0b51a80a588190d7c0946cc626ad6d2.png', '2024-11-26 11:00:40', 0, 'png', 3, NULL),
(56, '52f62170d6c829560f8b697a6bd48289.png', '2024-11-26 11:00:40', 0, 'png', 3, NULL),
(57, 'd37aeb832c9d075222e54ff8fb516496.png', '2024-11-26 11:00:40', 0, 'png', 4, NULL),
(58, 'afe6e46e6854044917b94af5b924a3c3.png', '2024-11-26 11:00:40', 0, 'png', 4, NULL),
(59, '30632f0cb9b60e577ffaee3457858fd0.png', '2024-11-26 11:00:40', 0, 'png', 4, NULL),
(60, '21dec1f1f307dc21eb44d3f94cb8ed66.png', '2024-11-26 11:00:40', 0, 'png', 4, NULL),
(61, '9dfb84b8421c0d8a40f532cc9a8a9358.png', '2024-11-26 11:00:40', 0, 'png', 4, NULL),
(62, '8f83d92355744fef1f8857e31c04ae62.png', '2024-11-26 11:00:40', 0, 'png', 5, NULL),
(63, '49ee9e9de43c21358b14347506acbbc7.png', '2024-11-26 11:00:40', 0, 'png', 5, NULL),
(64, '7981f296f25d7570cbb20740a7fd0de3.png', '2024-11-26 11:00:40', 0, 'png', 5, NULL),
(66, '08315db6693ce6fdca4cf9ea9624ebbb.png', '2024-11-26 11:00:40', 0, 'png', 5, NULL),
(67, 'e547909a22f6ecfcaf60af306cb947c9.png', '2024-11-26 11:00:40', 0, 'png', 5, NULL),
(68, '5a8981c0899c48d5c34581981e215178.png', '2024-11-26 11:00:40', 0, 'png', 6, NULL),
(69, '10f0ea5266b90c7f99b9ad935e5e9d3e.png', '2024-11-26 11:00:40', 0, 'png', 6, NULL),
(70, 'a8b725d6aaf62fd167bf18267acfc236.png', '2024-11-26 11:00:40', 0, 'png', 6, NULL),
(71, 'd17b396c8e94d3e961a6590f8959d9f7.png', '2024-11-26 11:00:40', 0, 'png', 6, NULL),
(72, 'f11e73d4a827ebcd31d1c7c4eee63d98.png', '2024-11-26 11:00:40', 0, 'png', 6, NULL),
(73, '4f6b41c5237a1ea50696e7866190ee20.png', '2024-11-26 11:00:40', 0, 'png', 7, NULL),
(74, '7bf7ce4d9accd1dd51b3ebdc933aea04.png', '2024-11-26 11:00:40', 0, 'png', 7, NULL),
(75, '90922282be5b0dcbe382c1184eeb9ab0.png', '2024-11-26 11:00:40', 0, 'png', 7, NULL),
(76, 'ab81cd6aede0e9e7b0edabd2792cf6f4.png', '2024-11-26 11:00:40', 0, 'png', 7, NULL),
(77, 'fd46c16bba1fae76cedf5c518535cda9.png', '2024-11-26 11:00:40', 0, 'png', 7, NULL),
(78, '6e8a9cd85db9849fb35d27ed40c31853.png', '2024-11-26 11:00:40', 0, 'png', 8, NULL),
(79, '26e40306216aa76721486609d8c17a91.png', '2024-11-26 11:00:40', 0, 'png', 8, NULL),
(80, '3881a1cef1c4b3be7cb251a4fb61e5e5.png', '2024-11-26 11:00:40', 0, 'png', 8, NULL),
(81, 'db5e12227959a25e067e88ccce6caf2d.png', '2024-11-26 11:00:40', 0, 'png', 8, NULL),
(82, 'fd9c3dafa33b26e899d5f1adc2878117.png', '2024-11-26 11:00:40', 0, 'png', 8, NULL),
(83, '2d2a97f85ccb391e460ebfbbc0160ba8.png', '2024-11-26 11:00:40', 0, 'png', 9, NULL),
(84, '3dd109c1b3d15fe778a967805d64c24e.png', '2024-11-26 11:00:40', 0, 'png', 9, NULL),
(85, '7810afd09f29fc0190f561fa97998301.png', '2024-11-26 11:00:40', 0, 'png', 9, NULL),
(86, 'a1e74cb8434e61ca69fe6cb45001e428.png', '2024-11-26 11:00:40', 0, 'png', 9, NULL),
(87, 'bdc15df4aae04f78d2a9799f031d5615.png', '2024-11-26 11:00:40', 0, 'png', 9, NULL),
(88, 'bf90c16bbf89cf27935b97a8b14d2095.png', '2024-11-26 11:00:40', 0, 'png', 10, NULL),
(89, '81698c1808fd9d1ab96307c7f3e70ce1.png', '2024-11-26 11:00:40', 0, 'png', 10, NULL),
(90, '8e38234dc0edd83303c96bce4259954b.png', '2024-11-26 11:00:40', 0, 'png', 10, NULL),
(91, '6d48f380d9070a68a3a6d45375a98ed9.png', '2024-11-26 11:00:40', 0, 'png', 10, NULL),
(92, 'f55be1c7d09e390e62d6b2955dff86cb.png', '2024-11-26 11:00:40', 0, 'png', 10, NULL),
(93, '925bbb0fa4ef6d2cdaa5aac19bf50e90.png', '2024-11-26 11:00:40', 0, 'png', 11, NULL),
(94, '9192c9119054588ee663b0de9257e3f4.png', '2024-11-26 11:00:40', 0, 'png', 11, NULL),
(95, 'a22eca1d8529bbe524a1a4c2be535b97.png', '2024-11-26 11:00:40', 0, 'png', 11, NULL),
(96, 'a08510aee41e5fefe938229a7f315da9.png', '2024-11-26 11:00:40', 0, 'png', 11, NULL),
(97, 'bf9c2186fee36f617a53a7437f653b86.png', '2024-11-26 11:00:40', 0, 'png', 11, NULL),
(98, '8fce709a3e1569433bdc9432b18afd55.png', '2024-11-26 11:00:40', 0, 'png', 12, NULL),
(99, '446a0be5a6f8c55f929b26d6bd974988.png', '2024-11-26 11:00:40', 0, 'png', 12, NULL),
(100, 'ebb4384d79cd89174dd9137b0ff93c6c.png', '2024-11-26 11:00:40', 0, 'png', 12, NULL),
(101, '41fdd27ab7e345928e327c588738f355.png', '2024-11-26 11:00:40', 0, 'png', 12, NULL),
(102, '25c98ec972d0d8712e255305ec70e6d3.png', '2024-11-26 11:00:40', 0, 'png', 12, NULL),
(103, '4edd38de1dee9ddf753a105bcd5f332b.png', '2024-11-26 11:00:40', 0, 'png', 13, NULL),
(104, '825a6c80567cb93d6afd66b44d907b3d.png', '2024-11-26 11:00:40', 0, 'png', 13, NULL),
(105, '2147ad85ac99cb704cfbac822a890248.png', '2024-11-26 11:00:40', 0, 'png', 13, NULL),
(106, '131959f5d4d034602b0f10c5feebca6a.png', '2024-11-26 11:00:40', 0, 'png', 13, NULL),
(107, 'daa4209d8dd93cda191bad5c2d06629a.png', '2024-11-26 11:00:40', 0, 'png', 13, NULL),
(108, '1d449024a48b8061061d4e1d97875791.png', '2024-11-26 11:00:40', 0, 'png', 14, NULL),
(109, '7d91dcacbf95c3c1c1f09802429fa4e7.png', '2024-11-26 11:00:40', 0, 'png', 14, NULL),
(110, '9d8ea5b46eac8be05566da1418348308.png', '2024-11-26 11:00:40', 0, 'png', 14, NULL),
(111, 'e15b2baefc3ec24b770c7be7c422ce6c.png', '2024-11-26 11:00:40', 0, 'png', 14, NULL),
(112, 'f8ffabe7e523b8228d95e4204573e73a.png', '2024-11-26 11:00:40', 0, 'png', 14, NULL),
(113, '48a983529e79fd6d4ec596b96769cff2.png', '2024-11-26 11:00:40', 0, 'png', 15, NULL),
(114, '9102dca8365587b08c1416bf435a048d.png', '2024-11-26 11:00:40', 0, 'png', 15, NULL),
(115, 'b96be75bdbc79a5ed3d6b0cbc1006e78.png', '2024-11-26 11:00:40', 0, 'png', 15, NULL),
(116, 'd6ce6958335e1bded25b8e8a41352eeb.png', '2024-11-26 11:00:40', 0, 'png', 15, NULL),
(117, 'd2313c39fa475df7e0695cd4249ed561.png', '2024-11-26 11:00:40', 0, 'png', 15, NULL),
(118, '25b488ebef41bb5f642c28724f5fca17.png', '2024-11-26 11:00:40', 0, 'png', 16, NULL),
(119, '49d2f88780d98eb82eefa3060cad7be3.png', '2024-11-26 11:00:40', 0, 'png', 16, NULL),
(120, '109c56ae15d5a26106cebd8fb68a1530.png', '2024-11-26 11:00:40', 0, 'png', 16, NULL),
(121, '425825514665f49dba6ff08e37208bdc.png', '2024-11-26 11:00:40', 0, 'png', 16, NULL),
(122, 'bbafe38df1692150d1ddb2acf88caf26.png', '2024-11-26 11:00:40', 0, 'png', 16, NULL),
(123, '2d065c4a87950f30092c72cddcb60d5f.png', '2024-11-26 11:00:40', 0, 'png', 17, NULL),
(124, '3b8720cdb2ad7bafe1c03c536a963702.png', '2024-11-26 11:00:40', 0, 'png', 17, NULL),
(125, '11d4a18a00391d9b2ac5fbd8a1343a1b.png', '2024-11-26 11:00:40', 0, 'png', 17, NULL),
(126, '86e829982f183191b140f4b76cb85f9e.png', '2024-11-26 11:00:40', 0, 'png', 17, NULL),
(127, '633ee9bdaa053fc3fb5ce145fa1a7be9.png', '2024-11-26 11:00:40', 0, 'png', 17, NULL),
(128, '1ae98177241297d41c01b4466760eb74.png', '2024-11-26 11:00:40', 0, 'png', 18, NULL),
(129, '2f41a1480507f51c78513ab62ebfb466.png', '2024-11-26 11:00:40', 0, 'png', 18, NULL),
(130, '86eed8684892becef40af1094211e181.png', '2024-11-26 11:00:40', 0, 'png', 18, NULL),
(131, 'ea363485f4f23b43df455316accd99b3.png', '2024-11-26 11:00:40', 0, 'png', 18, NULL),
(132, 'f409bc808b7611dd5559844bc05d170a.png', '2024-11-26 11:00:40', 0, 'png', 18, NULL),
(133, '6eaa32dd2dab97d5822680e7c27957c7.png', '2024-11-26 11:00:40', 0, 'png', 19, NULL),
(134, '7e71bca1fd303fdf1fd39aad3642dd6d.png', '2024-11-26 11:00:40', 0, 'png', 19, NULL),
(135, '9ec6376e8a3cacb6edbb220ddc2c0455.png', '2024-11-26 11:00:40', 0, 'png', 19, NULL),
(136, '54b10c8c6ad37b90d44d21a7256cd36f.png', '2024-11-26 11:00:40', 0, 'png', 19, NULL),
(137, 'd323b2dbf68e977cb3713d06a0627b81.png', '2024-11-26 11:00:40', 0, 'png', 19, NULL),
(138, '0b79c5bf80aac0e0b8db0d7813aad5d9.png', '2024-11-26 11:00:40', 0, 'png', 20, NULL),
(139, '73c8a619e16f1c2574a1c092c524dc83.png', '2024-11-26 11:00:40', 0, 'png', 20, NULL),
(140, '84c394b58bdde27b030c361ab4c08bcb.png', '2024-11-26 11:00:40', 0, 'png', 20, NULL),
(141, '7088497aa023f4cd6efde2bcda599ee8.png', '2024-11-26 11:00:40', 0, 'png', 20, NULL),
(142, '7132c45adac7e67f29438ea459899874.png', '2024-11-26 11:00:40', 0, 'png', 20, NULL),
(143, '80a95365ce665abe5b1d8174cb765517.png', '2024-11-26 11:00:40', 0, 'png', 21, NULL),
(144, '214b6544474f3f8c735e6de943aa2698.png', '2024-11-26 11:00:40', 0, 'png', 21, NULL),
(145, '606a848144fac88979586c2c6b9bcac8.png', '2024-11-26 11:00:40', 0, 'png', 21, NULL),
(146, '880d49e399db89226aba74fb622b1ac0.png', '2024-11-26 11:00:40', 0, 'png', 21, NULL),
(147, 'c1552c6b409dda352e524e98fd371bc5.png', '2024-11-26 11:00:40', 0, 'png', 21, NULL),
(148, '2b81931aa94e19418597edb3ff3bf7ec.png', '2024-11-26 11:00:40', 0, 'png', 22, NULL),
(149, '81a53ec4d490604525abc47fc9fefaf2.png', '2024-11-26 11:00:40', 0, 'png', 22, NULL),
(150, '85e602b09ea1d98b192503c3ab4b4b96.png', '2024-11-26 11:00:40', 0, 'png', 22, NULL),
(151, 'e8873a8cb2d9391f415c7caa33ddfe48.png', '2024-11-26 11:00:40', 0, 'png', 22, NULL),
(152, 'f81d17941c87eb8eb92ad5f92a274134.png', '2024-11-26 11:00:40', 0, 'png', 22, NULL),
(153, 'adb1698b4f0d4abcdb27243225e74a43.png', '2024-11-26 11:00:40', 0, 'png', 23, NULL),
(154, '0cfcc0ace8578a3cb2c4e1ea9f6a6f56.png', '2024-11-26 11:00:40', 0, 'png', 23, NULL),
(155, '7b2c01d356950db16e188bb4cb3fd114.png', '2024-11-26 11:00:40', 0, 'png', 23, NULL),
(156, '5886d37bdc3f55675202e91d1d739c77.png', '2024-11-26 11:00:40', 0, 'png', 23, NULL),
(157, '07815c5f32967d84c4880eb7600bbb33.png', '2024-11-26 11:00:40', 0, 'png', 23, NULL),
(158, 'f9a4884c33347634f82e81b70772a321.png', '2024-11-26 11:00:40', 0, 'png', 24, NULL),
(159, '7bccb2f34b9d52025a7d3ac5bb90d97c.png', '2024-11-26 11:00:40', 0, 'png', 24, NULL),
(160, '9458535ce37c23a80bdbf5aa9eb7e398.png', '2024-11-26 11:00:40', 0, 'png', 24, NULL),
(161, 'e3394bfbec0944ff34c7c9770600c38b.png', '2024-11-26 11:00:40', 0, 'png', 24, NULL),
(162, 'e74182cf89a948750a180beb9d72755f.png', '2024-11-26 11:00:40', 0, 'png', 24, NULL),
(163, '0442fa512f6c4e49c2096fa653ae7fab.png', '2024-11-26 11:00:40', 0, 'png', 25, NULL),
(164, 'b7a501b38c5952a56317166eb10c2845.png', '2024-11-26 11:00:40', 0, 'png', 25, NULL),
(165, 'c23ab863dd20f6d01b8cbb05afd44af5.png', '2024-11-26 11:00:40', 0, 'png', 25, NULL),
(166, 'c31c4d479ebc519cf4c09b4295215d60.png', '2024-11-26 11:00:40', 0, 'png', 25, NULL),
(167, 'e53dd9b17b12d43c263b1bc63c1768ea.png', '2024-11-26 11:00:40', 0, 'png', 25, NULL),
(168, '3b08626b4225476274aa071186b79289.png', '2024-11-26 11:00:40', 0, 'png', 26, NULL),
(169, '92e5eccb585e7e1e8ef58eb325b4b262.png', '2024-11-26 11:00:40', 0, 'png', 26, NULL),
(170, '94eaeed2ac729e72c5520a1491f5af97.png', '2024-11-26 11:00:40', 0, 'png', 26, NULL),
(171, '97d663912ae6a80a5b980731432e058c.png', '2024-11-26 11:00:40', 0, 'png', 26, NULL),
(172, '606c67d76814e00aa8d5b78d96132fd6.png', '2024-11-26 11:00:40', 0, 'png', 26, NULL),
(173, 'c8d5d9a77aa29470b6ee166ca3197aac.png', '2024-11-26 11:00:40', 0, 'png', 27, NULL),
(174, '7917a3579cc52665f48f6685f148f439.png', '2024-11-26 11:00:40', 0, 'png', 27, NULL),
(175, '801d2337f6a97c3a9ee9424e9d98abec.png', '2024-11-26 11:00:40', 0, 'png', 27, NULL),
(176, '8c05a295eda2c0dee08d4a9f79ac76bc.png', '2024-11-26 11:00:40', 0, 'png', 27, NULL),
(177, 'cc0323cfa33f0605f38ab6159a694d35.png', '2024-11-26 11:00:40', 0, 'png', 27, NULL),
(178, '9a2af31e2713d069c49f89df16333ba2.png', '2024-11-26 11:00:40', 0, 'png', 28, NULL),
(179, '3852fa3f7d62d9d4509a3b887873af24.png', '2024-11-26 11:00:40', 0, 'png', 28, NULL),
(180, 'bd8da5e26cb97f41ebfc4176f9e84219.png', '2024-11-26 11:00:40', 0, 'png', 28, NULL),
(181, 'ca1239f447fda7234dc986875179df5c.png', '2024-11-26 11:00:40', 0, 'png', 28, NULL),
(182, 'd0afb8a605919a3a33d74eb321afc512.png', '2024-11-26 11:00:40', 0, 'png', 28, NULL),
(183, '04d8def777dd2755befa6bbef5938480.png', '2024-11-26 11:00:40', 0, 'png', 29, NULL),
(184, '53d1064481c9b073e51a8bb87bd488c0.png', '2024-11-26 11:00:40', 0, 'png', 29, NULL),
(185, '220d02ea6815901d825e9bfe840959a2.png', '2024-11-26 11:00:40', 0, 'png', 29, NULL),
(186, '246c415dbc5bed9f551a577a4878c6b2.png', '2024-11-26 11:00:40', 0, 'png', 29, NULL),
(187, 'ae2c6a768023047dc374b5078aa1a2f0.png', '2024-11-26 11:00:40', 0, 'png', 29, NULL),
(188, '91eb2c7226ed6272875e7e0ee4afc653.png', '2024-11-26 11:00:40', 0, 'png', 30, NULL),
(189, '492eabde2f847bb3b3c86fcfabb8ebf1.png', '2024-11-26 11:00:40', 0, 'png', 30, NULL),
(190, '981b44a66c394c20da2b645aeb87679f.png', '2024-11-26 11:00:40', 0, 'png', 30, NULL),
(191, 'd0291372ec2121ade0e1fe59e8db4a37.png', '2024-11-26 11:00:40', 0, 'png', 30, NULL),
(192, 'd9922237123565d0645fdc89be1c69c2.png', '2024-11-26 11:00:40', 0, 'png', 30, NULL),
(193, '4ca4f14f6e558a37553d24824db11e00.png', '2024-11-26 11:00:40', 0, 'png', 31, NULL),
(194, '66e0995f5927f1054170176476687de5.png', '2024-11-26 11:00:40', 0, 'png', 31, NULL),
(195, 'b915a612f8ffc7975addf6d059f31c33.png', '2024-11-26 11:00:40', 0, 'png', 31, NULL),
(196, 'bc674525f32f24b78d936de30b0ae100.png', '2024-11-26 11:00:40', 0, 'png', 31, NULL),
(197, 'fafc31bc4388728b3339916809e7983d.png', '2024-11-26 11:00:40', 0, 'png', 31, NULL),
(198, '3b2dfa19894dee7423e0cc4f9b0fd457.png', '2024-11-26 11:00:40', 0, 'png', 32, NULL),
(199, '7a8701bb922efa8642ea75cf09386bc1.png', '2024-11-26 11:00:40', 0, 'png', 32, NULL),
(200, '12a597ba773ef991b71eb55b117b6835.png', '2024-11-26 11:00:40', 0, 'png', 32, NULL),
(201, '93b6a02b8549880945d12f5ba9414797.png', '2024-11-26 11:00:40', 0, 'png', 32, NULL),
(202, '129ea4d68c8de23628fea9a9dfdf7d43.png', '2024-11-26 11:00:40', 0, 'png', 32, NULL),
(203, '1f1c329d4bcc4289c2ccec9e6d6af8fa.png', '2024-11-26 11:00:40', 0, 'png', 33, NULL),
(204, '31a810a86dfcebf4e02c39cc00d66ff9.png', '2024-11-26 11:00:40', 0, 'png', 33, NULL),
(205, '44d5e245b32b9fd2f797c30a60abd7ef.png', '2024-11-26 11:00:40', 0, 'png', 33, NULL),
(206, '91a70281514f118e7c7c8cb3851bca1a.png', '2024-11-26 11:00:40', 0, 'png', 33, NULL),
(207, 'bf99485317919c3997f07105b47e330e.png', '2024-11-26 11:00:40', 0, 'png', 33, NULL),
(208, 'b969646fde218e01dfc4d78437c88684.png', '2024-11-26 11:00:40', 0, 'png', 34, NULL),
(209, '7fe20c66c2cb855c5727196c6127b8a6.png', '2024-11-26 11:00:40', 0, 'png', 34, NULL),
(210, '172fea1f0857fbb039fd1d4a28fd21bc.png', '2024-11-26 11:00:40', 0, 'png', 34, NULL),
(211, '9724ee39c8ec5e7105b7d64444a7c643.png', '2024-11-26 11:00:40', 0, 'png', 34, NULL),
(212, '50418692f296b44921ed64a0783b8576.png', '2024-11-26 11:00:40', 0, 'png', 34, NULL),
(213, 'c6cd4ded9fb79458bd72f94652c74a4e.png', '2024-11-26 11:00:40', 0, 'png', 35, NULL),
(214, 'a7e9d47e9423d1055704e69b6db80359.png', '2024-11-26 11:00:40', 0, 'png', 35, NULL),
(215, '79c25c4cd128ce0d003cb21401172f81.png', '2024-11-26 11:00:40', 0, 'png', 35, NULL),
(216, '41a33d5000ce32e41fef08a5f9d69c19.png', '2024-11-26 11:00:40', 0, 'png', 35, NULL),
(217, 'e285827ec1f33666e8463a2ea437dd01.png', '2024-11-26 11:00:40', 0, 'png', 35, NULL);



