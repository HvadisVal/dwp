DROP DATABASE IF EXISTS c5di1yb93_dwp;
CREATE DATABASE c5di1yb93_dwp;
USE c5di1yb93_dwp;

-- Genre Table
CREATE TABLE Genre (
    Genre_ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(100),
    Description TEXT
);

-- Version Table
CREATE TABLE Version (
    Version_ID INT PRIMARY KEY AUTO_INCREMENT,
    Format VARCHAR(50),
    AdditionalFee DECIMAL(10, 2)
);

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

-- LandingMovies Table
CREATE TABLE LandingMovies (
    LandingMovie_ID INT PRIMARY KEY AUTO_INCREMENT,
    Movie_ID INT NOT NULL,
    DisplayOrder INT NOT NULL,
    FOREIGN KEY (Movie_ID) REFERENCES Movie(Movie_ID) ON DELETE CASCADE
);

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

-- CinemaHall Table
CREATE TABLE CinemaHall (
    CinemaHall_ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255),
    TotalSeats INT
);

-- Screening Table
CREATE TABLE Screening (
    Screening_ID INT PRIMARY KEY AUTO_INCREMENT,
    ShowDate DATE,  
    ShowTime TIME,
    CinemaHall_ID INT,  
    Movie_ID INT,  
    FOREIGN KEY (CinemaHall_ID) REFERENCES CinemaHall(CinemaHall_ID) ON DELETE CASCADE,
    FOREIGN KEY (Movie_ID) REFERENCES Movie(Movie_ID) ON DELETE CASCADE
);

-- Seat Table
CREATE TABLE Seat (
    Seat_ID INT PRIMARY KEY AUTO_INCREMENT,
    SeatNumber INT,
    Row INT,
    CinemaHall_ID INT,
    FOREIGN KEY (CinemaHall_ID) REFERENCES CinemaHall(CinemaHall_ID)
);

-- Ticket Price Table
CREATE TABLE TicketPrice (
    Price_ID INT PRIMARY KEY AUTO_INCREMENT,
    Type VARCHAR(50),  
    Price DECIMAL(10, 2),
    ValidFrom DATE,
    ValidTo DATE
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
    User_ID INT DEFAULT NULL,
    GuestUser_ID INT DEFAULT NULL,
    BookingDate DATE,
    NumberOfTickets INT,
    PaymentStatus VARCHAR(50),
    TotalPrice DECIMAL(10, 2),
    Payment_ID INT,
    Invoice_ID INT,
    Coupon_ID INT,
    FOREIGN KEY (Movie_ID) REFERENCES Movie(Movie_ID),
    FOREIGN KEY (User_ID) REFERENCES User(User_ID),
    FOREIGN KEY (GuestUser_ID) REFERENCES GuestUser(GuestUser_ID),
    FOREIGN KEY (Payment_ID) REFERENCES Payment(Payment_ID),
    FOREIGN KEY (Invoice_ID) REFERENCES Invoice(Invoice_ID),
    FOREIGN KEY (Coupon_ID) REFERENCES Coupon(Coupon_ID),
    CHECK ((User_ID IS NOT NULL AND GuestUser_ID IS NULL) OR (User_ID IS NULL AND GuestUser_ID IS NOT NULL))
);

-- Ticket Table
CREATE TABLE Ticket (
    Ticket_ID INT PRIMARY KEY AUTO_INCREMENT,
    Screening_ID INT,
    Seat_ID INT,
    Price_ID INT,
    Booking_ID INT,
    FOREIGN KEY (Screening_ID) REFERENCES Screening(Screening_ID),
    FOREIGN KEY (Booking_ID) REFERENCES Booking(Booking_ID),
    FOREIGN KEY (Seat_ID) REFERENCES Seat(Seat_ID),
    FOREIGN KEY (Price_ID) REFERENCES TicketPrice(Price_ID)
);

-- News Table
CREATE TABLE News (
    News_ID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255),
    Content TEXT,
    DatePosted DATE
);

-- Company Table
CREATE TABLE Company (
    Company_ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255),
    Description TEXT,
    OpeningHours VARCHAR(100),
    Email VARCHAR(255),
    Location VARCHAR(255)
); 

-- Messages Table
CREATE TABLE ContactMessages (
    Message_ID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255),
    Email VARCHAR(255),
    Subject VARCHAR(255),
    Message TEXT,
    Submitted_At TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Reply Text Null
);

-- Password Table
CREATE TABLE PasswordResets (
    Reset_ID INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL,
    Token VARCHAR(255) NOT NULL,
    Expiry DATETIME NOT NULL,
    INDEX (Email)
);

