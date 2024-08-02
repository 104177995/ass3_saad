CREATE TABLE IF NOT EXISTS users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    pwd VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS parkingSlots (
    slotID INT AUTO_INCREMENT PRIMARY KEY,
    loc VARCHAR(255) NOT NULL,
    timeSlot DATETIME NOT NULL,
    lotNumber INT NOT NULL,
    vehicleType VARCHAR(50) NOT NULL,
    userID INT,
    imageSlot VARCHAR(255),
    FOREIGN KEY (userID) REFERENCES users(userID)
);

INSERT INTO users (email, pwd) VALUES 
('user1@gmail.com', 'password1'),
('user2@gmail.com', 'password2'),
('user3@gmail.com', 'password3');

INSERT INTO parkingSlots (loc, timeSlot, lotNumber, vehicleType, imageSlot) VALUES
('80 Duy Tan', '2024-12-01 08:00:00', 1, 'car', 'https://static.vecteezy.com/system/resources/thumbnails/008/957/252/small_2x/flat-red-car-icon-clipart-in-cartoon-graphic-illustration-design-vector.jpg'),
('80 Duy Tan', '2024-12-01 08:30:00', 2, 'motorbike', 'https://i.pinimg.com/564x/84/4a/30/844a30f588f42e18cae21e0e0430ce25.jpg'),
('80 Duy Tan', '2024-12-01 09:00:00', 3, 'car', 'https://static.vecteezy.com/system/resources/thumbnails/008/957/252/small_2x/flat-red-car-icon-clipart-in-cartoon-graphic-illustration-design-vector.jpg'),
('80 Duy Tan', '2024-12-01 09:30:00', 4, 'motorbike', 'https://i.pinimg.com/564x/84/4a/30/844a30f588f42e18cae21e0e0430ce25.jpg'),
('80 Duy Tan', '2024-12-01 10:00:00', 5, 'car', 'https://static.vecteezy.com/system/resources/thumbnails/008/957/252/small_2x/flat-red-car-icon-clipart-in-cartoon-graphic-illustration-design-vector.jpg'),
('80 Duy Tan', '2024-12-01 10:30:00', 6, 'motorbike', 'https://i.pinimg.com/564x/84/4a/30/844a30f588f42e18cae21e0e0430ce25.jpg'),
('80 Duy Tan', '2024-12-01 11:00:00', 7, 'car', 'https://static.vecteezy.com/system/resources/thumbnails/008/957/252/small_2x/flat-red-car-icon-clipart-in-cartoon-graphic-illustration-design-vector.jpg'),
('80 Duy Tan', '2024-12-01 11:30:00', 8, 'motorbike', 'https://i.pinimg.com/564x/84/4a/30/844a30f588f42e18cae21e0e0430ce25.jpg'),
('80 Duy Tan', '2024-12-01 12:00:00', 9, 'car', 'https://static.vecteezy.com/system/resources/thumbnails/008/957/252/small_2x/flat-red-car-icon-clipart-in-cartoon-graphic-illustration-design-vector.jpg'),
('80 Duy Tan', '2024-12-01 12:30:00', 10, 'motorbike', 'https://i.pinimg.com/564x/84/4a/30/844a30f588f42e18cae21e0e0430ce25.jpg');