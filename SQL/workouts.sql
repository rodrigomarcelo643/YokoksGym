CREATE TABLE workouts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    exercise VARCHAR(255) NOT NULL,
    duration INT NOT NULL,
    kg INT NOT NULL,
    reps INT NOT NULL,
    notes TEXT,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (username) REFERENCES members(username) ON DELETE CASCADE
);