-- Admin Table
CREATE TABLE Admin (
    Admin_ID INT PRIMARY KEY AUTO_INCREMENT,
    Email VARCHAR(100),
    Password VARCHAR(255)
);
CREATE TABLE Login_Attempts (
    Login_Attempts_Id INT AUTO_INCREMENT PRIMARY KEY,
    Ip_Address VARCHAR(45) NOT NULL,
    Attempt_Time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Success BOOLEAN NOT NULL DEFAULT 0,
    Blocked_Until TIMESTAMP NULL
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

-- DetailedBookings View
CREATE VIEW DetailedBookings AS
SELECT 
    b.Booking_ID,
    m.Title AS MovieTitle,
    COALESCE(u.Name, CONCAT(g.Firstname, ' ', g.Lastname)) AS CustomerName,
    b.BookingDate,
    b.NumberOfTickets,
    b.TotalPrice,
    b.PaymentStatus
FROM 
    Booking b
LEFT JOIN 
    Movie m ON b.Movie_ID = m.Movie_ID
LEFT JOIN 
    User u ON b.User_ID = u.User_ID
LEFT JOIN 
    GuestUser g ON b.GuestUser_ID = g.GuestUser_ID;

-- MovieDetails View
CREATE VIEW MovieDetails AS
SELECT 
    m.Movie_ID,
    m.Title,
    m.Director,
    m.Language,
    m.Year,
    m.Duration,
    m.Rating,
    m.Description,
    m.TrailerLink,
    m.AgeLimit,
    -- Fetch the main (featured) poster image for the movie
    MAX(CASE WHEN media.IsFeatured = 1 THEN media.FileName END) AS ImageFileName,
    -- Fetch gallery images for the movie
    GROUP_CONCAT(CASE WHEN media.IsFeatured = 0 THEN media.FileName END) AS GalleryImages,
    -- Movie genre information
    g.Genre_ID,
    g.Name AS GenreName,
    -- Movie version information
    v.Version_ID,
    v.Format AS VersionFormat
FROM 
    Movie m
LEFT JOIN 
    Media media ON m.Movie_ID = media.Movie_ID
LEFT JOIN 
    Genre g ON m.Genre_ID = g.Genre_ID
LEFT JOIN 
    Version v ON m.Version_ID = v.Version_ID
GROUP BY 
    m.Movie_ID;

-- Trigger to check for overlapping screenings when inserting new screenings

DELIMITER //

CREATE TRIGGER `check_screening_overlap`
BEFORE INSERT ON `Screening`
FOR EACH ROW
BEGIN
    DECLARE movie_duration_seconds INT;
    DECLARE new_end_time DATETIME;
    
    -- Get the movie duration in seconds
    SELECT TIME_TO_SEC(Duration) INTO movie_duration_seconds
    FROM Movie
    WHERE Movie_ID = NEW.Movie_ID;

    -- Calculate the new screening's end time (start time + duration + buffer)
    SET new_end_time = DATE_ADD(NEW.ShowTime, INTERVAL movie_duration_seconds + 900 SECOND);

    -- Check for overlapping screenings by both date and time
    IF EXISTS (
        SELECT 1 
        FROM Screening s
        JOIN Movie m ON s.Movie_ID = m.Movie_ID
        WHERE s.CinemaHall_ID = NEW.CinemaHall_ID
          AND s.ShowDate = NEW.ShowDate -- Ensure same date
          AND (
              (NEW.ShowTime < DATE_ADD(s.ShowTime, INTERVAL TIME_TO_SEC(m.Duration) + 900 SECOND)
               AND new_end_time > s.ShowTime)
          )
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Overlap detected: Screening conflicts with another screening.';
    END IF;
END;
//

DELIMITER ;

-- Trigger to check for overlapping screenings when updating existing screenings

DELIMITER //

CREATE TRIGGER `check_screening_overlap_update`
BEFORE UPDATE ON `Screening`
FOR EACH ROW
BEGIN
    DECLARE movie_duration_seconds INT;
    DECLARE new_end_time DATETIME;

    -- Get the movie duration in seconds
    SELECT TIME_TO_SEC(Duration) INTO movie_duration_seconds
    FROM Movie
    WHERE Movie_ID = NEW.Movie_ID;

    -- Calculate the new screening's end time (start time + duration + buffer)
    SET new_end_time = DATE_ADD(NEW.ShowTime, INTERVAL movie_duration_seconds + 900 SECOND);

    -- Check for overlapping screenings, excluding the current screening
    IF EXISTS (
        SELECT 1 
        FROM Screening s
        JOIN Movie m ON s.Movie_ID = m.Movie_ID
        WHERE s.CinemaHall_ID = NEW.CinemaHall_ID
          AND s.Screening_ID != OLD.Screening_ID -- Exclude the current screening
          AND s.ShowDate = NEW.ShowDate -- Ensure same date
          AND (
              (NEW.ShowTime < DATE_ADD(s.ShowTime, INTERVAL TIME_TO_SEC(m.Duration) + 900 SECOND)
               AND new_end_time > s.ShowTime)
          )
    ) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Overlap detected: Screening conflicts with another screening.';
    END IF;
END;
//

DELIMITER ;

-- Inserting sample data

-- Inserting into table 'Genre'
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

-- Inserting into table 'Version'

INSERT INTO Version (Version_ID, Format, AdditionalFee) VALUES (1, '2D', 0.00);
INSERT INTO Version (Version_ID, Format, AdditionalFee) VALUES (2, '3D', 3.00);
INSERT INTO Version (Version_ID, Format, AdditionalFee) VALUES (3, 'IMAX 2D', 5.00);
INSERT INTO Version (Version_ID, Format, AdditionalFee) VALUES (4, 'IMAX 3D', 7.00);
INSERT INTO Version (Version_ID, Format, AdditionalFee) VALUES (5, '4DX', 10.00);
INSERT INTO Version (Version_ID, Format, AdditionalFee) VALUES (6, 'Dolby Cinema', 8.00);

-- Inserting into table 'Movie'

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(1, 'The Dark Knight', 'Christopher Nolan', 'English', 2008, '02:32:00', 9, 'The Dark Knight (2008), directed by Christopher Nolan, is a genre-defining superhero film that delves into themes of chaos, morality, and the complexities of heroism. The movie follows Batman (Christian Bale) as he faces the Joker (Heath Ledger), a chillingly anarchistic villain who aims to dismantle Gotham City through fear and manipulation. As the Joker pushes Batman and the citys moral boundaries to their limits, the story intertwines with the tragic fall of Harvey Dent (Aaron Eckhart), who transforms into the vengeful Two-Face. Known for its gripping narrative, intense action, and Heath Ledgers Oscar-winning portrayal, the film redefined superhero cinema as a dark, psychological thriller complemented by Hans Zimmers evocative score and stunning cinematography.', 'https://www.youtube.com/embed/EXeTwQWrcwY?si=ZMBW7Y-W88cDaEGu', 1, 1, 13);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(2, 'Inception', 'Christopher Nolan', 'English', 2010, '02:28:00', 8, 'Inception (2010), directed by Christopher Nolan, is a mind-bending science fiction thriller that explores the boundaries between dreams and reality. The film follows Dom Cobb (Leonardo DiCaprio), a skilled thief who specializes in extraction—the process of stealing secrets from deep within a persons subconscious during their dreams. Cobb is offered a chance to have his past crimes forgiven if he can successfully perform an inception, planting an idea into someones mind without them realizing it. As Cobb assembles a team to carry out the complex mission, the layers of dreams within dreams begin to blur, challenging the characters perceptions of reality. The film is renowned for its intricate narrative structure, stunning visual effects, and its exploration of memory, guilt, and the human psyche, leaving audiences questioning the nature of reality itself.', 'https://www.youtube.com/embed/YoHD9XEInc0?si=WSR7T1zZsWyPUPBu', 12, 2, 13);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(3, 'Toy Story', 'John Lasseter', 'English', 1995, '01:21:00', 8, 'Toy Story (1995), directed by John Lasseter, is a groundbreaking animated film that brought to life a world where toys come to life when humans arent around. The story centers on Woody (voiced by Tom Hanks), a cowboy doll and the beloved leader of a group of toys owned by young Andy. When Andy receives a new, flashy space ranger toy named Buzz Lightyear (voiced by Tim Allen), Woodys place as the favorite toy is threatened, leading to a rivalry between the two. However, when both toys find themselves lost outside, they must work together to find their way back home. Known for its innovative animation and heartfelt storytelling, Toy Story explores themes of friendship, loyalty, and the fear of being replaced, making it a beloved classic for all ages.', 'https://www.youtube.com/embed/v-PjgYDrg70?si=kGVkuHosvV4Emsrs', 10, 1, 3);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(4, 'The Good, the Bad and the Ugly', 'Sergio Leone', 'Italian', 1966, '02:41:00', 9, 'The Good, the Bad and the Ugly (1966), directed by Sergio Leone, is a seminal Spaghetti Western that redefined the genre with its iconic characters and intense style. The film follows three gunslingers—Blondie (Clint Eastwood), a morally ambiguous hero; Angel Eyes (Lee Van Cleef), a ruthless bounty hunter; and Tuco (Eli Wallach), a cunning outlaw—as they pursue a hidden stash of gold during the American Civil War. The film is renowned for its epic score by Ennio Morricone, its stylized cinematography, and its tense, slow-building confrontations. Through its iconic "Mexican standoff" sequences and exploration of moral ambiguity, The Good, the Bad and the Ugly became a defining classic of the Western genre, blending action, suspense, and a unique anti-hero perspective.', 'https://www.youtube.com/embed/J9EZGHcu3E8?si=8S4DEzoMjdqB2OZp', 2, 1, 16);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(5, 'Schindler''s List', 'Steven Spielberg', 'English', 1993, '03:15:00', 9, 'Schindlers List (1993), directed by Steven Spielberg, is a powerful and haunting historical drama based on the true story of Oskar Schindler, a German businessman who saved the lives of over a thousand Jewish refugees during the Holocaust. Set against the backdrop of World War II and the horrors of Nazi-occupied Poland, the film follows Schindlers transformation from a profit-driven opportunist to a compassionate protector of Jews, using his factory as a means to shield them from the brutalities of the Holocaust. With a stark black-and-white cinematography and a moving score by John Williams, Schindlers List stands as a testament to human courage, resilience, and the impact one individual can have in the face of overwhelming evil. The films emotional depth and historical significance earned it numerous accolades, including seven Academy Awards, solidifying its place as one of the most important films ever made.', 'https://www.youtube.com/embed/gG22XNhtnoY?si=YlEUkr2-40yS8WcC', 5, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(6, 'Mad Max: Fury Road', 'George Miller', 'English', 2015, '02:00:00', 8, 'Mad Max: Fury Road (2015), directed by George Miller, is a high-octane, visually stunning action film set in a post-apocalyptic wasteland. The story follows Max Rockatansky (Tom Hardy), a lone drifter haunted by his past, who becomes entangled in a high-speed chase for survival when he joins forces with Furiosa (Charlize Theron), a warrior seeking to escape a tyrannical warlord. The films plot revolves around their desperate escape from Immortan Joe, a brutal leader who controls the remaining resources in a world ravaged by war and environmental collapse. Known for its relentless action, practical effects, and minimal dialogue, Fury Road is a relentless, immersive experience that redefines the action genre. With its themes of freedom, survival, and resistance, the film was lauded for its feminist undertones and won multiple Academy Awards, cementing its place as a modern cinematic masterpiece.', 'https://www.youtube.com/embed/hEJnMQG9ev8?si=2KRrId7NLVOJt3eb', 1, 2, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(7, 'The Matrix', 'Lana Wachowski', 'English', 1999, '02:16:00', 9, '"The Matrix" (1999), directed by the Wachowskis, is a groundbreaking science fiction film that explores the nature of reality, artificial intelligence, and human consciousness. The story follows Neo (Keanu Reeves), a hacker who discovers that the world he lives in is actually a simulated reality created by sentient machines to subdue humanity while using their bodies as an energy source. Guided by a group of rebels led by Morpheus (Laurence Fishburne), Neo is thrust into a fight to free humanity and confront the machines. Known for its innovative visual effects, particularly the use of "bullet time," and its philosophical themes, *The Matrix* became a cultural touchstone, blending action, cyberpunk aesthetics, and deep existential questions. The films influence continues to shape modern cinema, particularly in the realms of science fiction and action.', 'https://www.youtube.com/embed/9ix7TUGVYIo?si=MWzDWLjo8XRVxyfz', 14, 1, 16);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(8, 'Avengers: Endgame', 'Anthony Russo', 'English', 2019, '03:01:00', 9, 'Avengers: Endgame (2019), directed by Anthony and Joe Russo, is the epic conclusion to the Marvel Cinematic Universes Infinity Saga. The film follows the surviving members of the Avengers as they grapple with the aftermath of *Avengers: Infinity War*, where the villain Thanos (Josh Brolin) wiped out half of all life in the universe. Determined to undo the devastation, the Avengers embark on a time-traveling mission to collect the Infinity Stones from different points in the past and prevent Thanos from carrying out his destructive plan. With its mix of emotional depth, character arcs, and spectacular action sequences, *Endgame* serves as a culmination of over a decade of interconnected storytelling. The film became a global phenomenon, breaking box office records and delivering a heartfelt farewell to key characters while setting the stage for the future of the Marvel franchise.', 'https://www.youtube.com/embed/TcMBFSGVi1c?si=6JpGxZu26UfXZn8S', 1, 2, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(9, 'The Godfather', 'Francis Ford Coppola', 'English', 1972, '02:55:00', 9, 'The Godfather (1972), directed by Francis Ford Coppola, is a landmark crime drama that explores the complexities of power, family, and loyalty. Based on Mario Puzos novel, the film follows the Corleone family, led by the powerful and calculating patriarch Vito Corleone (Marlon Brando). As Vitos youngest son, Michael (Al Pacino), reluctantly becomes involved in the familys criminal empire, the film delves into his gradual transformation from a war hero to a ruthless mafia boss. With its unforgettable performances, intricate storytelling, and themes of loyalty, betrayal, and the American Dream, *The Godfather* became one of the greatest films ever made, winning multiple Academy Awards and influencing countless films in the crime genre. Its legacy endures, with its characters and iconic moments etched in cinematic history.', 'https://www.youtube.com/embed/UaVTIH8mujA?si=IB9j5e2k_kqSST7r', 8, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(10, 'The Exorcist', 'William Friedkin', 'English', 1973, '02:12:00', 8, 'The Exorcist (1973), directed by William Friedkin, is a chilling horror film based on William Peter Blattys novel, which is inspired by real-life events. The story follows a mother, Chris MacNeil (Ellen Burstyn), whose daughter Regan (Linda Blair) becomes mysteriously possessed by a malevolent force. Desperate to save her, Chris turns to Father Karras (Jason Miller), a priest and psychiatrist, who enlists the help of Father Merrin (Max von Sydow), an experienced exorcist. The film is renowned for its intense atmosphere, terrifying sequences, and exploration of themes such as faith, good versus evil, and the fragility of the human soul. *The Exorcist* shocked audiences with its grotesque imagery and unsettling tension, becoming one of the most iconic horror films of all time and earning multiple Academy Award nominations, including Best Picture.', 'https://www.youtube.com/embed/PIxpPMyGcpU?si=kOq6qwyAnpeLMf4M', 13, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(11, 'Finding Nemo', 'Andrew Stanton', 'English', 2003, '01:40:00', 8, 'Finding Nemo (2003), directed by Andrew Stanton, is a heartwarming animated adventure from Pixar that follows the journey of Marlin, a clownfish, as he searches for his lost son, Nemo. After Nemo is captured by a diver and placed in a fish tank in a dentists office, Marlin embarks on a perilous voyage across the ocean, joined by the forgetful but optimistic fish Dory (voiced by Ellen DeGeneres). Along the way, Marlin encounters various sea creatures, learning lessons about trust, friendship, and letting go. With its stunning underwater visuals, memorable characters, and themes of love and resilience, *Finding Nemo* became a critical and commercial success, winning the Academy Award for Best Animated Feature and capturing the hearts of audiences worldwide.', 'https://www.youtube.com/embed/SPHfeNgogVs?si=RrWjOw0FPk5QjQIB', 10, 1, 3);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(12, 'Pulp Fiction', 'Quentin Tarantino', 'English', 1994, '02:34:00', 9, 'Pulp Fiction (1994), directed by Quentin Tarantino, is a revolutionary film that blends multiple interconnected stories within the criminal underworld of Los Angeles. Known for its non-linear narrative, the film weaves together the lives of hitmen Vincent Vega (John Travolta) and Jules Winnfield (Samuel L. Jackson), a troubled gangsters wife (Uma Thurman), and a couple of small-time robbers (Tim Roth and Amanda Plummer). Through sharp dialogue, dark humor, and iconic scenes, *Pulp Fiction* redefined the crime genre and became a cultural touchstone. The films unique structure, memorable performances, and eclectic soundtrack earned it widespread critical acclaim, including the Palme dOr at the Cannes Film Festival, and cemented Tarantinos reputation as one of the most influential filmmakers of his generation.', 'https://www.youtube.com/embed/tGpTpVyI_OQ?si=zlZ1qOo9-Cys6qi0', 8, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(13, 'The Lord of the Rings: The Fellowship of the Ring', 'Peter Jackson', 'English', 2001, '03:48:00', 9, 'The Lord of the Rings: The Fellowship of the Ring (2001), directed by Peter Jackson, is the epic first installment of J.R.R. Tolkiens fantasy trilogy. The film follows the journey of Frodo Baggins (Elijah Wood), a young hobbit tasked with destroying the One Ring, a powerful artifact that threatens the world of Middle-earth. Along with a diverse group of allies—including Aragorn (Viggo Mortensen), Gandalf (Ian McKellen), Legolas (Orlando Bloom), and Gimli (John Rhys-Davies)—Frodo must traverse dangerous lands while evading the forces of the dark lord Sauron. *The Fellowship of the Ring* is celebrated for its stunning visuals, memorable characters, and immersive world-building. The films themes of friendship, sacrifice, and the battle between good and evil set the stage for an unforgettable cinematic journey, making it a critical and commercial success.', 'https://www.youtube.com/embed/V75dMMIW2B4?si=qPq7zB3rAa-Pw7ob', 15, 1, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(14, 'Star Wars: A New Hope', 'George Lucas', 'English', 1977, '02:01:00', 9, 'Star Wars: A New Hope (1977), directed by George Lucas, is the groundbreaking science fiction epic that introduced audiences to the iconic Star Wars universe. The film follows Luke Skywalker (Mark Hamill), a young farm boy who becomes involved in the Rebel Alliances fight against the oppressive Galactic Empire. With the help of allies like Princess Leia (Carrie Fisher), Han Solo (Harrison Ford), and the wise Jedi Master Obi-Wan Kenobi (Alec Guinness), Luke embarks on a daring mission to rescue Leia and destroy the Empires ultimate weapon, the Death Star. *A New Hope* revolutionized filmmaking with its innovative special effects, memorable characters, and timeless themes of heroism, hope, and the battle between good and evil. The films success launched a global phenomenon, changing the landscape of cinema and pop culture forever.', 'https://www.youtube.com/embed/vZ734NWnAHA?si=yDwWg0vn3rUOs4HL', 14, 2, 8);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(15, 'Jurassic Park', 'Steven Spielberg', 'English', 1993, '02:07:00', 8, 'Jurassic Park (1993), directed by Steven Spielberg, is a groundbreaking science fiction adventure film that brought dinosaurs to life in stunning detail using cutting-edge visual effects. The story is set on Isla Nublar, an island where billionaire industrialist John Hammond (Richard Attenborough) has created a theme park filled with genetically resurrected dinosaurs. When a group of scientists, including Dr. Alan Grant (Sam Neill) and Dr. Ellie Sattler (Laura Dern), visit the island for a tour, things quickly spiral out of control as the parks security systems fail, and the dinosaurs escape. *Jurassic Park* is renowned for its thrilling action, unforgettable dinosaur sequences, and exploration of themes surrounding human arrogance and the unpredictability of scientific experimentation. The film became a massive box office hit and remains a landmark in both the adventure genre and visual effects innovation.', 'https://www.youtube.com/embed/E8WaFvwtphY?si=HEz2xuHI2CnE_EzK', 14, 1, 10);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(16, 'Alien', 'Ridley Scott', 'English', 1979, '01:57:00', 8, 'Alien (1979), directed by Ridley Scott, is a seminal science fiction horror film that combines intense suspense with the terror of the unknown. The story follows the crew of the commercial space tug Nostromo, who encounter a deadly extraterrestrial lifeform after responding to a distress signal from a remote planet. When the creature, known as the Xenomorph, begins to hunt them one by one, the crew must find a way to survive as they fight against both the alien and their own mounting fears. *Alien* is renowned for its chilling atmosphere, strong performances—particularly Sigourney Weaver as the resourceful Ellen Ripley—and its masterful blend of horror and sci-fi. The film redefined both genres and became a cultural touchstone, sparking numerous sequels, prequels, and a legacy of iconic characters and terrifying creatures.', 'https://www.youtube.com/embed/OzY2r2JXsDM?si=qZXziVTjlQNR_FuD', 13, 2, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(17, 'Blade Runner', 'Ridley Scott', 'English', 1982, '01:57:00', 8, 'Blade Runner (1982), directed by Ridley Scott, is a dystopian science fiction film based on Philip K. Dicks novel *Do Androids Dream of Electric Sheep?*. Set in a dark, rain-soaked future Los Angeles, the story follows Rick Deckard (Harrison Ford), a retired "blade runner" tasked with hunting down and "retiring" rogue replicants—biologically engineered beings virtually indistinguishable from humans. As Deckard confronts these advanced, emotionally complex beings, he begins to question the nature of humanity, identity, and morality. Known for its stunning cinematography, atmospheric world-building, and a haunting score by Vangelis, *Blade Runner* explores profound philosophical themes about life, consciousness, and artificial intelligence. Initially met with mixed reviews, it has since become a cult classic, widely regarded as one of the greatest films ever made.', 'https://www.youtube.com/embed/eogpIG53Cis?si=mlMkkhWiGbu-rL5i', 14, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(18, 'The Silence of the Lambs', 'Jonathan Demme', 'English', 1991, '01:58:00', 9, 'The Silence of the Lambs (1991), directed by Jonathan Demme, is a psychological horror thriller that follows FBI trainee Clarice Starling (Jodie Foster) as she seeks the help of imprisoned cannibalistic serial killer Dr. Hannibal Lecter (Anthony Hopkins) to catch another murderer, Buffalo Bill. As Starling develops a complex relationship with Lecter, who manipulates her while providing cryptic clues, she must navigate the dark, unsettling world of criminal psychology to prevent more killings. Known for its chilling performances, particularly Hopkins portrayal of the charismatic yet terrifying Lecter, *The Silence of the Lambs* became a landmark film in the thriller genre. It won five Academy Awards, including Best Picture, Best Director, and Best Actor for Hopkins, and remains one of the most influential films in cinematic history.', 'https://www.youtube.com/embed/6iB21hsprAQ?si=0LiS7DnlrC4IFFUO', 12, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(19, 'Interstellar', 'Christopher Nolan', 'English', 2014, '02:49:00', 8, 'Interstellar (2014), directed by Christopher Nolan, is a visually stunning science fiction epic that explores themes of love, sacrifice, and the survival of humanity. The film is set in a near-future Earth, where environmental collapse threatens human life. Cooper (Matthew McConaughey), a former NASA pilot, is recruited to lead a space mission through a wormhole in search of a new habitable planet for mankind. Alongside a team of astronauts, Cooper ventures into deep space, facing time dilation, black holes, and existential questions about the nature of the universe. *Interstellar* combines breathtaking visuals, Hans Zimmers emotional score, and complex scientific concepts, including relativity and the fifth dimension, to create a thought-provoking narrative. The films exploration of human resilience and the connection between past, present, and future resonated deeply with audiences, solidifying its place as a modern science fiction masterpiece.', 'https://www.youtube.com/embed/UDVtMYqUAyw?si=ufJ7etrLXe_O1dhf', 14, 2, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(20, 'Forrest Gump', 'Robert Zemeckis', 'English', 1994, '02:22:00', 8, 'Forrest Gump (1994), directed by Robert Zemeckis, is a heartwarming drama that follows the extraordinary life of Forrest Gump (Tom Hanks), a man with a low IQ but a kind heart, who unwittingly influences several pivotal moments in American history. The film spans decades, showcasing Forrests involvement in key events such as the Vietnam War, the Civil Rights Movement, and the rise of the shrimp industry, all while he remains devoted to his childhood love, Jenny (Robin Wright). Through its unique storytelling, *Forrest Gump* explores themes of destiny, love, and the randomness of life. The films iconic quotes, memorable characters, and Tom Hanks award-winning performance made it a cultural touchstone, earning numerous accolades, including six Academy Awards, and securing its place as one of the most beloved films of all time.', 'https://www.youtube.com/embed/bLvqoHBptjg?si=5DfxnijId-4P8spE', 5, 1, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(21, 'Gladiator', 'Ridley Scott', 'English', 2000, '02:35:00', 8, 'Gladiator (2000), directed by Ridley Scott, is an epic historical drama set in ancient Rome. The film follows Maximus (Russell Crowe), a skilled general who is betrayed and reduced to slavery after the murder of his family and the emperor, Marcus Aurelius. Forced to fight as a gladiator, Maximus seeks revenge against Commodus (Joaquin Phoenix), the corrupt son of the murdered emperor who has taken the throne. The film is known for its intense action sequences, powerful performances, and its exploration of themes like loyalty, vengeance, and the struggle for justice. With its grand scale and emotional depth, Gladiator became a massive box office success and won five Academy Awards, including Best Picture and Best Actor for Russell Crowe.', 'https://www.youtube.com/embed/P5ieIbInFpg?si=fqPn4Ci_xE-dsgqO', 5, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(22, 'The Shawshank Redemption', 'Frank Darabont', 'English', 1994, '02:22:00', 9, 'The Shawshank Redemption (1994), directed by Frank Darabont, is a compelling drama based on Stephen Kings novella. The film tells the story of Andy Dufresne (Tim Robbins), a banker wrongfully convicted of murdering his wife and her lover, who is sent to Shawshank prison. There, he forms a deep friendship with fellow inmate Ellis "Red" Redding (Morgan Freeman) and, over the years, becomes an integral part of the prisons community. The film explores themes of hope, resilience, and the power of friendship, as Andy works tirelessly to improve conditions for the inmates and ultimately seeks his freedom. Though initially a box office disappointment, The Shawshank Redemption has since become a beloved classic, frequently ranked among the greatest films of all time, thanks to its powerful performances and uplifting message.', 'https://www.youtube.com/embed/PLl99DlL6b4?si=u-OUlWSvQF-K0_rs', 5, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(23, 'Black Panther', 'Ryan Coogler', 'English', 2018, '02:14:00', 8, 'Black Panther (2018), directed by Ryan Coogler, is a groundbreaking superhero film that combines action, culture, and social commentary. The story follows TChalla (Chadwick Boseman), the newly crowned king of Wakanda, a technologically advanced African nation hidden from the world. After the death of his father, TChalla must confront the challenges of leadership, while facing Erik Killmonger (Michael B. Jordan), a powerful adversary with a personal vendetta and a radical vision for Wakandas role in the world. Black Panther is celebrated for its rich exploration of African culture, its complex characters, and its focus on themes of identity, responsibility, and legacy. The films cultural significance, stunning visuals, and standout performances earned it widespread acclaim and made history as the first superhero film to be nominated for Best Picture at the Academy Awards.', 'https://www.youtube.com/embed/_Z3QKkl1WyM?si=Z8zWeDluiRXT1IsV', 1, 2, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(24, 'Fight Club', 'David Fincher', 'English', 1999, '02:19:00', 8, 'Fight Club (1999), directed by David Fincher, is a dark and provocative film that explores themes of identity, consumerism, and mental instability. The story follows an unnamed protagonist (Edward Norton), a disillusioned office worker who forms a secret club where men engage in bare-knuckle fighting as a form of liberation from their monotonous lives. As the club grows, the protagonist becomes increasingly influenced by the charismatic and anarchistic Tyler Durden (Brad Pitt), whose ideas about rebellion and chaos challenge societal norms. With its famous twist ending and sharp critique of modern life, Fight Club has become a cult classic, known for its unforgettable quotes, philosophical depth, and exploration of masculinity and self-destruction. Though initially divisive, the film has since been recognized as one of the most influential films of the 1990s.', 'https://www.youtube.com/embed/qtRKdVHc-cE?si=95sWWb1pDWT5zCDr', 8, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(25, 'The Lion King', 'Roger Allers', 'English', 1994, '01:28:00', 8, 'The Lion King (1994), directed by Roger Allers and Rob Minkoff, is a beloved animated film from Disney that tells the story of Simba, a young lion prince who is destined to rule the Pride Lands. After the tragic death of his father, Mufasa, at the hands of his uncle Scar, Simba runs away, believing he is responsible. Years later, with the help of friends Timon and Pumbaa, Simba returns to reclaim his rightful place as king. The film is known for its memorable characters, stunning animation, and powerful soundtrack, including the iconic songs "Circle of Life" and "Can You Feel the Love Tonight." The Lion King explores themes of responsibility, family, and the circle of life, and remains a timeless classic that continues to resonate with audiences of all ages.', 'https://www.youtube.com/embed/GibiNy4d4gc?si=kApUktxMi4FiuMvq', 10, 1, 3);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(26, 'The Departed', 'Martin Scorsese', 'English', 2006, '02:31:00', 8, 'The Departed (2006), directed by Martin Scorsese, is a gripping crime thriller that explores themes of deception, loyalty, and betrayal. Set in Boston, the film follows two men on opposite sides of the law: Billy Costigan (Leonardo DiCaprio), an undercover cop infiltrating the Irish mob, and Colin Sullivan (Matt Damon), a mobster who has infiltrated the Massachusetts State Police. As both men struggle to maintain their cover, a tense cat-and-mouse game ensues, leading to shocking twists and violent confrontations. With an all-star cast, intense direction, and a screenplay that keeps viewers on the edge of their seats, The Departed won multiple Academy Awards, including Best Picture and Best Director, solidifying its place as a modern crime classic.', 'https://www.youtube.com/embed/iojhqm0JTW4?si=Er4FopuZb8bEqHek', 8, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(27, 'Harry Potter and the Sorcerer''s Stone', 'Chris Columbus', 'English', 2001, '02:32:00', 7, 'Harry Potter and the Sorcerers Stone (2001), directed by Chris Columbus, is the magical first film in the Harry Potter franchise, based on J.K. Rowlings bestselling book series. The story follows an orphaned young boy, Harry Potter (Daniel Radcliffe), who discovers on his 11th birthday that he is a wizard. He is taken to Hogwarts School of Witchcraft and Wizardry, where he befriends Hermione Granger (Emma Watson) and Ron Weasley (Rupert Grint), and learns about his famous past, including the mystery of his parents death and the dark wizard, Lord Voldemort. As Harry uncovers secrets about the magical world and his own destiny, he faces the challenge of stopping Voldemort from returning to power. The films enchanting world-building, strong performances, and universal themes of friendship and bravery made it a global success, starting a beloved series that would become a cultural phenomenon.', 'https://www.youtube.com/embed/VyHV0BRtdxo?si=8JijmOOCcgeQr3hE', 15, 2, 8);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(28, '12 Angry Men', 'Sidney Lumet', 'English', 1957, '01:36:00', 9, '12 Angry Men (1957), directed by Sidney Lumet, is a powerful courtroom drama that explores themes of justice, prejudice, and the complexities of human behavior. The film takes place almost entirely in a jury room, where twelve jurors must decide the fate of a young man accused of murder. Initially, the jury is almost unanimously in favor of a guilty verdict, but Juror 8 (Henry Fonda) begins to challenge their assumptions, urging them to reconsider the evidence and examine their biases. As tensions rise, the jurors personalities and prejudices come to the forefront, revealing the moral dilemmas inherent in the justice system. Known for its sharp dialogue, intense performances, and social relevance, 12 Angry Men is regarded as one of the greatest films ever made, highlighting the importance of integrity and critical thinking in the pursuit of justice.', 'https://www.youtube.com/embed/TEN-2uTi2c0?si=HiuCscamrqeQPR-j', 5, 1, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(29, 'Braveheart', 'Mel Gibson', 'English', 1995, '03:02:00', 8, 'Braveheart (1995), directed by and starring Mel Gibson, is an epic historical drama set in 13th-century Scotland. The film tells the story of William Wallace, a Scottish warrior who leads a rebellion against English rule after the brutal execution of his wife, Murron. Fueled by a desire for justice and freedom, Wallace rallies a group of Scottish peasants to fight for independence, culminating in the famous Battle of Stirling Bridge. With themes of courage, sacrifice, and the struggle for freedom, Braveheart became a cultural phenomenon, known for its iconic battle sequences, stirring speeches, and powerful performances. The film won five Academy Awards, including Best Picture and Best Director, and remains one of the most beloved historical epics in cinema.', 'https://www.youtube.com/embed/1NJO0jxBtMo?si=_7f5H_MVOpWqqOjA', 5, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(30, 'The Terminator', 'James Cameron', 'English', 1984, '01:47:00', 8, 'The Terminator (1984), directed by James Cameron, is a science fiction thriller that blends action with a chilling look at the future of artificial intelligence. The film follows Sarah Connor (Linda Hamilton), an ordinary woman who becomes the target of a relentless, time-traveling cyborg assassin (Arnold Schwarzenegger), sent from a post-apocalyptic future to kill her before she can give birth to her son, John, who will lead a human resistance against machines. As Sarahs protector, Kyle Reese (Michael Biehn), a soldier from the future, tries to stop the Terminator, the film explores themes of fate, technology, and the potential consequences of creating powerful AI. Known for its innovative special effects, suspenseful pacing, and iconic catchphrases, The Terminator launched a successful franchise and solidified Arnold Schwarzenegger as a global action star.', 'https://www.youtube.com/embed/nGrW-OR2uDk?si=MAm8MSzqRjJDpCrk', 14, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(31, 'Rocky', 'John G. Avildsen', 'English', 1976, '02:00:00', 8, 'Rocky (1976), directed by John G. Avildsen and written by Sylvester Stallone, is a compelling underdog story about a struggling boxer, Rocky Balboa. Living in a working-class neighborhood in Philadelphia, Rocky (Stallone) is given the unexpected opportunity to fight for the heavyweight title against the reigning champion, Apollo Creed (Carl Weathers). With little chance of winning, Rocky trains relentlessly, using the fight as a way to prove his worth to himself and those around him. The film is known for its inspirational themes of perseverance, self-belief, and overcoming adversity. Rockys iconic training montages, memorable lines, and emotional depth helped the film resonate with audiences, leading to widespread critical acclaim and a Best Picture Academy Award. It spawned multiple sequels and remains one of the most beloved sports films of all time.', 'https://www.youtube.com/embed/-Hk-LYcavrw?si=9ruCB5pSnTqOENe7', 12, 1, 12);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(32, 'A Beautiful Mind', 'Ron Howard', 'English', 2001, '02:15:00', 8, 'A Beautiful Mind (2001), directed by Ron Howard, is a biographical drama based on the life of mathematician John Nash, who struggled with schizophrenia while making groundbreaking contributions to the field of mathematics. The film stars Russell Crowe as Nash, whose brilliant yet troubled mind leads him to experience hallucinations and paranoia, severely affecting his relationships and career. As he battles the effects of his illness, Nashs wife, Alicia (Jennifer Connelly), stands by him, offering support and love. A Beautiful Mind explores themes of genius, mental illness, and the power of perseverance, ultimately showcasing Nashs triumphs as he wins the Nobel Prize in Economics. The film received widespread acclaim, winning four Academy Awards, including Best Picture and Best Director, and is praised for its sensitive portrayal of mental illness and Crowes transformative performance.', 'https://www.youtube.com/embed/EajIlG_OCvw?si=ija2DZEbP5HoQdks', 5, 1, 15);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(33, 'Casablanca', 'Michael Curtiz', 'English', 1942, '01:42:00', 9, 'Casablanca (1942), directed by Michael Curtiz, is a classic romantic drama set during World War II in the Vichy-controlled Moroccan city of Casablanca. The film stars Humphrey Bogart as Rick Blaine, a cynical American expatriate who owns a nightclub, and Ingrid Bergman as Ilsa Lund, his former lover. When Ilsa and her husband, Victor Laszlo (Paul Henreid), a resistance leader, arrive in Casablanca, Rick is forced to choose between his personal feelings for Ilsa and doing the right thing by helping her and Laszlo escape from the Nazis. Known for its memorable lines, unforgettable performances, and themes of sacrifice and patriotism, Casablanca has become a timeless cinematic masterpiece. It won three Academy Awards, including Best Picture, and remains one of the most beloved films in movie history.', 'https://www.youtube.com/embed/VHBcS0fYWfc?si=nx1HFkQP8tG0Ih28', 5, 1, 8);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(34, 'The Shining', 'Stanley Kubrick', 'English', 1980, '02:26:00', 8, 'The Shining (1980), directed by Stanley Kubrick, is a psychological horror film based on Stephen Kings novel. The story follows Jack Torrance (Jack Nicholson), an aspiring writer who accepts a job as the winter caretaker of the remote Overlook Hotel in Colorado. He moves there with his wife Wendy (Shelley Duvall) and young son Danny (Danny Lloyd), who has psychic abilities that allow him to see the hotels dark past. As the isolation and supernatural forces begin to affect Jacks sanity, he descends into violent madness, putting his family in danger. The Shining is renowned for its unsettling atmosphere, iconic imagery, and complex exploration of isolation, mental deterioration, and the supernatural. Though initially divisive, the film has become a cult classic, widely regarded as one of the greatest horror films ever made.', 'https://www.youtube.com/embed/FZQvIJxG9Xs?si=HGbTMLGj0hz5QVKp', 13, 1, 18);

INSERT INTO Movie (Movie_ID, Title, Director, Language, Year, Duration, Rating, Description, TrailerLink, Genre_ID, Version_ID, AgeLimit) VALUES 
(35, 'Indiana Jones and the Last Crusade', 'Steven Spielberg', 'English', 1989, '02:07:00', 8, 'Indiana Jones and the Last Crusade (1989), directed by Steven Spielberg, is the third installment in the iconic action-adventure series. The film follows archaeologist Indiana Jones (Harrison Ford) as he embarks on a quest to find the Holy Grail, a legendary artifact believed to grant eternal life. His search takes him across Europe, where he is joined by his estranged father, Henry Jones Sr. (Sean Connery), a renowned scholar who has been missing for years. As they face Nazi agents, treacherous traps, and ancient puzzles, the film explores themes of father-son relationships, adventure, and the pursuit of knowledge. With its perfect blend of action, humor, and heart, *The Last Crusade* is considered one of the best films in the Indiana Jones series, offering a thrilling and emotional conclusion to the trilogy.', 'https://www.youtube.com/embed/DKg36LBVgfg?si=ycMV5NduMRSqwAfi', 11, 1, 12);

-- Inserting into table 'LandingMovies'

INSERT INTO LandingMovies (LandingMovie_ID, Movie_ID, DisplayOrder)
VALUES
    (1, 32, 1),
    (2, 3, 2),
    (3, 33, 3);

-- Inserting into table 'Coupon'

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

-- Inserting into table 'CinemaHall'

INSERT INTO CinemaHall (CinemaHall_ID, Name, TotalSeats) VALUES (1, 'Hall 1', 120);
INSERT INTO CinemaHall (CinemaHall_ID, Name, TotalSeats) VALUES (2, 'Hall 2', 150);
INSERT INTO CinemaHall (CinemaHall_ID, Name, TotalSeats) VALUES (3, 'Hall 3', 180);
INSERT INTO CinemaHall (CinemaHall_ID, Name, TotalSeats) VALUES (4, 'Hall 4', 100);

-- Inserting into table 'Screening'

-- Week 3: 2024-12-17 to 2025-01-22
INSERT INTO Screening (Screening_ID, ShowDate, ShowTime, CinemaHall_ID, Movie_ID) VALUES

-- 2024-12-17
(106, '2024-12-17', '10:00:00', 1, 1),
(107, '2024-12-17', '14:00:00', 1, 2),
(108, '2024-12-17', '18:00:00', 1, 3),
(109, '2024-12-17', '22:00:00', 1, 4),
(110, '2024-12-17', '10:15:00', 2, 5),
(111, '2024-12-17', '14:15:00', 2, 6),
(112, '2024-12-17', '18:15:00', 2, 7),
(113, '2024-12-17', '22:15:00', 2, 1),
(114, '2024-12-17', '11:00:00', 3, 2),
(115, '2024-12-17', '15:00:00', 3, 3),
(116, '2024-12-17', '19:00:00', 3, 4),
(117, '2024-12-17', '23:00:00', 3, 5),
(118, '2024-12-17', '10:30:00', 4, 6),
(119, '2024-12-17', '14:30:00', 4, 7),
(120, '2024-12-17', '18:30:00', 4, 1),

-- 2024-12-18
(121, '2024-12-18', '10:00:00', 1, 2),
(122, '2024-12-18', '14:00:00', 1, 3),
(123, '2024-12-18', '18:00:00', 1, 4),
(124, '2024-12-18', '22:00:00', 1, 5),
(125, '2024-12-18', '10:15:00', 2, 6),
(126, '2024-12-18', '14:15:00', 2, 7),
(127, '2024-12-18', '18:15:00', 2, 1),
(128, '2024-12-18', '22:15:00', 2, 2),
(129, '2024-12-18', '11:00:00', 3, 3),
(130, '2024-12-18', '15:00:00', 3, 4),
(131, '2024-12-18', '19:00:00', 3, 5),
(132, '2024-12-18', '23:00:00', 3, 6),
(133, '2024-12-18', '10:30:00', 4, 7),
(134, '2024-12-18', '14:30:00', 4, 1),
(135, '2024-12-18', '18:30:00', 4, 2),

-- Incrementing Dates: 2024-12-19 to 2025-01-22
-- 2024-12-19
(136, '2024-12-19', '10:00:00', 1, 3),
(137, '2024-12-19', '14:00:00', 1, 4),
(138, '2024-12-19', '18:00:00', 1, 5),
(139, '2024-12-19', '22:00:00', 1, 6),
(140, '2024-12-19', '10:15:00', 2, 7),
(141, '2024-12-19', '14:15:00', 2, 1),
(142, '2024-12-19', '18:15:00', 2, 2),
(143, '2024-12-19', '22:15:00', 2, 3),
(144, '2024-12-19', '11:00:00', 3, 4),
(145, '2024-12-19', '15:00:00', 3, 5),
(146, '2024-12-19', '19:00:00', 3, 6),
(147, '2024-12-19', '23:00:00', 3, 7),
(148, '2024-12-19', '10:30:00', 4, 1),
(149, '2024-12-19', '14:30:00', 4, 2),
(150, '2024-12-19', '18:30:00', 4, 3),

-- Continuing Screening Inserts from 2024-12-20 to 2025-01-22

-- 2024-12-20
(151, '2024-12-20', '10:00:00', 1, 4),
(152, '2024-12-20', '14:00:00', 1, 5),
(153, '2024-12-20', '18:00:00', 1, 6),
(154, '2024-12-20', '22:00:00', 1, 7),
(155, '2024-12-20', '10:15:00', 2, 1),
(156, '2024-12-20', '14:15:00', 2, 2),
(157, '2024-12-20', '18:15:00', 2, 3),
(158, '2024-12-20', '22:15:00', 2, 4),
(159, '2024-12-20', '09:00:00', 3, 5),
(160, '2024-12-20', '13:00:00', 3, 6),
(161, '2024-12-20', '17:00:00', 3, 7),
(162, '2024-12-20', '21:00:00', 3, 1),
(163, '2024-12-20', '10:30:00', 4, 2),
(164, '2024-12-20', '14:30:00', 4, 3),
(165, '2024-12-20', '18:30:00', 4, 4),

-- 2024-12-21
(166, '2024-12-21', '09:00:00', 1, 5),
(167, '2024-12-21', '13:00:00', 1, 6),
(168, '2024-12-21', '17:00:00', 1, 7),
(169, '2024-12-21', '21:00:00', 1, 1),
(170, '2024-12-21', '10:15:00', 2, 2),
(171, '2024-12-21', '14:15:00', 2, 3),
(172, '2024-12-21', '18:15:00', 2, 4),
(173, '2024-12-21', '22:15:00', 2, 5),
(174, '2024-12-21', '11:00:00', 3, 6),
(175, '2024-12-21', '15:00:00', 3, 7),
(176, '2024-12-21', '19:00:00', 3, 1),
(177, '2024-12-21', '23:00:00', 3, 2),
(178, '2024-12-21', '10:30:00', 4, 3),
(179, '2024-12-21', '14:30:00', 4, 4),
(180, '2024-12-21', '18:30:00', 4, 5),

-- 2024-12-22
(181, '2024-12-22', '10:00:00', 1, 6),
(182, '2024-12-22', '14:00:00', 1, 7),
(183, '2024-12-22', '18:00:00', 1, 1),
(184, '2024-12-22', '22:00:00', 1, 2),
(185, '2024-12-22', '10:15:00', 2, 3),
(186, '2024-12-22', '14:15:00', 2, 4),
(187, '2024-12-22', '18:15:00', 2, 5),
(188, '2024-12-22', '22:15:00', 2, 6),
(189, '2024-12-22', '11:00:00', 3, 7),
(190, '2024-12-22', '15:00:00', 3, 1),
(191, '2024-12-22', '19:00:00', 3, 2),
(192, '2024-12-22', '23:00:00', 3, 3),
(193, '2024-12-22', '10:30:00', 4, 4),
(194, '2024-12-22', '14:30:00', 4, 5),
(195, '2024-12-22', '18:30:00', 4, 6),

-- 2024-12-23
(196, '2024-12-23', '10:00:00', 1, 7),
(197, '2024-12-23', '14:00:00', 1, 1),
(198, '2024-12-23', '18:00:00', 1, 2),
(199, '2024-12-23', '22:00:00', 1, 3),
(200, '2024-12-23', '10:15:00', 2, 4),
(201, '2024-12-23', '14:15:00', 2, 5),
(202, '2024-12-23', '18:15:00', 2, 6),
(203, '2024-12-23', '22:15:00', 2, 7),
(204, '2024-12-23', '11:00:00', 3, 1),
(205, '2024-12-23', '15:00:00', 3, 2),
(206, '2024-12-23', '19:00:00', 3, 3),
(207, '2024-12-23', '23:00:00', 3, 4),
(208, '2024-12-23', '10:30:00', 4, 5),
(209, '2024-12-23', '14:30:00', 4, 6),
(210, '2024-12-23', '18:30:00', 4, 7),

-- 2024-12-24
(211, '2024-12-24', '10:00:00', 1, 5),
(212, '2024-12-24', '14:00:00', 1, 6),
(213, '2024-12-24', '18:00:00', 1, 7),
(214, '2024-12-24', '22:00:00', 1, 1),
(215, '2024-12-24', '10:15:00', 2, 2),
(216, '2024-12-24', '14:15:00', 2, 3),
(217, '2024-12-24', '18:15:00', 2, 4),
(218, '2024-12-24', '22:15:00', 2, 5),
(219, '2024-12-24', '11:00:00', 3, 6),
(220, '2024-12-24', '15:00:00', 3, 7),
(221, '2024-12-24', '19:00:00', 3, 1),
(222, '2024-12-24', '23:00:00', 3, 2),
(223, '2024-12-24', '10:30:00', 4, 3),
(224, '2024-12-24', '14:30:00', 4, 4),
(225, '2024-12-24', '18:30:00', 4, 5),

-- 2024-12-25
(226, '2024-12-25', '10:00:00', 1, 6),
(227, '2024-12-25', '14:00:00', 1, 7),
(228, '2024-12-25', '18:00:00', 1, 1),
(229, '2024-12-25', '22:00:00', 1, 2),
(230, '2024-12-25', '10:15:00', 2, 3),
(231, '2024-12-25', '14:15:00', 2, 4),
(232, '2024-12-25', '18:15:00', 2, 5),
(233, '2024-12-25', '22:15:00', 2, 6),
(234, '2024-12-25', '11:00:00', 3, 7),
(235, '2024-12-25', '15:00:00', 3, 1),
(236, '2024-12-25', '19:00:00', 3, 2),
(237, '2024-12-25', '23:00:00', 3, 3),
(238, '2024-12-25', '10:30:00', 4, 4),
(239, '2024-12-25', '14:30:00', 4, 5),
(240, '2024-12-25', '18:30:00', 4, 6),

-- 2024-12-26
(241, '2024-12-26', '10:00:00', 1, 7),
(242, '2024-12-26', '14:00:00', 1, 1),
(243, '2024-12-26', '18:00:00', 1, 2),
(244, '2024-12-26', '22:00:00', 1, 3),
(245, '2024-12-26', '10:15:00', 2, 4),
(246, '2024-12-26', '14:15:00', 2, 5),
(247, '2024-12-26', '18:15:00', 2, 6),
(248, '2024-12-26', '22:15:00', 2, 7),
(249, '2024-12-26', '11:00:00', 3, 1),
(250, '2024-12-26', '15:00:00', 3, 2),
(251, '2024-12-26', '19:00:00', 3, 3),
(252, '2024-12-26', '23:00:00', 3, 4),
(253, '2024-12-26', '10:30:00', 4, 5),
(254, '2024-12-26', '14:30:00', 4, 6),
(255, '2024-12-26', '18:30:00', 4, 7),

-- 2024-12-27
(256, '2024-12-27', '10:00:00', 1, 1),
(257, '2024-12-27', '14:00:00', 1, 2),
(258, '2024-12-27', '18:00:00', 1, 3),
(259, '2024-12-27', '22:00:00', 1, 4),
(260, '2024-12-27', '10:15:00', 2, 5),
(261, '2024-12-27', '14:15:00', 2, 6),
(262, '2024-12-27', '18:15:00', 2, 7),
(263, '2024-12-27', '22:15:00', 2, 1),
(264, '2024-12-27', '11:00:00', 3, 2),
(265, '2024-12-27', '15:00:00', 3, 3),
(266, '2024-12-27', '19:00:00', 3, 4),
(267, '2024-12-27', '23:00:00', 3, 5),
(268, '2024-12-27', '10:30:00', 4, 6),
(269, '2024-12-27', '14:30:00', 4, 7),
(270, '2024-12-27', '18:30:00', 4, 1),

-- 2024-12-28
(271, '2024-12-28', '10:00:00', 1, 8),
(272, '2024-12-28', '14:00:00', 1, 9),
(273, '2024-12-28', '18:00:00', 1, 10),
(274, '2024-12-28', '22:00:00', 1, 11),
(275, '2024-12-28', '10:15:00', 2, 12),
(276, '2024-12-28', '14:15:00', 2, 13),
(277, '2024-12-28', '18:15:00', 2, 14),
(278, '2024-12-28', '22:15:00', 2, 8),
(279, '2024-12-28', '11:00:00', 3, 9),
(280, '2024-12-28', '15:00:00', 3, 10),
(281, '2024-12-28', '19:00:00', 3, 11),
(282, '2024-12-28', '23:00:00', 3, 12),
(283, '2024-12-28', '10:30:00', 4, 13),
(284, '2024-12-28', '14:30:00', 4, 14),
(285, '2024-12-28', '18:30:00', 4, 8),

-- 2024-12-29
(286, '2024-12-29', '10:00:00', 1, 9),
(287, '2024-12-29', '14:00:00', 1, 10),
(288, '2024-12-29', '18:00:00', 1, 11),
(289, '2024-12-29', '22:00:00', 1, 12),
(290, '2024-12-29', '10:15:00', 2, 13),
(291, '2024-12-29', '14:15:00', 2, 14),
(292, '2024-12-29', '18:15:00', 2, 8),
(293, '2024-12-29', '22:15:00', 2, 9),
(294, '2024-12-29', '11:00:00', 3, 10),
(295, '2024-12-29', '15:00:00', 3, 11),
(296, '2024-12-29', '19:00:00', 3, 12),
(297, '2024-12-29', '23:00:00', 3, 13),
(298, '2024-12-29', '10:30:00', 4, 14),
(299, '2024-12-29', '14:30:00', 4, 8),
(300, '2024-12-29', '18:30:00', 4, 9),

-- 2024-12-30
(301, '2024-12-30', '10:00:00', 1, 10),
(302, '2024-12-30', '14:00:00', 1, 11),
(303, '2024-12-30', '18:00:00', 1, 12),
(304, '2024-12-30', '22:00:00', 1, 13),
(305, '2024-12-30', '10:15:00', 2, 14),
(306, '2024-12-30', '14:15:00', 2, 8),
(307, '2024-12-30', '18:15:00', 2, 9),
(308, '2024-12-30', '22:15:00', 2, 10),
(309, '2024-12-30', '11:00:00', 3, 11),
(310, '2024-12-30', '15:00:00', 3, 12),
(311, '2024-12-30', '19:00:00', 3, 13),
(312, '2024-12-30', '23:00:00', 3, 14),
(313, '2024-12-30', '10:30:00', 4, 8),
(314, '2024-12-30', '14:30:00', 4, 9),
(315, '2024-12-30', '18:30:00', 4, 10),

-- 2024-12-31
(316, '2024-12-31', '10:00:00', 1, 11),
(317, '2024-12-31', '14:00:00', 1, 12),
(318, '2024-12-31', '18:00:00', 1, 13),
(319, '2024-12-31', '22:00:00', 1, 14),
(320, '2024-12-31', '10:15:00', 2, 8),
(321, '2024-12-31', '14:15:00', 2, 9),
(322, '2024-12-31', '18:15:00', 2, 10),
(323, '2024-12-31', '22:15:00', 2, 11),
(324, '2024-12-31', '11:00:00', 3, 12),
(325, '2024-12-31', '15:00:00', 3, 13),
(326, '2024-12-31', '19:00:00', 3, 14),
(327, '2024-12-31', '23:00:00', 3, 8),
(328, '2024-12-31', '10:30:00', 4, 9),
(329, '2024-12-31', '14:30:00', 4, 10),
(330, '2024-12-31', '18:30:00', 4, 11),

-- 2025-01-01
(331, '2025-01-01', '10:00:00', 1, 12),
(332, '2025-01-01', '14:00:00', 1, 13),
(333, '2025-01-01', '18:00:00', 1, 14),
(334, '2025-01-01', '22:00:00', 1, 8),
(335, '2025-01-01', '10:15:00', 2, 9),
(336, '2025-01-01', '14:15:00', 2, 10),
(337, '2025-01-01', '18:15:00', 2, 11),
(338, '2025-01-01', '22:15:00', 2, 12),
(339, '2025-01-01', '11:00:00', 3, 13),
(340, '2025-01-01', '15:00:00', 3, 14),
(341, '2025-01-01', '19:00:00', 3, 8),
(342, '2025-01-01', '23:00:00', 3, 9),
(343, '2025-01-01', '10:30:00', 4, 10),
(344, '2025-01-01', '14:30:00', 4, 11),
(345, '2025-01-01', '18:30:00', 4, 12),

-- 2025-01-02
(346, '2025-01-02', '10:00:00', 1, 13),
(347, '2025-01-02', '14:00:00', 1, 14),
(348, '2025-01-02', '18:00:00', 1, 8),
(349, '2025-01-02', '22:00:00', 1, 9),
(350, '2025-01-02', '10:15:00', 2, 10),
(351, '2025-01-02', '14:15:00', 2, 11),
(352, '2025-01-02', '18:15:00', 2, 12),
(353, '2025-01-02', '22:15:00', 2, 13),
(354, '2025-01-02', '11:00:00', 3, 14),
(355, '2025-01-02', '15:00:00', 3, 8),
(356, '2025-01-02', '19:00:00', 3, 9),
(357, '2025-01-02', '23:00:00', 3, 10),
(358, '2025-01-02', '10:30:00', 4, 11),
(359, '2025-01-02', '14:30:00', 4, 12),
(360, '2025-01-02', '18:30:00', 4, 13),

-- 2025-01-03
(361, '2025-01-03', '10:00:00', 1, 14),
(362, '2025-01-03', '14:00:00', 1, 8),
(363, '2025-01-03', '18:00:00', 1, 9),
(364, '2025-01-03', '22:00:00', 1, 10),
(365, '2025-01-03', '10:15:00', 2, 11),
(366, '2025-01-03', '14:15:00', 2, 12),
(367, '2025-01-03', '18:15:00', 2, 13),
(368, '2025-01-03', '22:15:00', 2, 14),
(369, '2025-01-03', '11:00:00', 3, 8),
(370, '2025-01-03', '15:00:00', 3, 9),
(371, '2025-01-03', '19:00:00', 3, 10),
(372, '2025-01-03', '23:00:00', 3, 11),
(373, '2025-01-03', '10:30:00', 4, 12),
(374, '2025-01-03', '14:30:00', 4, 13),
(375, '2025-01-03', '18:30:00', 4, 14),

-- 2025-01-04
(376, '2025-01-04', '10:00:00', 1, 8),
(377, '2025-01-04', '14:00:00', 1, 9),
(378, '2025-01-04', '18:00:00', 1, 10),
(379, '2025-01-04', '22:00:00', 1, 11),
(380, '2025-01-04', '10:15:00', 2, 12),
(381, '2025-01-04', '14:15:00', 2, 13),
(382, '2025-01-04', '18:15:00', 2, 14),
(383, '2025-01-04', '22:15:00', 2, 8),
(384, '2025-01-04', '11:00:00', 3, 9),
(385, '2025-01-04', '15:00:00', 3, 10),
(386, '2025-01-04', '19:00:00', 3, 11),
(387, '2025-01-04', '23:00:00', 3, 12),
(388, '2025-01-04', '10:30:00', 4, 13),
(389, '2025-01-04', '14:30:00', 4, 14),
(390, '2025-01-04', '18:30:00', 4, 8),

-- 2025-01-05
(391, '2025-01-05', '10:00:00', 1, 15),
(392, '2025-01-05', '14:00:00', 1, 16),
(393, '2025-01-05', '18:00:00', 1, 17),
(394, '2025-01-05', '22:00:00', 1, 18),
(395, '2025-01-05', '10:15:00', 2, 19),
(396, '2025-01-05', '14:15:00', 2, 20),
(397, '2025-01-05', '18:15:00', 2, 21),
(398, '2025-01-05', '22:15:00', 2, 15),
(399, '2025-01-05', '11:00:00', 3, 16),
(400, '2025-01-05', '15:00:00', 3, 17),
(401, '2025-01-05', '19:00:00', 3, 18),
(402, '2025-01-05', '23:00:00', 3, 19),
(403, '2025-01-05', '10:30:00', 4, 20),
(404, '2025-01-05', '14:30:00', 4, 21),
(405, '2025-01-05', '18:30:00', 4, 15),

-- 2025-01-06
(406, '2025-01-06', '10:00:00', 1, 16),
(407, '2025-01-06', '14:00:00', 1, 17),
(408, '2025-01-06', '18:00:00', 1, 18),
(409, '2025-01-06', '22:00:00', 1, 19),
(410, '2025-01-06', '10:15:00', 2, 20),
(411, '2025-01-06', '14:15:00', 2, 21),
(412, '2025-01-06', '18:15:00', 2, 15),
(413, '2025-01-06', '22:15:00', 2, 16),
(414, '2025-01-06', '11:00:00', 3, 17),
(415, '2025-01-06', '15:00:00', 3, 18),
(416, '2025-01-06', '19:00:00', 3, 19),
(417, '2025-01-06', '23:00:00', 3, 20),
(418, '2025-01-06', '10:30:00', 4, 21),
(419, '2025-01-06', '14:30:00', 4, 15),
(420, '2025-01-06', '18:30:00', 4, 16),

-- 2025-01-07
(421, '2025-01-07', '10:00:00', 1, 17),
(422, '2025-01-07', '14:00:00', 1, 18),
(423, '2025-01-07', '18:00:00', 1, 19),
(424, '2025-01-07', '22:00:00', 1, 20),
(425, '2025-01-07', '10:15:00', 2, 21),
(426, '2025-01-07', '14:15:00', 2, 15),
(427, '2025-01-07', '18:15:00', 2, 16),
(428, '2025-01-07', '22:15:00', 2, 17),
(429, '2025-01-07', '11:00:00', 3, 18),
(430, '2025-01-07', '15:00:00', 3, 19),
(431, '2025-01-07', '19:00:00', 3, 20),
(432, '2025-01-07', '23:00:00', 3, 21),
(433, '2025-01-07', '10:30:00', 4, 15),
(434, '2025-01-07', '14:30:00', 4, 16),
(435, '2025-01-07', '18:30:00', 4, 17),

-- 2025-01-08
(436, '2025-01-08', '10:00:00', 1, 18),
(437, '2025-01-08', '14:00:00', 1, 19),
(438, '2025-01-08', '18:00:00', 1, 20),
(439, '2025-01-08', '22:00:00', 1, 21),
(440, '2025-01-08', '10:15:00', 2, 15),
(441, '2025-01-08', '14:15:00', 2, 16),
(442, '2025-01-08', '18:15:00', 2, 17),
(443, '2025-01-08', '22:15:00', 2, 18),
(444, '2025-01-08', '11:00:00', 3, 19),
(445, '2025-01-08', '15:00:00', 3, 20),
(446, '2025-01-08', '19:00:00', 3, 21),
(447, '2025-01-08', '23:00:00', 3, 15),
(448, '2025-01-08', '10:30:00', 4, 16),
(449, '2025-01-08', '14:30:00', 4, 17),
(450, '2025-01-08', '18:30:00', 4, 18),

-- 2025-01-09
(451, '2025-01-09', '10:00:00', 1, 19),
(452, '2025-01-09', '14:00:00', 1, 20),
(453, '2025-01-09', '18:00:00', 1, 21),
(454, '2025-01-09', '22:00:00', 1, 15),
(455, '2025-01-09', '10:15:00', 2, 16),
(456, '2025-01-09', '14:15:00', 2, 17),
(457, '2025-01-09', '18:15:00', 2, 18),
(458, '2025-01-09', '22:15:00', 2, 19),
(459, '2025-01-09', '11:00:00', 3, 20),
(460, '2025-01-09', '15:00:00', 3, 21),
(461, '2025-01-09', '19:00:00', 3, 15),
(462, '2025-01-09', '23:00:00', 3, 16),
(463, '2025-01-09', '10:30:00', 4, 17),
(464, '2025-01-09', '14:30:00', 4, 18),
(465, '2025-01-09', '18:30:00', 4, 19),

-- 2025-01-10
(466, '2025-01-10', '10:00:00', 1, 20),
(467, '2025-01-10', '14:00:00', 1, 21),
(468, '2025-01-10', '18:00:00', 1, 15),
(469, '2025-01-10', '22:00:00', 1, 16),
(470, '2025-01-10', '10:15:00', 2, 17),
(471, '2025-01-10', '14:15:00', 2, 18),
(472, '2025-01-10', '18:15:00', 2, 19),
(473, '2025-01-10', '22:15:00', 2, 20),
(474, '2025-01-10', '11:00:00', 3, 21),
(475, '2025-01-10', '15:00:00', 3, 15),
(476, '2025-01-10', '19:00:00', 3, 16),
(477, '2025-01-10', '23:00:00', 3, 17),
(478, '2025-01-10', '10:30:00', 4, 18),
(479, '2025-01-10', '14:30:00', 4, 19),
(480, '2025-01-10', '18:30:00', 4, 20),

-- 2025-01-11
(481, '2025-01-11', '10:00:00', 1, 22),
(482, '2025-01-11', '14:00:00', 1, 23),
(483, '2025-01-11', '18:00:00', 1, 24),
(484, '2025-01-11', '22:00:00', 1, 25),
(485, '2025-01-11', '10:15:00', 2, 26),
(486, '2025-01-11', '14:15:00', 2, 27),
(487, '2025-01-11', '18:15:00', 2, 28),
(488, '2025-01-11', '22:15:00', 2, 22),
(489, '2025-01-11', '11:00:00', 3, 23),
(490, '2025-01-11', '15:00:00', 3, 24),
(491, '2025-01-11', '19:00:00', 3, 25),
(492, '2025-01-11', '23:00:00', 3, 26),
(493, '2025-01-11', '10:30:00', 4, 27),
(494, '2025-01-11', '14:30:00', 4, 28),
(495, '2025-01-11', '18:30:00', 4, 22),

-- 2025-01-12
(496, '2025-01-12', '10:00:00', 1, 23),
(497, '2025-01-12', '14:00:00', 1, 24),
(498, '2025-01-12', '18:00:00', 1, 25),
(499, '2025-01-12', '22:00:00', 1, 26),
(500, '2025-01-12', '10:15:00', 2, 27),
(501, '2025-01-12', '14:15:00', 2, 28),
(502, '2025-01-12', '18:15:00', 2, 22),
(503, '2025-01-12', '22:15:00', 2, 23),
(504, '2025-01-12', '11:00:00', 3, 24),
(505, '2025-01-12', '15:00:00', 3, 25),
(506, '2025-01-12', '19:00:00', 3, 26),
(507, '2025-01-12', '23:00:00', 3, 27),
(508, '2025-01-12', '10:30:00', 4, 28),
(509, '2025-01-12', '14:30:00', 4, 22),
(510, '2025-01-12', '18:30:00', 4, 23),

-- 2025-01-13
(511, '2025-01-13', '10:00:00', 1, 24),
(512, '2025-01-13', '14:00:00', 1, 25),
(513, '2025-01-13', '18:00:00', 1, 26),
(514, '2025-01-13', '22:00:00', 1, 27),
(515, '2025-01-13', '10:15:00', 2, 28),
(516, '2025-01-13', '14:15:00', 2, 22),
(517, '2025-01-13', '18:15:00', 2, 23),
(518, '2025-01-13', '22:15:00', 2, 24),
(519, '2025-01-13', '11:00:00', 3, 25),
(520, '2025-01-13', '15:00:00', 3, 26),
(521, '2025-01-13', '19:00:00', 3, 27),
(522, '2025-01-13', '23:00:00', 3, 28),
(523, '2025-01-13', '10:30:00', 4, 22),
(524, '2025-01-13', '14:30:00', 4, 23),
(525, '2025-01-13', '18:30:00', 4, 24),

-- 2025-01-14
(526, '2025-01-14', '10:00:00', 1, 25),
(527, '2025-01-14', '14:00:00', 1, 26),
(528, '2025-01-14', '18:00:00', 1, 27),
(529, '2025-01-14', '22:00:00', 1, 28),
(530, '2025-01-14', '10:15:00', 2, 22),
(531, '2025-01-14', '14:15:00', 2, 23),
(532, '2025-01-14', '18:15:00', 2, 24),
(533, '2025-01-14', '22:15:00', 2, 25),
(534, '2025-01-14', '11:00:00', 3, 26),
(535, '2025-01-14', '15:00:00', 3, 27),
(536, '2025-01-14', '19:00:00', 3, 28),
(537, '2025-01-14', '23:00:00', 3, 22),
(538, '2025-01-14', '10:30:00', 4, 23),
(539, '2025-01-14', '14:30:00', 4, 24),
(540, '2025-01-14', '18:30:00', 4, 25),

-- 2025-01-15
(541, '2025-01-15', '10:00:00', 1, 26),
(542, '2025-01-15', '14:00:00', 1, 27),
(543, '2025-01-15', '18:00:00', 1, 28),
(544, '2025-01-15', '22:00:00', 1, 22),
(545, '2025-01-15', '10:15:00', 2, 23),
(546, '2025-01-15', '14:15:00', 2, 24),
(547, '2025-01-15', '18:15:00', 2, 25),
(548, '2025-01-15', '22:15:00', 2, 26),
(549, '2025-01-15', '11:00:00', 3, 27),
(550, '2025-01-15', '15:00:00', 3, 28),
(551, '2025-01-15', '19:00:00', 3, 22),
(552, '2025-01-15', '23:00:00', 3, 23),
(553, '2025-01-15', '10:30:00', 4, 24),
(554, '2025-01-15', '14:30:00', 4, 25),
(555, '2025-01-15', '18:30:00', 4, 26),

-- 2025-01-16
(556, '2025-01-16', '10:00:00', 1, 27),
(557, '2025-01-16', '14:00:00', 1, 28),
(558, '2025-01-16', '18:00:00', 1, 22),
(559, '2025-01-16', '22:00:00', 1, 23),
(560, '2025-01-16', '10:15:00', 2, 24),
(561, '2025-01-16', '14:15:00', 2, 25),
(562, '2025-01-16', '18:15:00', 2, 26),
(563, '2025-01-16', '22:15:00', 2, 27),
(564, '2025-01-16', '11:00:00', 3, 28),
(565, '2025-01-16', '15:00:00', 3, 22),
(566, '2025-01-16', '19:00:00', 3, 23),
(567, '2025-01-16', '23:00:00', 3, 24),
(568, '2025-01-16', '10:30:00', 4, 25),
(569, '2025-01-16', '14:30:00', 4, 26),
(570, '2025-01-16', '18:30:00', 4, 27),

-- 2025-01-17
(571, '2025-01-17', '10:00:00', 1, 29),
(572, '2025-01-17', '14:00:00', 1, 30),
(573, '2025-01-17', '18:00:00', 1, 31),
(574, '2025-01-17', '22:00:00', 1, 32),
(575, '2025-01-17', '10:15:00', 2, 33),
(576, '2025-01-17', '14:15:00', 2, 34),
(577, '2025-01-17', '18:15:00', 2, 35),
(578, '2025-01-17', '22:15:00', 2, 29),
(579, '2025-01-17', '11:00:00', 3, 30),
(580, '2025-01-17', '15:00:00', 3, 31),
(581, '2025-01-17', '19:00:00', 3, 32),
(582, '2025-01-17', '23:00:00', 3, 33),
(583, '2025-01-17', '10:30:00', 4, 34),
(584, '2025-01-17', '14:30:00', 4, 35),
(585, '2025-01-17', '18:30:00', 4, 29),

-- 2025-01-18
(586, '2025-01-18', '10:00:00', 1, 30),
(587, '2025-01-18', '14:00:00', 1, 31),
(588, '2025-01-18', '18:00:00', 1, 32),
(589, '2025-01-18', '22:00:00', 1, 33),
(590, '2025-01-18', '10:15:00', 2, 34),
(591, '2025-01-18', '14:15:00', 2, 35),
(592, '2025-01-18', '18:15:00', 2, 29),
(593, '2025-01-18', '22:15:00', 2, 30),
(594, '2025-01-18', '11:00:00', 3, 31),
(595, '2025-01-18', '15:00:00', 3, 32),
(596, '2025-01-18', '19:00:00', 3, 33),
(597, '2025-01-18', '23:00:00', 3, 34),
(598, '2025-01-18', '10:30:00', 4, 35),
(599, '2025-01-18', '14:30:00', 4, 29),
(600, '2025-01-18', '18:30:00', 4, 30),

-- 2025-01-19
(601, '2025-01-19', '10:00:00', 1, 31),
(602, '2025-01-19', '14:00:00', 1, 32),
(603, '2025-01-19', '18:00:00', 1, 33),
(604, '2025-01-19', '22:00:00', 1, 34),
(605, '2025-01-19', '10:15:00', 2, 35),
(606, '2025-01-19', '14:15:00', 2, 29),
(607, '2025-01-19', '18:15:00', 2, 30),
(608, '2025-01-19', '22:15:00', 2, 31),
(609, '2025-01-19', '11:00:00', 3, 32),
(610, '2025-01-19', '15:00:00', 3, 33),
(611, '2025-01-19', '19:00:00', 3, 34),
(612, '2025-01-19', '23:00:00', 3, 35),
(613, '2025-01-19', '10:30:00', 4, 29),
(614, '2025-01-19', '14:30:00', 4, 30),
(615, '2025-01-19', '18:30:00', 4, 31),

-- 2025-01-20
(616, '2025-01-20', '10:00:00', 1, 32),
(617, '2025-01-20', '14:00:00', 1, 33),
(618, '2025-01-20', '18:00:00', 1, 34),
(619, '2025-01-20', '22:00:00', 1, 35),
(620, '2025-01-20', '10:15:00', 2, 29),
(621, '2025-01-20', '14:15:00', 2, 30),
(622, '2025-01-20', '18:15:00', 2, 31),
(623, '2025-01-20', '22:15:00', 2, 32),
(624, '2025-01-20', '11:00:00', 3, 33),
(625, '2025-01-20', '15:00:00', 3, 34),
(626, '2025-01-20', '19:00:00', 3, 35),
(627, '2025-01-20', '23:00:00', 3, 29),
(628, '2025-01-20', '10:30:00', 4, 30),
(629, '2025-01-20', '14:30:00', 4, 31),
(630, '2025-01-20', '18:30:00', 4, 32),

-- 2025-01-21
(631, '2025-01-21', '10:00:00', 1, 33),
(632, '2025-01-21', '14:00:00', 1, 34),
(633, '2025-01-21', '18:00:00', 1, 35),
(634, '2025-01-21', '22:00:00', 1, 29),
(635, '2025-01-21', '10:15:00', 2, 30),
(636, '2025-01-21', '14:15:00', 2, 31),
(637, '2025-01-21', '18:15:00', 2, 32),
(638, '2025-01-21', '22:15:00', 2, 33),
(639, '2025-01-21', '11:00:00', 3, 34),
(640, '2025-01-21', '15:00:00', 3, 35),
(641, '2025-01-21', '19:00:00', 3, 29),
(642, '2025-01-21', '23:00:00', 3, 30),
(643, '2025-01-21', '10:30:00', 4, 31),
(644, '2025-01-21', '14:30:00', 4, 32),
(645, '2025-01-21', '18:30:00', 4, 33),

-- 2025-01-22
(646, '2025-01-22', '10:00:00', 1, 34),
(647, '2025-01-22', '14:00:00', 1, 35),
(648, '2025-01-22', '18:00:00', 1, 29),
(649, '2025-01-22', '22:00:00', 1, 30),
(650, '2025-01-22', '10:15:00', 2, 31),
(651, '2025-01-22', '14:15:00', 2, 32),
(652, '2025-01-22', '18:15:00', 2, 33),
(653, '2025-01-22', '22:15:00', 2, 34),
(654, '2025-01-22', '11:00:00', 3, 35),
(655, '2025-01-22', '15:00:00', 3, 29),
(656, '2025-01-22', '19:00:00', 3, 30),
(657, '2025-01-22', '23:00:00', 3, 31),
(658, '2025-01-22', '10:30:00', 4, 32),
(659, '2025-01-22', '14:30:00', 4, 33),
(660, '2025-01-22', '18:30:00', 4, 34);



-- Inserting into table 'Seat'

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

-- Inserting into table 'TicketPrice'

INSERT INTO TicketPrice (Type, Price, ValidFrom, ValidTo)
VALUES
('Standard', 135.00, NULL, NULL),
('Child', 100.00, NULL, NULL),
('Senior', 110.00, NULL, NULL),
('VIP', 200.00, NULL, NULL),
('Weekend Special', 120.00, '2024-12-01', '2024-12-31');  

-- Inserting into table 'News'

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

-- Inserting into table 'Company'

INSERT INTO Company (Company_ID, Name, Description, OpeningHours, Email, Location)
VALUES 
('1',
 'FilmFusion', 
 'FilmFusion is your destination for an unparalleled cinema experience, blending the latest technology with a warm, welcoming ambiance. Located in the heart of MovieTown, FilmFusion features a mix of blockbuster films, independent cinema, and exclusive screenings that cater to all tastes. Our venue boasts luxurious reclining seats, advanced Dolby Atmos surround sound, and crystal-clear 4K projection in every theater. With spacious aisles, gourmet concessions, and a dedicated lounge for VIP members, FilmFusion transforms moviegoing into a memorable event. Our team is committed to exceptional service, ensuring each guest feels like a star. Whether you\'re here for a family outing, a date night, or a solo escape into the magic of film, FilmFusion offers a viewing experience that\'s both comfortable and captivating. Join us for seasonal film festivals, midnight premieres, and our signature “Retro Movie Nights” that celebrate the classics. FilmFusion—where the magic of cinema comes alive.',
 'Mon-Fri: 10:00 AM - 11:00 PM; Sat-Sun: 9:00 AM - 12:00 PM;', 
 'contact@filmfusion.com', 
 'Grådybet 73E 8 47, Esbjerg, 6700, Denmark');

-- Inserting into table 'Media'

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