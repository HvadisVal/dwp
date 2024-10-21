DROP DATABASE IF EXISTS dwp;
CREATE DATABASE dwp;
USE dwp;

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
    Genre_ID INT,
    Version_ID INT,
    FOREIGN KEY (Genre_ID) REFERENCES Genre(Genre_ID),
    FOREIGN KEY (Version_ID) REFERENCES Version(Version_ID)
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