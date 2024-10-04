DROP DATABASE IF EXISTS dwp;
CREATE DATABASE dwp;
USE dwp;

-- Create Genre table
CREATE TABLE Genre (
    GenreID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    Description TEXT
);

-- Create Version table
CREATE TABLE Version (
    VersionID INT PRIMARY KEY AUTO_INCREMENT,
    Format VARCHAR(255) NOT NULL,
    AdditionalFee DECIMAL(10, 2) DEFAULT 0
);

-- Create Movie table (Added VersionID FK)
CREATE TABLE Movie (
    MovieID INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(255) NOT NULL,
    Director VARCHAR(255),
    Language VARCHAR(50),
    Year INT,
    Duration INT,
    Rating VARCHAR(10),
    Description TEXT,
    GenreID INT,
    VersionID INT,  -- Added VersionID
    FOREIGN KEY (GenreID) REFERENCES Genre(GenreID),
    FOREIGN KEY (VersionID) REFERENCES Version(VersionID)  -- FK to Version
);

-- Create CinemaHall table
CREATE TABLE CinemaHall (
    CinemaHallID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    TotalSeats INT NOT NULL
);

-- Create Screening table (reference MovieID not MovieTitle)
CREATE TABLE Screening (
    ScreeningID INT PRIMARY KEY AUTO_INCREMENT,
    MovieID INT,
    ShowTime DATETIME NOT NULL,
    CinemaHallID INT,
    FOREIGN KEY (MovieID) REFERENCES Movie(MovieID),
    FOREIGN KEY (CinemaHallID) REFERENCES CinemaHall(CinemaHallID)
);

-- Create Seat table
CREATE TABLE Seat (
    SeatID INT PRIMARY KEY AUTO_INCREMENT,
    SeatNumber VARCHAR(10) NOT NULL,
    Row VARCHAR(10),
    Status ENUM('Available', 'Booked') DEFAULT 'Available',
    CinemaHallID INT,
    FOREIGN KEY (CinemaHallID) REFERENCES CinemaHall(CinemaHallID)
);

-- Create Coupon table
CREATE TABLE Coupon (
    CouponID INT PRIMARY KEY AUTO_INCREMENT,
    CouponCode VARCHAR(50) NOT NULL UNIQUE,
    DiscountAmount DECIMAL(10, 2) NOT NULL
);

-- Create Ticket table
CREATE TABLE Ticket (
    TicketID INT PRIMARY KEY AUTO_INCREMENT,
    TotalPrice DECIMAL(10, 2) NOT NULL,
    Type VARCHAR(50),
    ScreeningID INT,
    SeatID INT,
    CouponID INT,
    FOREIGN KEY (ScreeningID) REFERENCES Screening(ScreeningID),
    FOREIGN KEY (SeatID) REFERENCES Seat(SeatID),
    FOREIGN KEY (CouponID) REFERENCES Coupon(CouponID)
);

-- Create Profile table (removed UNSIGNED)
CREATE TABLE Profile (
    ProfileID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    Email VARCHAR(255),
    TelephoneNumber VARCHAR(20)
);

-- Create User table
CREATE TABLE `User` (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    TelephoneNumber VARCHAR(20),
    ProfileID INT,
    FOREIGN KEY (ProfileID) REFERENCES Profile(ProfileID)
);

-- Create Booking table
CREATE TABLE Booking (
    BookingID INT PRIMARY KEY AUTO_INCREMENT,
    MovieID INT,
    UserID INT,
    TicketID INT,
    NumberOfTickets INT NOT NULL,
    BookingDate DATETIME NOT NULL,
    PaymentStatus ENUM('Pending', 'Completed') DEFAULT 'Pending',
    TotalPrice DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (MovieID) REFERENCES Movie(MovieID),
    FOREIGN KEY (UserID) REFERENCES `User`(UserID),
    FOREIGN KEY (TicketID) REFERENCES Ticket(TicketID)
);
