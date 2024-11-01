CREATE table users (
    userID INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50),
    email VARCHAR(50),
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE table admins (
    adminID INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50),
    email VARCHAR(50),
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE GPUs (
    gpuID INT PRIMARY KEY AUTO_INCREMENT,
    brand VARCHAR(50),
    model VARCHAR(50),
    price FLOAT,
    in_stock BOOLEAN
);

CREATE TABLE SALES (
    saleID INT PRIMARY KEY AUTO_INCREMENT,
    gpuID INT,
    quantity INT,
    total_price FLOAT
);
